<?php
include_once(dirname(__FILE__).'/../../model/action/BibliotecaAction.php');
require_once(dirname(__FILE__).'/../parent/BibliotecaControllerParent.php');

class BibliotecaController extends BibliotecaControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>