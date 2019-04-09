<?php

include_once(dirname(__FILE__) . '/../actionparent/AlunoAcessoActionParent.php');

class AlunoAcessoAction extends AlunoAcessoActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    public function register($recurso, $idAtividade = null, $commitable = true) {
        $oAlunoAction = new AlunoAction();
        $oAluno = $oAlunoAction->recuperaObjetoAluno($this->em);

        $request = new Request();
        $request->set("Aluno", $oAluno->getId());
        $request->set("dataRegistro", date("Y-m-d H:i:s"));
        $request->set("recurso", $recurso);
        $request->set("Atividade", $idAtividade);

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->add($request);
            if ($commitable) {
                $this->em->commit();
            }
        } catch (Exception $e) {
            if ($commitable === false) {
                throw $e;
            }
            $this->em->rollback();
            throw new Exception($e);
        }
        return true;
    }

}

?>