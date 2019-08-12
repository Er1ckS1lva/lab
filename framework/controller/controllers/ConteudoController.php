<?php
include_once(dirname(__FILE__).'/../../model/action/ConteudoAction.php');
require_once(dirname(__FILE__).'/../parent/ConteudoControllerParent.php');

class ConteudoController extends ConteudoControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>