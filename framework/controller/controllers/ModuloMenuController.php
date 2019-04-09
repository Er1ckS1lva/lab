<?php
include_once(dirname(__FILE__).'/../../model/action/ModuloMenuAction.php');
require_once(dirname(__FILE__).'/../parent/ModuloMenuControllerParent.php');

class ModuloMenuController extends ModuloMenuControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>