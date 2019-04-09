<?php
include_once(dirname(__FILE__).'/../actionparent/FormularioOpcaoActionParent.php');

class FormularioOpcaoAction extends FormularioOpcaoActionParent {

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