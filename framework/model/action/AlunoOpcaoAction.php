<?php
include_once(dirname(__FILE__).'/../actionparent/AlunoOpcaoActionParent.php');

class AlunoOpcaoAction extends AlunoOpcaoActionParent {

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