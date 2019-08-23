<?php

include_once(dirname(__FILE__) . '/../../model/action/PortalAction.php');

class PortalController {

    protected $request;
    protected $response;
    protected $view;

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;

        # para idioma
        include_once(IGENIAL_ROOT_DIR . '/framework/view/portal/inc/language.php');
    }

    protected function authPortal($setMsg = true) {
        $oAlunoAction = new AlunoAction();
        if ($oAlunoAction->alunoAutenticado() === FALSE) {
            if ($setMsg) {
                $this->response->set("error_message", $oAlunoAction->getMsg());
            }
            $this->view = new View(URL . 'login', $this->response, 'redirectFriendly');
            return false;
        }
        return true;
    }

    public function setAllFixo() {
        $oIdiomaAction = new IdiomaAction();
        $aIdiomaHeader = $oIdiomaAction->collection(null, null, "padrao");
        $this->response->set("aIdiomaHeader", $aIdiomaHeader);

        $nIdIdioma = IdiomaAction::getIdIdioma();

        IdiomaAction::setIdiomaPadraoSession($nIdIdioma);
        IdiomaAction::setIdiomaSigla($oIdiomaAction->select($nIdIdioma, array('sigla')));

        $oPaginaAction = new PaginaAction();
        $aPagina = $oPaginaAction->collection(null, null, 'ordem ASC');

        $aPagina = Util::IdiomaGetDados($aPagina, "PaginaIdioma");

        $this->response->set("aPagina", $aPagina);
    }

    public function setIdiomaPadraoSession() {
        $sOk = Lang::SISTEMA_erroIdioma;
        if ($this->request->get("idioma")) {
            IdiomaAction::setIdiomaPadraoSession($this->request->get("idioma"));
            #salvaremos a sigla tbm por conta da classe q utiliza o i18n 
            $oIdiomaAction = new IdiomaAction();
            IdiomaAction::setIdiomaSigla($oIdiomaAction->select($this->request->get("idioma"), array('sigla')));
            $sOk = "OK";
        }
        return new View($sOk, $this->response, 'print');
    }

    public function home() {
        $this->setAllFixo();

        #valide o login desta forma        
        if (!$this->authPortal(false))
            return $this->view;

        $oPortalAction = new PortalAction();
        $oPortalAction->home($this->request, $this->response);

        return new View('portal/Portal.home.php', $this->response, 'include');
    }

    public function login() {
        $this->setAllFixo();

        $oAlunoAction = new AlunoAction();
        if ($oAlunoAction->alunoAutenticado()) {
            return new View(URL, $this->response, 'redirectFriendly');
        }
        return new View('portal/Portal.login.php', $this->response, 'include');
    }

    public function criarConta() {
        $this->setAllFixo();

        $oAlunoAction = new AlunoAction();
        if ($oAlunoAction->alunoAutenticado()) {
            return new View(URL, $this->response, 'redirectFriendly');
        }
        return new View('portal/Portal.conta.php', $this->response, 'include');
    }

    public function criarContaSubmit() {
        $this->setAllFixo();

        $oAlunoAction = new AlunoAction();
        if ($oAlunoAction->alunoAutenticado()) {
            return new View(URL, $this->response, 'redirectFriendly');
        }

        try {
            $oAlunoAction->criarConta($this->request);
        } catch (Exception $exc) {
            return new View(json_encode(array("status" => $exc->getMessage()), JSON_FORCE_OBJECT), $this->response, "print");
        }

        return new View(json_encode(array("status" => "OK"), JSON_FORCE_OBJECT), NULL, "print");
    }

    public function criarContaConfirma() {
        $this->setAllFixo();

        $oAlunoAction = new AlunoAction();
        if ($oAlunoAction->alunoAutenticado()) {
            return new View(URL, $this->response, 'redirectFriendly');
        }
        try {
            $oAlunoAction->criarContaConfirma($this->request, $this->response);
        } catch (Exception $exc) {
            $this->response->set('error_message', $exc->getMessage());
        }

        return new View('portal/Portal.contaConfirma.php', $this->response, 'include');
    }

    public function loginSubmit() {
        $this->setAllFixo();
//        Util::debug($this->request);
        try {
            $oAlunoAction = new AlunoAction();
            $oAlunoAction->validateLogin($this->request, $this->response);
            $oAlunoAction->loginSubmit($this->request, $this->response);
        } catch (Exception $exc) {
            return new View(json_encode(array("status" => $exc->getMessage()), JSON_FORCE_OBJECT), $this->response, "print");
        }
        return new View(json_encode($this->response->get("json"), JSON_FORCE_OBJECT), NULL, "print");
    }

    public function logout() {
        $this->setAllFixo();
        unset($_SESSION['serAlunoSessao']);        
//        session_destroy();
        
        return new View(URL . "login", $this->response, 'redirectFriendly');
    }

    public function internacional() {
        $this->setAllFixo();

        return new View('portal/internacional.php', $this->response, 'include');
    }

    public function solicitaRecuperaSenhaSubmit() {
        $this->setAllFixo();

        if (!$this->authPortal())
            return $this->view;

        $oAlunoAction = new AlunoAction();
        try {
            $oAlunoAction->validateSolicitaRecuperaSenha($this->request, $this->response);
            $oAlunoAction->solicitaRecuperaSenhaSubmit($this->request, $this->response);
        } catch (Exception $e) {
            Util::debug($e->getMessage());
            return new View($e->getMessage(), $this->response, "print");
        }
        return new View('OK', $this->response, "print");
    }

    public function recuperarSenha() {
        $this->setAllFixo();

        if (!$this->authPortal())
            return $this->view;

        $oAlunoAction = new AlunoAction();
        try {
            $oAlunoAction->validateRecuperarSenhaHash($this->request, $this->response);
        } catch (Exception $e) {
            $this->response->set("error_message", $e->getMessage());
            return new View(URL_APP, $this->response, "redirectFriendly");
        }
        $oAluno = $oAlunoAction->selectByEmail($this->request->get("email"));
        $this->response->set("oAluno", $oAluno);
        return new View(AlunoAction::getModuleName() . '/pessoal/Aluno.recuperarSenha.php', $this->response);
    }

    public function recuperarSenhaSubmit() {
        $this->setAllFixo();

        if (!$this->authPortal())
            return $this->view;

        $oAlunoAction = new AlunoAction();
        try {
            $oAlunoAction->validateRecuperarSenhaHash($this->request, $this->response);
            $oAlunoAction->validaterRecuperarSenha($this->request);
            $oAlunoAction->trocarSenha($this->request);
        } catch (Exception $e) {
            return new View($e->getMessage(), $this->response, 'print');
        }
        return new View('OK', $this->response, "print");
    }

    public function allAtividade() {
        $this->setAllFixo();

        if (!$this->authPortal())
            return $this->view;

        $idTema = (int) $this->request->get("idTema");
        $oTemaAction = new TemaAction();
        $oTema = $oTemaAction->select($idTema);
        if (!$oTema) {
            return new View('portal/404.php', $this->response, 'include');
        }
        $this->response->set("oTema", $oTema);

        $oTemaIdioma = Util::IdiomaGetDados($oTema, "TemaIdioma");
        $this->response->set("oTemaIdioma", $oTemaIdioma ? $oTemaIdioma[0] : null);

        $idAtividade = (int) $this->request->get('idAtividade');
        $oAtividadeAction = new AtividadeAction();
        $aAtividade = $oAtividadeAction->collection(null, "o.Tema = {$idTema} AND o.logDel = 'N'", 'ordem ASC');

        $aAtividade = Util::IdiomaGetDados($aAtividade, "AtividadeIdioma");

        $this->response->set("aAtividade", $aAtividade);

        $oConteudoAction = new ConteudoAction();
        $oConteudoArquivoAction = new ConteudoArquivoAction();
        $oConteudoFormularioAction = new ConteudoFormularioAction();
        $oAtividadeOpcaoAction = new AtividadeOpcaoAction();
        $oAlunoAtividadeAction = new AlunoAtividadeAction();
        $aConteudo = array();
        $aConteudoArquivo = array();
        $aConteudoFormulario = array();
        $aOpcao = array();

        $aAtividadeIdPaginador = array(0);
        if ($aAtividade) {
            foreach ($aAtividade as $oAtividade) {
                $aAtividadeIdPaginador[] = $oAtividade->getId();
            }
        }
        $this->response->set("aAtividadeIdPaginador", $aAtividadeIdPaginador);

        if ($aAtividade && $idAtividade) {
            foreach ($aAtividade as $key => $oAtividade) {
                $aOpcao[$oAtividade->getId()] = $oAtividadeOpcaoAction->collection(null, "o.Atividade={$oAtividade->getId()}", 'id ASC');

                $aConteudo[$oAtividade->getId()] = $oConteudoAction->collection(null, "o.Atividade = {$oAtividade->getId()}", "id ASC");
                if ($aConteudo[$oAtividade->getId()]) {
                    foreach ($aConteudo[$oAtividade->getId()] as $key => $oConteudo) {
                        $aConteudoArquivo[$oConteudo->getId()] = $oConteudoArquivoAction->select($oConteudo->getId());
                        $aConteudoFormulario[$oConteudo->getId()] = $oConteudoFormularioAction->selectByConteudo($oConteudo->getId());
                    }
                }
            }
            $oAlunoAtividade = $oAlunoAtividadeAction->select(1, $idAtividade);
            $this->response->set("oAlunoAtividade", $oAlunoAtividade);

            try {
                $oAlunoAcesso = new AlunoAcessoAction($this->em);
                $oAlunoAcesso->register("ATV", $idAtividade);
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }

        $this->response->set("aConteudoArquivo", $aConteudoArquivo);
        $this->response->set("aConteudoFormulario", $aConteudoFormulario);
        $this->response->set("aConteudo", $aConteudo);
        $this->response->set("idAtividade", $idAtividade);
        $this->response->set("idTema", $idTema);
        $this->response->set("aOpcao", $aOpcao);

        return new View('portal/Atividade.all.php', $this->response, 'include');
    }

    public function showPagina() {
        $this->setAllFixo();

        if (!$this->authPortal())
            return $this->view;

        $id = (int) $this->request->get('idPagina');
        $oPaginaAction = new PaginaAction();

        $oPagina = Util::IdiomaGetDados($oPaginaAction->select($id), "PaginaIdioma");

        $this->response->set('oPagina', $oPagina[0]);
        return new View('portal/Portal.pagina.php', $this->response, 'include');
    }
    
    public function verificarResposta() {
        $this->setAllFixo();

        if (!$this->authPortal())
            return $this->view;

        $oAtividadeAction = new AtividadeAction();
        try {
            $oAtividadeAction->verificarResposta($this->request, $this->response);
        } catch (Exception $e) {
            return new View($e->getMessage(), $this->response, 'print');
        }
        return new View('OK', $this->response, "print");
    }

}

?>