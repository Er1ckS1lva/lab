<?php
include_once(dirname(__FILE__).'/../actionparent/ConteudoArquivoActionParent.php');

class ConteudoArquivoAction extends ConteudoArquivoActionParent {

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