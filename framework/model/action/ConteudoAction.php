<?php

include_once(dirname(__FILE__) . '/../actionparent/ConteudoActionParent.php');

class ConteudoAction extends ConteudoActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    protected function delTransaction($id) {
        $oConteudoArquivoAction = new ConteudoArquivoAction($this->em);
        $oConteudoArquivoAction->delPhysical($id, false);

        $oConteudoFormularioAction = new ConteudoFormularioAction($this->em);
        $aConteudoFormulario = $oConteudoFormularioAction->collection(array("id"), "o.Conteudo = '{$id}'");
        if ($aConteudoFormulario) {
            foreach ($aConteudoFormulario as $oConteudoFormulario) {
                $id_formulario = ($oConteudoFormulario["id"]);
                $oConteudoFormularioAction->delPhysical($id_formulario, false);
            }
        }
    }

}

?>