<?php

include_once(dirname(__FILE__) . '/../actionparent/UsuarioActionParent.php');

class UsuarioAction extends UsuarioActionParent {

    public function validate(&$request, $edicao = false) {
        if (!$edicao)
            $request->set("superuser", "N");
        $request->set("recuperaSenhaHash", null);

        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        if ($request->get("email") != '') {
            if (!Util::validaEmail($request->get("email"))) {
                throw new Exception("Por favor, informe o campo E-mail corretamente!");
            }
        }

        if (!$edicao) {
            if ($request->get("senha") == '') {
                throw new Exception("Por favor, informe o campo Senha!");
            }
            if (strlen($request->get("senha")) < 6) {
                throw new Exception("Por favor, sua Senha Atual tem que ter no mínimo 6 dígitos!");
            }
            if ($request->get("senha") != $request->get("senhaConf")) {
                throw new Exception("Senhas não conferem!");
            } else {
                $request->set("senha", sha1($request->get("senha")));
            }
        }

        if (!$request->get('dataFinal')) {
            $request->destroy('dataFinal');
        }

        return true;
    }

    public function validateLogin(&$request) {
        if ($request->get("login") == '') {
            throw new Exception("Por favor, preencha o campo Usuário!");
        }
        if ($request->get("senha") == '') {
            throw new Exception("Por favor, preencha o campo Senha!");
        }
        return true;
    }

    public function loginSubmit($request, &$response) {
        try {
            $oUsuario = $this->selectByLogin($request->get("login"));
        } catch (Exception $e) {
            throw new Exception("O nome de usuário ou a senha inserida está incorreto.");
        }
        if (!$oUsuario) {
            throw new Exception("O nome de usuário ou a senha inserida está incorreto.");
        }
        if ($oUsuario->getAtivo() != "S") {
            throw new Exception("Este login foi desativado.<br/>Entre em contato com o suporte para mais informações.");
        }
        if ($oUsuario->getSenha() != sha1($request->get("senha"))) {
            throw new Exception("O nome de usuário ou a senha inserido está incorreto.");
        }

        if ($oUsuario->getDataFinal() && Util::comparaData($oUsuario->getDataInicio()->format("d/m/Y"), ">", $oUsuario->getDataFinal()->format("d/m/Y"))) {
            throw new Exception("Este login vigora de {$oUsuario->getDataInicio()->format("d/m/Y")} a {$oUsuario->getDataFinal()->format("d/m/Y")}.<br/>Entre em contato com o suporte para mais informações.");
        }

        if ($oUsuario->getDataFinal() && Util::comparaData($oUsuario->getDataFinal()->format("d/m/Y"), "<", date("d/m/Y"))) {
            throw new Exception("Este login expirou em {$oUsuario->getDataFinal()->format("d/m/Y")}.<br/>Entre em contato com o suporte para mais informações.");
        }

        $this->defineSessaoUsuario($oUsuario);
        $this->defineCookieRemember($oUsuario, $request);


        try {
            $oLog = new LogAction();
            $oLog->register("A", "Acesso ao sistema", true);
        } catch (Exception $e) {
            throw new Exception($e);
        }
        $aJson = array(
            "status" => "OK",
            "name" => $oUsuario->getNome(),
            "src" => MediaUtil::getLinkForFileNameById('Usuario', "{$oUsuario->getId()}_t")
        );
        $response->set("json", $aJson);

        return true;
    }

    public function defineSessaoUsuario($oUsuario) {
        $oUsuario->setSenha("");

        $_SESSION['usuarioNome'] = $oUsuario->getNome();
        $_SESSION['usuarioLogin'] = $oUsuario->getLogin();
        $_SESSION['usuarioPerfil'] = $oUsuario->getPerfil()->getNome();
        $_SESSION['serUsuarioSessao'] = serialize($oUsuario);
    }

