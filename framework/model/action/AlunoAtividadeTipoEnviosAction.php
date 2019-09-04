<?php
include_once(dirname(__FILE__).'/../actionparent/AlunoAtividadeTipoEnviosActionParent.php');

class AlunoAtividadeTipoEnviosAction extends AlunoAtividadeTipoEnviosActionParent {

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