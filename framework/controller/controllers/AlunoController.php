<?php

include_once(dirname(__FILE__) . '/../../model/action/AlunoAction.php');
require_once(dirname(__FILE__) . '/../parent/AlunoControllerParent.php');

class AlunoController extends AlunoControllerParent {

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function aceitaTermo() {
        $oAluno = unserialize($_SESSION['serAlunoSessao']);
        $oAlunoAction = new AlunoAction();
        if (!$oAlunoAction->aceitaTermo($oAluno->getId())) {
            return new View($oAlunoAction->getMsg(), $this->response, 'print');
        }
        return new View('OK', $this->response, 'print');
    }

    public function confirmarCadastro() {
        $id = (int) $this->request->get("id");
        $oAlunoAction = new AlunoAction();
        $oAluno = $oAlunoAction->select($id);
        if (!$oAlunoAction->confirmarCadastro($oAluno->getId())) {
            return new View($oAlunoAction->getMsg(), $this->response, 'print');
        }
        return new View('Aluno Confirmado!', $this->response, 'print');
    }
    

}

?>