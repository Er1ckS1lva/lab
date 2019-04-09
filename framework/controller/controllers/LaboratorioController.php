<?php
include_once(dirname(__FILE__).'/../../model/action/LaboratorioAction.php');
require_once(dirname(__FILE__).'/../parent/LaboratorioControllerParent.php');

class LaboratorioController extends LaboratorioControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>