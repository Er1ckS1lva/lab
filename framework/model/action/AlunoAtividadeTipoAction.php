<?php
include_once(dirname(__FILE__).'/../actionparent/AlunoAtividadeTipoActionParent.php');

class AlunoAtividadeTipoAction extends AlunoAtividadeTipoActionParent {

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