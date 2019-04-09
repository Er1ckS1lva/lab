<?php
include_once(dirname(__FILE__).'/../actionparent/ModuloActionParent.php');

class ModuloAction extends ModuloActionParent {

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