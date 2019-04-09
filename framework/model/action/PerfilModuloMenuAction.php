<?php
include_once(dirname(__FILE__).'/../actionparent/PerfilModuloMenuActionParent.php');

class PerfilModuloMenuAction extends PerfilModuloMenuActionParent {

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