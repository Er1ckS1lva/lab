<?php

include_once(dirname(__FILE__) . '/../actionparent/AlunoActionParent.php');

class AlunoAction extends AlunoActionParent {

    public function validate(&$request, $edicao = false) {

        if ($request->get('cpf')) {
            $request->set('cpf', Util::unMaskCpf($request->get('cpf')));
        }

        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    // BEGIN parent
    public static function getComboBoxForSexo($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'sexo') {
        if ($emptyDefaultText && $_SESSION['lang'] == 'en-us') {
            $emptyDefaultText = "-Select-";
        }

        $valores = AlunoAction::getValuesForSexo();
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getValuesForSexo() {
        if ($_SESSION['lang'] == 'en-us') {
            return array('F' => 'Female', 'M' => 'Male');
        }
        return parent::getValuesForSexo();
    }

    // END parent

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
            throw new Exception(Lang::SISTEMA_validaNome);
        }
        if ($request->get("cpf") == '') {
            throw new Exception(Lang::SISTEMA_validaCpf);
        } else {
            $request->set('cpf', Util::unMaskCpf($request->get('cpf')));
            if (!Util::validaCpf($request->get("cpf"))) {
                throw new Exception(Lang::SISTEMA_validaCpfValido);
            }
        }
        if ($request->get("senha") == '') {
            throw new Exception(Lang::SISTEMA_validaSenha);
        }
        if ($request->get("senhaConf") == '') {
            throw new Exception(Lang::SISTEMA_validaSenhaConf);
        }
        if ($request->get("login") == '') {
            throw new Exception(Lang::SISTEMA_validaLogin);
        }
        if ($request->get("email") == '') {
            throw new Exception(Lang::SISTEMA_validaEmail);
        } else {
            if (!Util::validaEmail($request->get("email"))) {
                throw new Exception(Lang::SISTEMA_validaEmailValido);
            }
        }
        if ($request->get("dataNascimento") == '') {
            throw new Exception(Lang::SISTEMA_validaDataNascimento);
        } else {

            if (!Validate::validateDate($request->get("dataNascimento"))) {
                throw new Exception(Lang::SISTEMA_validaDataNascimentoValido);
            } else {
                $request->set('dataNascimento', Util::transformaData($request->get('dataNascimento'), 'normal2mysql'));
            }
        }

        if ($request->get("sexo") == '') {
            throw new Exception(Lang::SISTEMA_validaSexo);
        }
        if ($request->get("cidade") == '') {
            throw new Exception(Lang::SISTEMA_validaCidade);
        }
        if ($request->get("estado") == '') {
            throw new Exception(Lang::SISTEMA_validaEstado);
        }
        if ($request->get("instituicaoEnsino") == '') {
            throw new Exception(Lang::SISTEMA_validaInstituicao);
        }
        if (strlen($request->get("senha")) < 6) {
            throw new Exception(Lang::SISTEMA_validaSenhaTamanho);
        }
        if ($request->get("senha") != $request->get("senhaConf")) {
            throw new Exception(Lang::SISTEMA_validaSenhaCompara);
        } else {
            $request->set("senha", sha1($request->get("senha")));
        }
        $request->set("recuperaSenhaHash", NULL);
        $request->set("criarContaHash", NULL);
        $request->set("ativo", "S");
        $request->set("aceiteTermo", "N");
        $request->set("moderado", "N");

        $request->set("dtCadastro", date("Y-m-d H:i:s"));
        if (!$request->get("loginFacial")) {
            $request->set("loginFacial", "N");
        }
//        Util::Debug($request);
        #verifica se o email ja está cadastrado
        $oAluno = $this->selectByEmail($request->get("email"));
        if ($oAluno) {
            throw new Exception(Lang::SISTEMA_validaEmailCadastrado);
        }

        return true;
    }

