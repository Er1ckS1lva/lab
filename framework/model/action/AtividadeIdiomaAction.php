<?php
include_once(dirname(__FILE__).'/../actionparent/AtividadeIdiomaActionParent.php');

class AtividadeIdiomaAction extends AtividadeIdiomaActionParent {

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