    public function defineCookieRemember($oUsuario, $request) {
        if ($request->get("remember")) {
            $dias = time() + 172800; // 48 horas
            setcookie("login_digitado" . SESSION_NAME, $oUsuario->getLogin(), $dias, "/");
            if ($_SERVER['SERVER_NAME'] === "localhost" || $_SERVER['SERVER_NAME'] === "127.0.0.1") # grava a senha local - PARA NUNCA MAIS DIGITAR DE NOVO
                setcookie("senha_digitado" . SESSION_NAME, $request->get("senha"), $dias, "/");
        } else {
            $del = time() - 3600; // del agora
            setcookie("login_digitado" . SESSION_NAME, $oUsuario->getLogin(), $del, "/");
            setcookie("senha_digitado" . SESSION_NAME, "", $del, "/");
        }
    }

    public function validateDadosPessoais(&$request) {
        if (!$request->get("nome")) {
            throw new Exception("Por favor, preencha o campo Nome!");
        }
        if (!$request->get("email")) {
            throw new Exception("Por favor, preencha o campo E-mail!");
        }

        $foto = $request->get("foto");
        if ($foto["error"] != 4) {
            if ($foto['error'] != 0 && $foto['size'] <= 0) {
                throw new Exception("Por favor, informe a Foto!");
            }
            $filename = basename($foto['name']);
            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $extensions = Util::recuperaExtensaoImagem();
            $mimes = Util::recuperaTipoImagem();
            $fileMaxSize = 2097152;
            if ($foto["size"] > $fileMaxSize) {
                
            }
            if (!in_array($ext, $extensions) || !in_array($foto['type'], $mimes)) {
                throw new Exception("Atenção: Somente arquivos com a extensão " . join(', ', $extensions) . " são aceitos para upload!");
            }
        }

        $oUsuario = UtilAuth::recuperaObjetoUsuario();
        $request->set("id", $oUsuario->getId());
        return true;
    }