    public function solicitaRecuperaSenhaSubmit($request) {
        try {
            $oUsuario = $this->selectByEmail($request->get("email"));
        } catch (Exception $e) {
            throw new Exception(Lang::SISTEMA_recuperarSenhaValidaEmail);
        }
        if (!$oUsuario) {
            throw new Exception(Lang::SISTEMA_recuperarSenhaValidaUsuario);
        }
        if ($oUsuario->getAtivo() != "S") {
            throw new Exception(Lang::SISTEMA_recuperarSenhaValidaInativo);
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

            $title = Lang::SISTEMA_recuperarSenhaTitulo . " - " . APPLICATION_NAME;
            $link = "<a href='" . $url_redirect . "' style='text-decoration: underline;' target='_blank'>";
            $body = str_replace("%LINK_ABRE%", $link, Lang::SISTEMA_recuperarSenhaCorpo);
            $body = str_replace("%LINK_FECHA%", "</a>", $body);
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
                $title = Lang::SISTEMA_contaTitulo . " - " . APPLICATION_NAME;
                $body = Lang::SISTEMA_contaCorpo;
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
            throw new Exception(Lang::SISTEMA_validaHash);
        }
        if ($oAluno->getCriarContaHash() != $request->get("hash")) {
            throw new Exception(Lang::SISTEMA_validaHash);
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
            throw new Exception(Lang::SISTEMA_validaLogin);
        }
        if ($request->get("loginFacial")) {
            if ($request->get("aFotoUpload")) {
                throw new Exception(Lang::SISTEMA_validaFoto);
            }
        } else {
            if ($request->get("senha") == '') {
                throw new Exception(Lang::SISTEMA_validaSenha);
            }
        }
        return true;
    }

    public function loginSubmit($request, &$response) {
        try {
            $oAluno = $this->selectByLogin($request->get("login"));
        } catch (Exception $e) {
            throw new Exception(Lang::SISTEMA_validaLogar);
        }
        if (!$oAluno) {
            throw new Exception(Lang::SISTEMA_validaLogar);
        }
        if ($oAluno->getAtivo() != "S") {
            throw new Exception(Lang::SISTEMA_recuperarSenhaValidaInativo);
        }
        if ($oAluno->getModerado() != "S") {
            throw new Exception(Lang::SISTEMA_validaAlunoModerado);
        }

        if ($request->get('loginFacial')) {
            $foto = $request->get('afotoUpload');
            
            $filename = FileUtil::makeFileUploadRoot("tmp/{$oAluno->getId()}", $i + 1, 'afotoUpload', false);

            $cmd = "docker exec facialrecognitionlogin python3 facial_recognition_login_image.py --cascade haarcascade_frontalface_default.xml --encodings encodings/{$oAluno->getId()}/encodings.pickle --image tmp/{$oAluno->getId()}/{$filename} --login {$oAluno->getId()}";

            #2727 abaixo teste estático
            //$cmd = "docker exec facialrecognitionlogin python3 facial_recognition_login_image.py --cascade haarcascade_frontalface_default.xml --encodings encodings/59/encodings.pickle --image Fabiano.png --login 59";                        
            $output = Util::doLogFile($cmd);

            $aRetorno = json_decode($output, true);
            if (!$aRetorno['loginSuccess']) {                
                throw new Exception(Lang::SISTEMA_validaReconhecimento);
            }
        } else {
            if ($oAluno->getSenha() != sha1($request->get("senha"))) {
                throw new Exception(Lang::SISTEMA_validaLogar);
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
            setcookie("login_digitado2" . SESSION_NAME, $oAluno->getLogin(), $dias, "/");
            if ($_SERVER['SERVER_NAME'] === "localhost" || $_SERVER['SERVER_NAME'] === "127.0.0.1") # grava a senha local - PARA NUNCA MAIS DIGITAR DE NOVO
                setcookie("senha_digitado2" . SESSION_NAME, $request->get("senha"), $dias, "/");
        } else {
            $del = time() - 3600; // del agora
            setcookie("login_digitado2" . SESSION_NAME, $oAluno->getLogin(), $del, "/");
            setcookie("senha_digitado2" . SESSION_NAME, "", $del, "/");
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
            $this->setMsg(Lang::SISTEMA_alunoAutenticado);
            return false;
        } else {
            return true;
        }
    }

    public function validateSolicitaRecuperaSenha(&$request) {
        if ($request->get("email") == '') {
            throw new Exception(Lang::SISTEMA_validaEmail);
        }
        if (!Util::validaEmail($request->get("email"))) {
            throw new Exception(Lang::SISTEMA_validaEmailValido);
        }

        $reCaptcha = $request->get("g-recaptcha-response");
        if ($reCaptcha == "") {
            throw new Exception(Lang::SISTEMA_validaCaptcha);
        }
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_PRIVATE_KEY . "&response=" . $reCaptcha . "&remoteip=" . $_SERVER["REMOTE_ADDR"]);
        $responseKeys = json_decode($response, true);
        if (intval($responseKeys["success"]) !== 1) {
            throw new Exception(Lang::SISTEMA_validaCaptchaValido);
        }

        return true;
    }

