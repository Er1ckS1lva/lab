<?php

include_once(dirname(__FILE__) . '/../actionparent/ConteudoFormularioActionParent.php');

class ConteudoFormularioAction extends ConteudoFormularioActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    public function selectByConteudo($idConteudo, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Conteudo' => $idConteudo), $qb);
        $query = $qb->select($fieldsToSelect)
                ->from('ConteudoFormulario', 'o')
                ->where($where);

        $oConteudoFormulario = $query->getQuery()->getOneOrNullResult();
        return $oConteudoFormulario;
    }

    function verificarResposta($dados, $id) {
        $aCorreta = $this->getCorreta($id);
        if ($dados == $aCorreta) {
            return true;
        } else {
            throw new Exception("Resposta errada");
        }
    }

    function getCorreta($id) {
        $sql = "SELECT fp.id FROM formulario_opcao fp"
                . " WHERE fp.id_conteudo_formulario = {$id}"
                . " AND fp.correta = 'S'";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aCorreta = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $aCorreta;
    }

    function saveResposta($dados, $id) {
        $oAlunoOpcaoEnviosAction = new AlunoOpcaoEnviosAction($this->em, true);
        $oAlunoOpcaoAction = new AlunoOpcaoEnviosAction($this->em, true);
        $oAluno = unserialize($_SESSION['serAlunoSessao']);
        $oAlunoAtividade = $oAlunoOpcaoAction->select($oAluno->getId(), $id);
        $request_at = new Request();
        $request_at->set('Aluno', $oAluno->getId());
        $request_at->set('ConteudoFormulario', (int) $id);
        $request_at->set('valor', join(';', $dados));
        if (!$oAlunoAtividade)
            $oAlunoOpcaoEnviosAction->add($request_at, true);
        else 
            $oAlunoOpcaoAction->edit($request_at, true);
        return true;
    }

}

?>