    public function dadosPessoais($request) {
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Usuario", "o")
                ->set('o.nome', "'$nome'")
                ->set('o.email', "'$email'");
        if ($foto['error'] == 0) {
            $query->set('o.foto', "'" . $foto['name'] . "'");
        }
        $query = $query->where($where)->getQuery();
        try {
            $this->em->beginTransaction();
            $query->execute();
            FileUtil::makeFileUpload('Usuario/foto', $id, 'foto', true);
            if ($xfoto >= 0 && $yfoto >= 0) {
                ImageUtil::makeImageCrop('Usuario/foto', $id, 160, 160, $xfoto, $yfoto);
                ImageUtil::makeImageThumb('Usuario/foto', $id, "m", 33, 33, $xfoto, $yfoto);
            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        $oUsuarioAction = new UsuarioAction();
        $oUsuario = $oUsuarioAction->select($id);
        $_SESSION['serUsuario'] = serialize($oUsuario);
        return true;
    }

    public function validateTrocarSenha(&$request, $bRedefinir = false) {
        $oUsuarioAction = new UsuarioAction();
        $o = $bRedefinir ? $oUsuarioAction->select($request->get("id")) : UtilAuth::recuperaObjetoUsuario();

		if (!$bRedefinir) {
			if (!$request->get("senhaAtual")) {
				throw new Exception("Por favor, informe sua Senha Atual!");
			}
			if (strlen($request->get("senhaAtual")) < 6) {
				throw new Exception("Por favor, sua Senha Atual tem que ter no mínimo 6 dígitos!");
			}
			if (sha1($request->get("senhaAtual")) != $o->getSenha()) {
				throw new Exception("Sua senha esta incorreta!");
			}
		}

        if (!$request->get("novaSenha")) {
            throw new Exception("Por favor, preencha o campo Nova Senha!");
        }

        if (strlen($request->get("novaSenha")) < 6) {
            throw new Exception("Por favor, sua Nova Senha tem que ter no mínimo 6 dígitos!");
        }

        if ($request->get("novaSenha") != $request->get("novaSenhaConf")) {
            throw new Exception("Senhas não coincidem!");
        }
        $request->set("id", $o->getId());
        $request->set("novaSenha", sha1($request->get("novaSenha")));
        return true;
    }

    public function trocarSenha($request) {
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Usuario", "o")
                        ->set('o.senha', "'$novaSenha'")
                        ->where($where)->getQuery();
        try {
            $this->em->beginTransaction();
            $query->execute();
            $this->zeraHash($request, false);
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public function validateSolicitaRecuperaSenha(&$request) {
        if ($request->get("email") == '') {
            throw new Exception("Por favor, preencha o campo E-mail!");
        }
        if (!Util::validaEmail($request->get("email"))) {
            throw new Exception("Por favor, informe o E-mail corretamente!");
        }

        $reCaptcha = $request->get("g-recaptcha-response");
        if ($reCaptcha == "") {
            throw new Exception("Por favor, preencha o reCaptcha!");
        }
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_PRIVATE_KEY . "&response=" . $reCaptcha . "&remoteip=" . $_SERVER["REMOTE_ADDR"]);
        $responseKeys = json_decode($response, true);
        if (intval($responseKeys["success"]) !== 1) {
            throw new Exception("Por favor, preencha o reCaptcha corretamente!");
        }
		
		/*
		# the old way
        $reCaptcha = $request->get("recaptcha_response_field");
        if ($reCaptcha == "") {
            throw new Exception("Por favor, preencha o reCaptcha!");
        }
        $reCaptchaChallenge = $request->get("recaptcha_challenge_field");

        $resp = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $reCaptchaChallenge, $reCaptcha);
        if (!$resp->is_valid) {
            throw new Exception("Por favor, preencha o reCaptcha corretamente!");
        }
		*/

        return true;
    }

    public function solicitaRecuperaSenhaSubmit($request) {
        try {
            $oUsuario = $this->selectByEmail($request->get("email"));
        } catch (Exception $e) {
            throw new Exception("O usuário não existe. Verifique o seu E-mail e tente novamente.");
        }
        if (!$oUsuario) {
            throw new Exception("O usuário não existe. Verifique o seu E-mail e tente novamente.");
        }
        if ($oUsuario->getAtivo() != "S") {
            throw new Exception("Este login foi desativado.<br/>Entre em contato com o suporte para mais informações.");
        }

        $recuperaSenhaHash = Util::geraHash();

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $oUsuario->getId()), $qb);
        $query = $qb->update("Usuario", "o")
                        ->set('o.recuperaSenhaData', "'" . date('Y-m-d H:i:s') . "'")
                        ->set('o.recuperaSenhaHash', "'$recuperaSenhaHash'")
                        ->where($where)->getQuery();

        $url_redirect = URL_RECUPERAR_SENHA . "{$oUsuario->getEmail()}/{$recuperaSenhaHash}/";
//        exit($url_redirect);

        try {
            $this->em->beginTransaction();
            $query->execute();
            
			$title = "Recuperar senha - " . APPLICATION_NAME;
            $body = "Clique <a href='" . $url_redirect . "' style='text-decoration: underline;' target='_blank'>aqui</a> para recuperar a sua senha!";
            $aEmail = array($oUsuario->getEmail() => $oUsuario->getNome());
            Util::mailSystem($title, $body, $aEmail, true);

            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public function validateRecuperarSenhaHash(&$request) {
        $oUsuario = $this->selectByEmail($request->get("email"));
        if (!$oUsuario) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }
        if ($oUsuario->getRecuperaSenhaHash() != $request->get("hash")) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }

        $data = ($oUsuario->getRecuperaSenhaData()->format('c'));
        $diferenca = Util::diferencaDataEmDias(Util::transformaData($data), date("d/m/Y"));
        if ($diferenca > 1) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }
        $request->set("id", $oUsuario->getId());
        return true;
    }

    public function validaterRecuperarSenha(&$request) {
        if (!$request->get("novaSenha")) {
            throw new Exception("Por favor, preencha o campo Nova Senha!");
        }

        if (strlen($request->get("novaSenha")) < 6) {
            throw new Exception("Por favor, sua Nova Senha tem que ter no mínimo 6 dígitos!");
        }

        if ($request->get("novaSenha") != $request->get("novaSenhaConf")) {
            throw new Exception("Senhas não coincidem!");
        }

        $request->set("novaSenha", sha1($request->get("novaSenha")));

        return true;
    }

    public function zeraHash($request, $commitable = true) {
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Usuario", "o")
                        ->set('o.recuperaSenhaData', "null")
                        ->set('o.recuperaSenhaHash', "null")
                        ->where($where)->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $query->execute();
            if ($commitable) {
                $this->em->commit();
            }
        } catch (Exception $e) {
            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        return true;
    }

}

?>