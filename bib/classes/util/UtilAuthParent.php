<?php

class UtilAuthParent {

    protected $msg;
    protected $isAuthenticated;

    public function __construct() {
        $this->msg = NULL;
        $this->isAuthenticated = FALSE;
    }

    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($e) {
        $this->msg = ExceptionHandler::getMessage($e);
    }

    public function usuarioAutenticado($action, $isOnlyAuthenticated = false) {
        $oUsuario = $this->recuperaObjetoUsuario();

        # validacao de data
        if ($oUsuario && $oUsuario->getDataFinal() && Util::comparaData($oUsuario->getDataInicio()->format("d/m/Y"), ">", $oUsuario->getDataFinal()->format("d/m/Y"))) {
            $this->setMsg("Este login vigora de {$oUsuario->getDataInicio()->format("d/m/Y")} a {$oUsuario->getDataFinal()->format("d/m/Y")}.<br/>Entre em contato com o suporte para mais informações.");
            return false;
        }
        if ($oUsuario && $oUsuario->getDataFinal() && Util::comparaData($oUsuario->getDataFinal()->format("d/m/Y"), "<", date("d/m/Y"))) {
            $this->setMsg("Este login expirou em {$oUsuario->getDataFinal()->format("d/m/Y")}.<br/>Entre em contato com o suporte para mais informações.");
            return false;
        }
        # acaba validacao de data

        if (!isset($_SESSION['serUsuarioSessao'])) {
            $this->setMsg("Você precisa estar logado para acessar esta página.");
            return false;
        } elseif ($oUsuario && $oUsuario->getSuperuser() == "S") {
            return true;
        } elseif ($isOnlyAuthenticated === true) {
            return true;
        }
        $this->isAuthenticated = true;

        list($entidade, $metodo) = explode(".", $action);
        $entidade = Util::recuperaNomeEntidade($entidade);
        $controller = "{$entidade}Controller";
        $metodo = Util::recuperaNomeMetodo($controller, $metodo);
        $acao = "{$entidade}.{$metodo}";

        $db = new DoctrineBootstrap();
        $em = $db->iGenialConnection();
        $oPermissaoAction = new PermissaoAction($em);
        $oAcaoAction = new AcaoAction($em);
		
		if ($metodo === "suggest") { ### SUGGEST NÃO ENTRA MAIS!
            if (isset($_SESSION['serUsuarioSessao'])) {
                return true;
            }
        }
		
        try {
            $aPermissao = $oPermissaoAction->collection(null, "o.Perfil = {$oUsuario->getPerfil()->getId()}");
            if ($aPermissao) {
                foreach ($aPermissao as $oPermissao) {
                    $aModulo[] = $oPermissao->getModulo()->getId();
                }
                $joinModulo = join(", ", $aModulo);
                $aAcao = $oAcaoAction->collection(null, "o.nome = '{$acao}' AND o.Modulo IN ({$joinModulo})");
                if ($aAcao) {
                    return true;
                } else {
                    $this->setMsg("Você não tem permissão para acessar esta página.");
                    return false;
                }
            } else {
                $this->setMsg("Você não possui permissão para acessar o sistema.");
                return false;
            }
        } catch (Exception $e) {
            $this->setMsg("<p>Erro ao recuperar suas permiss&otilde;es de acesso.\nPor favor entre em contato com o suporte.</p><p>Erro:<br/>{$e->getMessage()}</p>");
            return false;
        }
        $this->setMsg("Erro inesperado de permissão, contate o suporte técnico.");
        return false;
    }

    public function retornaViewLogin($response) {
        if (!$this->getMsg()) {
            $error_message = "Você precisa estar autenticado para acessar esta página!";
        } else {
            $error_message = $this->getMsg();
        }
        if ($this->isAuthenticated === TRUE && isset($_REQUEST['ajaxRequest'])) {
            return new View($error_message, $response, 'print');
        } elseif ($this->isAuthenticated === TRUE) {
            $response->set("MESSAGE_CODE", "NP");
            $response->set("MESSAGE_TYPE", "3");
//            return new View(URL_HOME, $response, "redirectFriendly");
            return new View(URL, $response, "redirectFriendly");
        } else {
            $response->set("error_message", $error_message);
            return new View("seguranca/pessoal/Usuario.login.php", $response);
        }
    }

