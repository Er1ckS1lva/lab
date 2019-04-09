<?php
include_once(dirname(__FILE__).'/../actionparent/PaginaIdiomaActionParent.php');

class PaginaIdiomaAction extends PaginaIdiomaActionParent {

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