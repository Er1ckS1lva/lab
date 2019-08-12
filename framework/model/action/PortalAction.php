<?php

class PortalAction {

    protected $msg;
    protected $em;

    public function __construct($em = NULL) {
        $this->em = $em === NULL ? DoctrineBootstrap::iGenialConnection('') : $em;
    }

    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($e) {
        $this->msg = ExceptionHandler::getMessage($e);
    }

    public function getConnection() {
        return $this->em;
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }

    public function home(&$request, &$response) {
        $oTemaAction = new TemaAction($this->em);
        $aTema = $oTemaAction->collection(null, "o.logDel = 'N'", 'ordem ASC');

        $aTema = Util::IdiomaGetDados($aTema, "TemaIdioma");

        $response->set("aTema", $aTema);

        #recuperando apenas o laboratorio existente
        $oLaboratorioAction = new LaboratorioAction($this->em);
        $oLaboratorio = $oLaboratorioAction->select(1);
        $response->set("oLaboratorio", $oLaboratorio);

        $oAlunoAction = new AlunoAction();
        $oAlunoSession = unserialize($_SESSION['serAlunoSessao']);
        $oAluno = $oAlunoAction->select($oAlunoSession->getId());
        $response->set("oAluno", $oAluno);
    }

}

?>