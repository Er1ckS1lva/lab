<?php
include_once(dirname(__FILE__).'/../actionparent/TemaIdiomaActionParent.php');

class TemaIdiomaAction extends TemaIdiomaActionParent {

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