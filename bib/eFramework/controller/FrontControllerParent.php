<?php

#include_once(dirname(__FILE__) . "/controllers/LanguageController.php");
include_once(dirname(__FILE__) . "/controllers/CropController.php");

include_once(dirname(__FILE__) . '/../../classes/settings/Includes.php');
include_once(dirname(__FILE__) . '/../../classes/settings/Config.php');

class FrontControllerParent {

    public function __construct() {
        $config = new Config();
        $request = new Request();
        $response = new Response();
        $action = $request->get("action");
        $modulo = $request->get("modulo");
        list($class, $method) = explode(".", $action);
        if (class_exists("{$class}Controller")) {
            if ($class != 'Front') {
                $class = Util::recuperaNomeEntidade($class); # precisa para recuperar o nome correto da entidade, que é case sensitive
                eval("\$controller = new {$class}Controller(\$request,\$response);");
            } else {
                $class = $this;
            }
            $method = Util::recuperaNomeMetodo($controller, $method);
            if (method_exists($controller, $method)) {
                eval("\$view = \$controller->$method();");
            } else {
                $view = $this->defaultView($request, $response);
            }
        } elseif($action === "Defaultview.index") {
            $oUtilAuth = new UtilAuth();
            if (!$oUtilAuth->usuarioAutenticado($action, true)) {
                $view = $oUtilAuth->retornaViewLogin($response);
            } else {
                $view = new View($action, $response, IS_SITE ? "include" : "module");
            }
        } else {
            $view = $this->pageNotFountView($request, $response);
        }
        $view->renderView();
    }

    public function defaultView(&$request, &$response) {
        $defaulView = DEFAULT_VIEW;
        return new View($defaulView, $response);
    }

    public function pageNotFountView(&$request, &$response) {
        $defaulView = DEFAULT_404_VIEW;
        return new View($defaulView, $response, IS_SITE ? "include" : "module");
    }

}
