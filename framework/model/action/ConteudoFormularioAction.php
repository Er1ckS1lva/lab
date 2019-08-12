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

}

?>