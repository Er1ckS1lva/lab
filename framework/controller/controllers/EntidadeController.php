<?php
include_once(dirname(__FILE__).'/../../model/action/EntidadeAction.php');
require_once(dirname(__FILE__).'/../parent/EntidadeControllerParent.php');

class EntidadeController extends EntidadeControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>