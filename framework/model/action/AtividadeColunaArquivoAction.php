<?php

include_once(dirname(__FILE__) . '/../actionparent/AtividadeColunaArquivoActionParent.php');

class AtividadeColunaArquivoAction extends AtividadeColunaArquivoActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    public function delPhysicalByAtividadeColuna($id_coluna, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.AtividadeColuna' => $id_coluna), $qb);
        $query = $qb->delete()->from("AtividadeColunaArquivo", "o")->where($where)->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }

            $query->execute();

            if ($commitable) {
                $this->em->commit();
            }
        } catch (Exception $e) {
            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        return true;
    }

}

?>