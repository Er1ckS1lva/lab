<?php
include_once(dirname(__FILE__).'/../actionparent/AlunoOpcaoEnviosActionParent.php');

class AlunoOpcaoEnviosAction extends AlunoOpcaoEnviosActionParent {

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