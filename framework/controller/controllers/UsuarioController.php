<?php

include_once(dirname(__FILE__) . '/../../model/action/UsuarioAction.php');
require_once(dirname(__FILE__) . '/../parent/UsuarioControllerParent.php');

class UsuarioController extends UsuarioControllerParent {

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function home() {
        $oUtilAuth = new UtilAuth();
        if ($oUtilAuth->usuarioAutenticado($this->request->get("action"), true)) {
            $oUsuario = UtilAuth::recuperaObjetoUsuario();

            $oLogAction = new LogAction();
            $resultsPerPage = (!defined(ULTIMOS_REGISTROS)) ? ULTIMOS_REGISTROS : 10;

            $objectsUltimos = $oLogAction->collection(null, "o.Usuario=" . $oUsuario->getId() . " AND o.operacao='O'", "id DESC", $resultsPerPage);
            $this->response->set("objectsUltimos", $objectsUltimos);

            $objectsUltimosAcessos = $oLogAction->collection(null, "o.Usuario=" . $oUsuario->getId() . " AND o.operacao='A'", "id DESC", $resultsPerPage);
            $this->response->set("objectsUltimosAcessos", $objectsUltimosAcessos);


            return new View(UsuarioAction::getModuleName() . '/pessoal/Usuario.home.php', $this->response, "module");
        } else {
            return $this->login();
        }
    }

    public function login() {
        $oUtilAuth = new UtilAuth();
        if ($oUtilAuth->usuarioAutenticado($this->request->get("action"), true)) {
            return new View(URL_APP . 'Usuario/home', $this->response, 'redirectFriendly');
        }
        if ($this->request->get("getRecaptcha")) {
            return new View(recaptcha_get_html_customize(RECAPTCHA_PUBLIC_KEY), $this->response, 'print');
        }
        $this->response->set("error_message", $this->request->get("error_message"));
        return new View(UsuarioAction::getModuleName() . '/pessoal/Usuario.login.php', $this->response);
    }

    public function loginSubmit() {
        try {
            $oUsuarioAction = new UsuarioAction();
            $oUsuarioAction->validateLogin($this->request, $this->response);
            $oUsuarioAction->loginSubmit($this->request, $this->response);
        } catch (Exception $exc) {
            return new View(json_encode(array("status" => $exc->getMessage()), JSON_FORCE_OBJECT), $this->response, "print");
        }
        return new View(json_encode($this->response->get("json"), JSON_FORCE_OBJECT), NULL, "print");
    }

    public function logout() {
        session_destroy();
        return new View(URL_LOGIN, $this->response, 'redirectFriendly');
    }

    public function dadosPessoais() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), true))
            return $oUtilAuth->retornaViewLogin($this->response);
        $oUsuario = UtilAuth::recuperaObjetoUsuario();
        $oUsuarioAction = new UsuarioAction();
        $o = $oUsuarioAction->select($oUsuario->getId());
        $this->response->set("object", $o);
        return new View(UsuarioAction::getModuleName() . '/pessoal/Usuario.edit.dadosPessoais.php', $this->response, 'include');
    }

    public function dadosPessoaisSubmit() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), true))
            return $oUtilAuth->retornaViewLogin($this->response);
        $oUsuarioAction = new UsuarioAction();
        try {
            $oUsuarioAction->validateDadosPessoais($this->request);
            $oUsuarioAction->dadosPessoais($this->request);
        } catch (Exception $exc) {
            return new View($exc->getMessage(), $this->response, 'print');
        }
        return new View('OK', $this->response, 'print');
    }

    public function trocarSenha() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), true))
            return $oUtilAuth->retornaViewLogin($this->response);
        $o = UtilAuth::recuperaObjetoUsuario();
        $this->response->set("object", $o);
        return new View(UsuarioAction::getModuleName() . '/pessoal/Usuario.edit.trocarSenha.php', $this->response, 'include');
    }

    public function trocarSenhaSubmit() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), true))
            return $oUtilAuth->retornaViewLogin($this->response);
        $oUsuarioAction = new UsuarioAction();
        try {
            $oUsuarioAction->validateTrocarSenha($this->request);
            $oUsuarioAction->trocarSenha($this->request);
        } catch (Exception $exc) {
            return new View($exc->getMessage(), $this->response, 'print');
        }
        return new View('OK', $this->response, 'print');
    }

    public function meuPerfil() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), true))
            return $oUtilAuth->retornaViewLogin($this->response);
        $oUsuario = UtilAuth::recuperaObjetoUsuario();
        $oUsuarioAction = new UsuarioAction();
        $oUsuario = $oUsuarioAction->select($oUsuario->getId());
        $this->response->set("oUsuario", $oUsuario);

        $oPermissaoAction = new PermissaoAction();
        $oPermissao = $oPermissaoAction->collection(null, "o.Perfil = " . $oUsuario->getPerfil()->getId());
        $this->response->set("oPermissao", $oPermissao);
        return new View(UsuarioAction::getModuleName() . '/pessoal/Usuario.meu.perfil.php', $this->response, 'include');
    }

    public function solicitaRecuperaSenhaSubmit() {
        $oUsuarioAction = new UsuarioAction();
        try {
            $oUsuarioAction->validateSolicitaRecuperaSenha($this->request, $this->response);
            $oUsuarioAction->solicitaRecuperaSenhaSubmit($this->request, $this->response);
        } catch (Exception $e) {
            return new View($e->getMessage(), $this->response, "print");
        }
        return new View('OK', $this->response, "print");
    }

    public function recuperarSenha() {
        $oUsuarioAction = new UsuarioAction();
        try {
            $oUsuarioAction->validateRecuperarSenhaHash($this->request, $this->response);
        } catch (Exception $e) {
            $this->response->set("error_message", $e->getMessage());
            return new View(URL_APP, $this->response, "redirectFriendly");
        }
        $oUsuario = $oUsuarioAction->selectByEmail($this->request->get("email"));
        $this->response->set("oUsuario", $oUsuario);
        return new View(UsuarioAction::getModuleName() . '/pessoal/Usuario.recuperarSenha.php', $this->response);
    }

    public function recuperarSenhaSubmit() {
        $oUsuarioAction = new UsuarioAction();
        try {
            $oUsuarioAction->validateRecuperarSenhaHash($this->request, $this->response);
            $oUsuarioAction->validaterRecuperarSenha($this->request);
            $oUsuarioAction->trocarSenha($this->request);
        } catch (Exception $e) {
            return new View($e->getMessage(), $this->response, 'print');
        }
        return new View('OK', $this->response, "print");
    }
    
    public function redefinirSenha() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $oUsuarioAction = new UsuarioAction();
        $dados = explode("=", $this->request->get("dados"));
        $o = $oUsuarioAction->select($dados[1]); # id
        if ($o === null)
            return $this->admFilter();
        $this->response->set("object", $o);

        return new View(UsuarioAction::getModuleName() . '/pessoal/Usuario.edit.redefinirSenha.php', $this->response, 'include');
    }

    public function redefinirSenhaSubmit() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);
        $oUsuarioAction = new UsuarioAction();
        try {
            $oUsuarioAction->validateTrocarSenha($this->request, true);
            $oUsuarioAction->trocarSenha($this->request);
        } catch (Exception $exc) {
            return new View($exc->getMessage(), $this->response, 'print');
        }
        return new View('OK', $this->response, 'print');
    }
}

?>