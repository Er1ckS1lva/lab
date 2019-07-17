<?php
include_once(dirname(__FILE__).'/../actionparent/EntidadeActionParent.php');

class EntidadeAction extends EntidadeActionParent {

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