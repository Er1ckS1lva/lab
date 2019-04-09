<?php

include_once(dirname(__FILE__) . '/../../model/action/ConfiguracaoAction.php');
require_once(dirname(__FILE__) . '/../parent/ConfiguracaoControllerParent.php');

class ConfiguracaoController extends ConfiguracaoControllerParent {

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function admFilter() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $action = new ConfiguracaoAction();
        $o = $action->recuperarConfiguracao();
        if ($o !== null)
            $this->response->set("object", $o);
        return new View(ConfiguracaoAction::getModuleName() . '/Configuracao.form.php', $this->response, "module");
    }

    public function edit() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $action = new ConfiguracaoAction();
        $o = $action->recuperarConfiguracao();
        if ($o !== null)
            $this->response->set("object", $o);
        return new View(ConfiguracaoAction::getModuleName() . '/Configuracao.form.php', $this->response, "module");
    }

}

?>