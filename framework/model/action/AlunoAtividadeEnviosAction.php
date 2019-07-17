<?php
include_once(dirname(__FILE__).'/../actionparent/AlunoAtividadeEnviosActionParent.php');

class AlunoAtividadeEnviosAction extends AlunoAtividadeEnviosActionParent {

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