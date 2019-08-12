<?php
include_once(dirname(__FILE__).'/../actionparent/ModuloMenuActionParent.php');

class ModuloMenuAction extends ModuloMenuActionParent {

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