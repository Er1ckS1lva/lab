<?php
include_once(dirname(__FILE__).'/../../model/action/TemaAction.php');
require_once(dirname(__FILE__).'/../parent/TemaControllerParent.php');

class TemaController extends TemaControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function admFilter() {
        $v = parent::admFilter();
        $objects = $this->response->get("objects");
        if($objects){
            $oAtividadeAction = new AtividadeAction();
            $tAtividade = array();
            foreach ($objects as $o){
                $tAtividade[$o->getId()] = $oAtividadeAction->totalRegistros("o.Tema = {$o->getId()}");
            }
            $this->response->set("tAtividade", $tAtividade);
        }
        return $v;
    }
    
}
?>