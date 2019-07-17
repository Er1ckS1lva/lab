<?php
include_once(dirname(__FILE__).'/../actionparent/AtividadeOpcaoActionParent.php');

class AtividadeOpcaoAction extends AtividadeOpcaoActionParent {

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