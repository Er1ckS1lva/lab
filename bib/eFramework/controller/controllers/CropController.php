<?php

include_once(dirname(__FILE__) . '/../../model/action/CropAction.php');
require_once(dirname(__FILE__) . '/../parent/CropControllerParent.php');

class CropController extends CropControllerParent {

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function enviaImagem() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);
        $action = new CropAction();
        if (!$action->manipulaImagem($this->request, $this->response)) {
            return new View($action->getMsg(), $this->response, 'print');
        }
        $this->response->set('fieldName', $this->request->get("fieldName"));
        return new View("../../bib/eFramework/view/Crop/Crop.enviaImagem.php", $this->response, 'include');
    }

    public function imagem() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);
        return new View("../../bib/eFramework/view/Crop/Crop.imagem.php", $this->response, 'include');
    }

}

?>