<?php
include_once(dirname(__FILE__).'/../../model/action/PaginaAction.php');
require_once(dirname(__FILE__).'/../parent/PaginaControllerParent.php');

class PaginaController extends PaginaControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>