<?php

include_once(dirname(__FILE__) . '/../actionparent/AlunoActionParent.php');

class AlunoAction extends AlunoActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    public function confirmarCadastro($id) {
        $oAluno = $this->em->find('Aluno', array('id' => $id));
        $oAluno->setModerado('S');
        try {
            $this->em->beginTransaction();

            $this->em->persist($oAluno);
            $this->em->flush($oAluno);

            $this->em->commit();
        } catch (Exception $e) {
            throw $e;
            $this->setMsg($e);
            $this->em->rollback();
            return false;
        }

        return true;
    }

    public function validateCriaConta(&$request) {
        if ($request->get("nome") == '') {
            throw new Exception("Por favor, preencha o campo Nome!");
        }
        if ($request->get("cpf") == '') {
            throw new Exception("Por favor, selecione o CPF!");
        } else {
            $request->set('cpf', Util::unMaskCpf($request->get('cpf')));
            if (!Util::validaCpf($request->get("cpf"))) {
                throw new Exception("Por favor, preencha um CPF válido!");
            }
        }
        if ($request->get("senha") == '') {
            throw new Exception("Por favor, preencha o campo Senha!");
        }
        if ($request->get("senhaConf") == '') {
            throw new Exception("Por favor, preencha o campo Confirmar Senha!");
        }
        if ($request->get("login") == '') {
            throw new Exception("Por favor, preencha o campo Usuário!");
        }
        if ($request->get("email") == '') {
            throw new Exception("Por favor, preencha o campo Email!");
        } else {
            if (!Util::validaEmail($request->get("email"))) {
                throw new Exception("Por favor, informe o campo E-mail corretamente!");
            }
        }
        if ($request->get("dataNascimento") == '') {
            throw new Exception("Por favor, preencha o campo Data de Nascimento!");
        } else {

            if (!Validate::validateDate($request->get("dataNascimento"))) {
                throw new Exception("Formato inválido do campo Data de Nascimento!");
            } else {
                $request->set('dataNascimento', Util::transformaData($request->get('dataNascimento'), 'normal2mysql'));
            }
        }

        if ($request->get("sexo") == '') {
            throw new Exception("Por favor, selecione o Sexo!");
        }
        if ($request->get("cidade") == '') {
            throw new Exception("Por favor, preencha o campo Cidade!");
        }
        if ($request->get("estado") == '') {
            throw new Exception("Por favor, preencha o campo Estado!");
        }
        if ($request->get("instituicaoEnsino") == '') {
            throw new Exception("Por favor, preencha o campo Instituição de Ensino!");
        }
        if (strlen($request->get("senha")) < 6) {
            throw new Exception("Por favor, sua Senha Atual tem que ter no mínimo 6 dígitos!");
        }
        if ($request->get("senha") != $request->get("senhaConf")) {
            throw new Exception("Senhas não conferem!");
        } else {
            $request->set("senha", sha1($request->get("senha")));
        }
        $request->set("recuperaSenhaHash", NULL);
        $request->set("criarContaHash", NULL);
        $request->set("ativo", "S");
        $request->set("aceiteTermo", "N");
        $request->set("moderado", "N");


        #verifica se o email ja está cadastrado

        $oAluno = $this->selectByEmail($request->get("email"));
        if ($oAluno) {
            throw new Exception("O email informado já está cadastrado no sistema!");
        }

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
            throw new Exception("Este login está desativado."
            . "<p>Por favor, se você acabou de efetuar cadastro, confirme seu endereço de e-mail clicando no link que lhe foi enviado.</p>"
            . "<p>Caso já tenha efetuado o cadastro e este não seja seu primeiro acesso, entre em contato com o suporte para obter mais informações.</p>"
            );
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

    public function criarConta($request) {
        $this->validateCriaConta($request);

        if ($oAluno = $this->add($request, false, true, false)) {
            #retirado conforme tarefa #1600 do redmine 
            /* $criarContaHash = Util::geraHash();

              $qb = $this->em->createQueryBuilder();
              $where = QueryHelper::getAndEquals(array('o.id' => $oAluno->getId()), $qb);
              $query = $qb->update("Aluno", "o")
              ->set('o.criarContaHash', "'$criarContaHash'")
              ->where($where)->getQuery();

              $url_redirect = URL_CRIAR_CONTA_CONFIRMA . "{$oAluno->getEmail()}/{$criarContaHash}/";
              //        exit($url_redirect);

              try {
              $this->em->beginTransaction();
              $query->execute();

              $title = "Criação de Conta - " . APPLICATION_NAME;
              $body = "Clique <a href='" . $url_redirect . "' style='text-decoration: underline;' target='_blank'>aqui</a> para confirmar sua conta!";
              $aEmail = array($oAluno->getEmail() => $oAluno->getNome());
              Util::mailSystem($title, $body, $aEmail, true);

              $this->em->commit();
              } catch (Exception $e) {
              $this->em->rollback();
              throw $e;
              } */

            try {
                $title = "Criação de Conta - " . APPLICATION_NAME;
                $body = "Foi realizado uma solicitação de cadastro no laboratório virtual.";
                $aEmail = array(EMAIL_MODERADOR => NOME_MODERADOR);
                Util::mailSystem($title, $body, $aEmail, true);

//                $this->em->commit();
            } catch (Exception $e) {
//                $this->em->rollback();
                throw $e;
            }
        }
        return true;
    }

    public function criarContaConfirma(&$request, &$response) {
        $this->validateCriarContaHash($request);

        $oAluno = $this->selectByEmail($request->get("email"));
        try {
            $qb = $this->em->createQueryBuilder();
            $where = QueryHelper::getAndEquals(array("o.id" => $oAluno->getId()), $qb);
            $query = $qb->update("Aluno", "o")
                            ->set("o.ativo", "'S'")
                            ->set("o.criarContaHash", 'NULL')
                            ->where($where)->getQuery();
            $query->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return false;
    }

    public function validateCriarContaHash(&$request) {
        $oAluno = $this->selectByEmail($request->get("email"));
        if (!$oAluno) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }
        if ($oAluno->getCriarContaHash() != $request->get("hash")) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }

        $request->set("id", $oAluno->getId());
        return true;
    }

    public function aceitaTermo($id) {
        $oAluno = $this->em->find('Aluno', array('id' => $id));
        $oAluno->setAceiteTermo('S');
        try {
            $this->em->beginTransaction();

            $this->em->persist($oAluno);
            $this->em->flush($oAluno);

            $this->em->commit();
        } catch (Exception $e) {
            throw $e;
            $this->setMsg($e);
            $this->em->rollback();
            return false;
        }

        return true;
    }

    public function validateLogin(&$request) {
        if ($request->get("login") == '') {
            throw new Exception("Por favor, preencha o campo Usuário!");
        }
        if ($request->get("loginFacial")) {
            if ($request->get("aFotoUpload")) {
                throw new Exception("Por favor, bata uma foto foto");
            }
        } else {
            if ($request->get("senha") == '') {
                throw new Exception("Por favor, preencha o campo Senha!");
            }
        }
        return true;
    }

    public function loginSubmit($request, &$response) {
        try {
            $oAluno = $this->selectByLogin($request->get("login"));
        } catch (Exception $e) {
            throw new Exception("O login ou a senha inserida está incorreto.");
        }
        if (!$oAluno) {
            throw new Exception("O login ou a senha inserida está incorreto.");
        }
        if ($oAluno->getAtivo() != "S") {
            throw new Exception("Este login está desativado."
            . "<p>Por favor, se você acabou de efetuar cadastro, confirme seu endereço de e-mail clicando no link que lhe foi enviado.</p>"
            . "<p>Caso já tenha efetuado o cadastro e este não seja seu primeiro acesso, entre em contato com o suporte para obter mais informações.</p>"
            );
        }
        if ($oAluno->getModerado() != "S") {
            throw new Exception("Este login está aguardado ativação."
            . "<p>Por favor, se você acabou de efetuar cadastro, aguarde 24 horas.</p>"
            );
        }

        if ($request->get('loginFacial')) {
            $foto = $request->get('afotoUpload');
            $output = shell_exec("python3 facial_recognition_login_image.py --cascade haarcascade_frontalface_default.xml --encodings upload/encodings/{$oAluno->getId()}/encodings.pickle --image {$foto['tmp_name']} --login {$oAluno->getLogin()}");
            
            $aRetorno = json_decode($output, true);
            if($aRetorno['loginSuccess']){
                return true;
            } else {
                throw new Exception("Seu rosto não foi reconhecido! Tente usar a senha!");
            }
        } else {
            if ($oAluno->getSenha() != sha1($request->get("senha"))) {
                throw new Exception("O login ou a senha inserido está incorreto.");
            }
        }

        $this->defineSessaoAluno($oAluno);
        $this->defineCookieRemember($oAluno, $request);

        try {
            $oAlunoAcesso = new AlunoAcessoAction($this->em);
            $oAlunoAcesso->register("LOG");
        } catch (Exception $e) {
            throw new Exception($e);
        }

        $aJson = array(
            "status" => "OK",
            "name" => $oAluno->getNome(),
        );
        $response->set("json", $aJson);

        return true;
    }

    public function defineSessaoAluno($oAluno) {
        $oAluno->setSenha("");

        $_SESSION['alunoNome'] = $oAluno->getNome();
        $_SESSION['alunoLogin'] = $oAluno->getLogin();
        # para primeiro login
        $_SESSION['alunoWelcome'] = 1;
        # caso ele não tenha aceitado
        $_SESSION['alunoTermo'] = $oAluno->getAceiteTermo();
        $_SESSION['serAlunoSessao'] = serialize($oAluno);
    }

    public function defineCookieRemember($oAluno, $request) {
        if ($request->get("remember")) {
            $dias = time() + 172800; // 48 horas
            setcookie("login_digitado" . SESSION_NAME, $oAluno->getLogin(), $dias, "/");
            if ($_SERVER['SERVER_NAME'] === "localhost" || $_SERVER['SERVER_NAME'] === "127.0.0.1") # grava a senha local - PARA NUNCA MAIS DIGITAR DE NOVO
                setcookie("senha_digitado" . SESSION_NAME, $request->get("senha"), $dias, "/");
        } else {
            $del = time() - 3600; // del agora
            setcookie("login_digitado" . SESSION_NAME, $oAluno->getLogin(), $del, "/");
            setcookie("senha_digitado" . SESSION_NAME, "", $del, "/");
        }
    }

    public static function recuperaObjetoAluno($em = null) {
        if (!isset($_SESSION['serAlunoSessao']))
            return false;
        if (!$em) {
            $db = new DoctrineBootstrap();
            $em = $db->iGenialConnection();
        }
        $aux = unserialize($_SESSION['serAlunoSessao']);
        $oAlunoAction = new AlunoAction($em);
        $o = $oAlunoAction->select($aux->getId());

        return $o;
    }

    public function alunoAutenticado($isOnlyAuthenticated = false) {
        if (!isset($_SESSION['serAlunoSessao'])) {
            $this->setMsg("Faça Login para acessar esta página.");
            return false;
        } else {
            return true;
        }
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

        return true;
    }

    public function validateRecuperarSenhaHash(&$request) {
        $oAluno = $this->selectByEmail($request->get("email"));
        if (!$oAluno) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }
        if ($oAluno->getRecuperaSenhaHash() != $request->get("hash")) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }

        $data = ($oAluno->getRecuperaSenhaData()->format('c'));
        $diferenca = Util::diferencaDataEmDias(Util::transformaData($data), date("d/m/Y"));
        if ($diferenca > 1) {
            throw new Exception("URL inválida, repita o processo e siga as orientações do seu e-mail.");
        }
        $request->set("id", $oAluno->getId());
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
        $query = $qb->update("Aluno", "o")
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

    protected function addTransaction($oAluno, $request) {
        try {
            if ($request->get("loginFacial")) {
                $afotoUpload = $request->get("afotoUpload");
                $i = 0;
                for ($i = 0; $i < count($afotoUpload["name"]); $i++) {
                    FileUtil::makeFileUploadPosicao("dataset/{$oAluno->getId()}", $i + 1, 'afotoUpload', $i, false);
                }

                #gerar o pickle
                $pickle = shell_exec("python3 decodificador_faces.py --dataset upload/dataset/1_Fabiano --encodings upload~/encodings/{$oAluno->getId()}/encodings.pickle --detection-method hog");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

}

?>