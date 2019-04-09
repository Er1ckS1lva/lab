<?php
include_once(dirname(__FILE__).'/../../model/action/ConteudoArquivoAction.php');
require_once(dirname(__FILE__).'/../parent/ConteudoArquivoControllerParent.php');

class ConteudoArquivoController extends ConteudoArquivoControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

}
?>