<?php

include_once(dirname(__FILE__) . '/../actionparent/IdiomaActionParent.php');

class IdiomaAction extends IdiomaActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    protected function addTransaction($oIdioma, $request) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        if ($request->get("padrao") == "1") {
            $qb = $this->em->createQueryBuilder();
            $where = QueryHelper::getAndUnequals(array('o.id' => $oIdioma->getId()), $qb);
            $qb->update("Idioma o")
                    ->set("o.padrao", "2")
                    ->where($where)->getQuery()->execute();
        }
    }

    protected function editTransaction($oIdioma, $request) {
        $this->addTransaction($oIdioma, $request);
    }

    public function getIdSigla() {
        $aIdioma = $this->collection(array('id', 'sigla'), null, 'padrao ASC');

        $aIdSigla = array();
        foreach ($aIdioma as $key => $oIdioma) {
            $aIdSigla[$oIdioma['id']] = $oIdioma['sigla'];
        }

        return $aIdSigla;
    }

    public function selectPadrao($fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.padrao' => "'1'"), $qb);
        $query = $qb->select($fieldsToSelect)
                ->from('Idioma', 'o')
                ->where($where);

        $oIdioma = $query->getQuery()->getOneOrNullResult();
        return $oIdioma;
    }

    public static function setIdiomaPadraoSession($id_idioma) {
        $_SESSION["portal"]["idioma"] = $id_idioma;
    }

    public static function setIdiomaSigla($o) {
        $_SESSION["lang"] = $o['sigla'];
    }

    public static function getIdiomaPadraoSession() {
        if (isset($_SESSION["portal"]["idioma"]))
            return $_SESSION["portal"]["idioma"];
        return false;
    }

    public static function getIdIdioma() {
        $oIdiomaAction = new IdiomaAction();
        if (IdiomaAction::getIdiomaPadraoSession()) {
            # pega o idioma padrao da sessao
            $nIdIdioma = IdiomaAction::getIdiomaPadraoSession();
        } else if (!IdiomaAction::getIdiomaPadraoSession() && $oIdiomaAction->selectPadrao()) {
            # pega o idioma padrao do banco
            $oIdioma = $oIdiomaAction->selectPadrao();
            $nIdIdioma = $oIdioma->getId();
        } else {
            exit("CONFIGURAR IDIOMA!");
        }
        return $nIdIdioma;
    }

}

?>