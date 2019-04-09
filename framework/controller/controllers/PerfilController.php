<?php
include_once(dirname(__FILE__).'/../../model/action/PerfilAction.php');
require_once(dirname(__FILE__).'/../parent/PerfilControllerParent.php');

class PerfilController extends PerfilControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }
        
}
?>