    public static function recuperaObjetoUsuario($em = null) {
        if (!isset($_SESSION['serUsuarioSessao']))
            return false;
        if (!$em) {
            $db = new DoctrineBootstrap();
            $em = $db->iGenialConnection();
        }
        $aux = unserialize($_SESSION['serUsuarioSessao']);
        $oUsuarioAction = new UsuarioAction($em);
        $o = $oUsuarioAction->select($aux->getId());

        return $o;
    }

    public static function recuperaLoginUsuario($em = null) {
        /* @var $oUsuario Usuario */
        $oUsuario = UtilAuth::recuperaObjetoUsuario($em);
		if(isset($_REQUEST["doLog"]) && $_REQUEST["doLog"] === false){
			return NULL; # caso de não ter log 
		}
        return $oUsuario->getLogin();
    }

    public static function temPermissaoRequest($request, $action) {
        $tmp = explode(".", $request);
        $class = $tmp[0];

        $oUtilAuth = new UtilAuth();
        if ($oUtilAuth->usuarioAutenticado("$class.$action"))
            return true;

        return false;
    }

    public static function todasAcoes($class = null, $aClassException = array("Crop")) {
        $oUsuario = UtilAuthParent::recuperaObjetoUsuario();

        $db = new DoctrineBootstrap();
        $em = $db->iGenialConnection();
        $oPermissaoAction = new PermissaoAction($em);
        $oAcaoAction = new AcaoAction($em);
        $aAcoes = array();
        try {
            $aPermissao = $oPermissaoAction->collection(null, "o.Perfil = {$oUsuario->getPerfil()->getId()}");
            if ($aPermissao) {
                foreach ($aPermissao as $oPermissao) {
                    $aModulo[] = $oPermissao->getModulo()->getId();
                }
                $joinModulo = join(", ", $aModulo);
                $aAcao = $oAcaoAction->collection(null, "o.Modulo IN ({$joinModulo})");
                if ($aAcao) {
                    foreach ($aAcao as $oAcao) {
                        $vAcao = explode(".", $oAcao->getNome());
                        $sClasse = $vAcao[0];
                        $sMetodo = $vAcao[1];
                        if (class_exists("{$sClasse}Action")) {
                            if (!in_array($sClasse, $aClassException)) {
                                if ($class === $sClasse) {
                                    $aAcoes[$sClasse][] = $oAcao->getNome();
                                } else if (!$class) {
                                    $aAcoes[$sClasse][] = $oAcao->getNome();
                                }
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $this->setMsg("<p>Erro ao recuperar todas as ac&otilde;es.\nPor favor entre em contato com o suporte!</p><p>Erro:<br/>{$e->getMessage()}</p>");
            return false;
        }
        return $aAcoes;
    }
	
	public static function recuperaModulosMenusPerfil($id_perfil = false) {
        if (!$id_perfil) {
            $_oUsuarioAutenticado = UtilAuth::recuperaObjetoUsuario();
            $id_perfil = $_oUsuarioAutenticado->getPerfil()->getId();
        }

        # recupera modulos que ele pode enxergar
        $oPerfilModuloMenuAction = new PerfilModuloMenuAction();
        $aPerfilModuloMenu = $oPerfilModuloMenuAction->collection(null, "o.Perfil={$id_perfil}");
        $aModuloMenu = array();
        if ($aPerfilModuloMenu) {
            foreach ($aPerfilModuloMenu as $oPerfilModuloMenu) {
                $aModuloMenu[] = URL_APP . $oPerfilModuloMenu->getModuloMenu()->getNome() . "/";
            }
        }
        return $aModuloMenu;
    }

    public static function recuperaModulosMenus() {
        if (class_exists("ModuloMenuAction")) {
            $oModuloMenuAction = new ModuloMenuAction();
            $aPerfilModuloMenu = $oModuloMenuAction->collection(null, null, "ordem ASC");
            return $aPerfilModuloMenu;
        }
    }

}

?>