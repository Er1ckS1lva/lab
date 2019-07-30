<?php
include_once(dirname(__FILE__).'/../actionparent/AtividadeColunaActionParent.php');

class AtividadeColunaAction extends AtividadeColunaActionParent {

    public function validate(&$request,$edicao = false){
        # validação parent
        $validation = $this->validateParent($request,$edicao);
        if(!$validation){
           return $validation;
        }
        
        return true;
    }


}
?>