<?php
include_once(dirname(__FILE__).'/../../model/action/IdiomaAction.php');
require_once(dirname(__FILE__).'/../parent/IdiomaControllerParent.php');

class IdiomaController extends IdiomaControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>