    public function validateRecuperarSenhaHash(&$request) {
        $oAluno = $this->selectByEmail($request->get("email"));
        if (!$oAluno) {
            throw new Exception(Lang::SISTEMA_validaHash);
        }
        if ($oAluno->getRecuperaSenhaHash() != $request->get("hash")) {
            throw new Exception(Lang::SISTEMA_validaHash);
        }

        $data = ($oAluno->getRecuperaSenhaData()->format('c'));
        $diferenca = Util::diferencaDataEmDias(Util::transformaData($data), date("d/m/Y"));
        if ($diferenca > 1) {
            throw new Exception(Lang::SISTEMA_validaHash);
        }
        $request->set("id", $oAluno->getId());
        return true;
    }

    public function validaterRecuperarSenha(&$request) {
        if (!$request->get("novaSenha")) {
            throw new Exception(Lang::SISTEMA_validaNovaSenha);
        }

        if (strlen($request->get("novaSenha")) < 6) {
            throw new Exception(Lang::SISTEMA_validaNovaSenhaTamanho);
        }

        if ($request->get("novaSenha") != $request->get("novaSenhaConf")) {
            throw new Exception(Lang::SISTEMA_validaNovaSenhaCompara);
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
                for ($i = 0; $i < count($afotoUpload["name"]); $i++) {
//                    FileUtil::makeFileUploadPosicao("dataset/{$oAluno->getId()}", $i + 1, 'afotoUpload', $i, false);
                    # upload extra solicitado pelo caueh em 11/07/2019 as 17:12 (Antonio)
                    $filenameEncoded = FileUtil::makeFileUploadPosicaoRoot("encodings/{$oAluno->getId()}", $i + 1, 'afotoUpload', $i, false);

                    $filename = FileUtil::makeFileUploadPosicaoRoot("dataset/{$oAluno->getId()}", $i + 1, 'afotoUpload', $i, false);
                    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));

                    # gerar o pickle - function que gera o codigo em python
//                    $pickle = shell_exec("sudo docker exec facialrecognitionlogin python3 decodificador_faces.py --dataset upload/dataset/1_Fabiano --encodings upload~/encodings/{$oAluno->getId()}/encodings.pickle --detection-method hog");
//                    $cmd = "sudo docker exec facialrecognitionlogin python3 decodificador_faces.py --dataset dataset/{$oAluno->getId()} --encodings encodings/{$oAluno->getId()}/encodings.pickle --detection-method hog sudo docker exec facialrecognitionlogin python3 facial_recognition_login_image.py --cascade haarcascade_frontalface_default.xml --encodings encodings/{$oAluno->getId()}/encodings.pickle --image {$oAluno->getId()}.{$ext} --login {$oAluno->getId()}";
                    $cmd = shell_exec("docker exec facialrecognitionlogin python3 decodificador_faces.py --dataset dataset/{$oAluno->getId()} --encodings encodings/{$oAluno->getId()}/encodings.pickle --detection-method hog");
                    $pickle = shell_exec($cmd);
//                echo $cmd;
//                Util::debug($pickle);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delAtivoInativo($id, $ativo = "N", $commitable = true, $doLog = true) {
        $oAluno = $this->em->find('Aluno', array('id' => $id));
        $oAluno->setAtivo($ativo);


        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAluno);
            $this->em->flush($oAluno);

            if ($doLog) {

                ## LOG BEGIN ##
                $oLog = new LogAction($this->em);
                $oLog->register("O", "Ativo/Desativo Aluno com o índice {$id}", FALSE);
                ## LOG END ##
            }

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
