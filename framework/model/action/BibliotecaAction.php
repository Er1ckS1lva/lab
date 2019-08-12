<?php
include_once(dirname(__FILE__).'/../actionparent/BibliotecaActionParent.php');

class BibliotecaAction extends BibliotecaActionParent {

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