<?php
include_once(dirname(__FILE__).'/../actionparent/LaboratorioActionParent.php');

class LaboratorioAction extends LaboratorioActionParent {

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