<?php
include_once(dirname(__FILE__).'/../../model/action/ModuloAction.php');
require_once(dirname(__FILE__).'/../parent/ModuloControllerParent.php');

class ModuloController extends ModuloControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>