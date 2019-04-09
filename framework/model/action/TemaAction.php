<?php

include_once(dirname(__FILE__) . '/../actionparent/TemaActionParent.php');

class TemaAction extends TemaActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        #validação dos idiomas
        $oIdiomaAction = new IdiomaAction();
        $aIdSigla = $oIdiomaAction->getIdSigla(null, null, 'padrao ASC');

        $aTitulo = $request->get("aTitulo");
        $aDescricao = $request->get("aDescricao");
        foreach ($aTitulo as $nIdIdioma => $oTitulo) {
            if (!$oTitulo) {
                throw new Exception("Por favor, informe o título do idioma: " . $aIdSigla[$nIdIdioma]);
            }
        }
        foreach ($aDescricao as $nIdIdioma => $oDescricao) {
            if (!$oDescricao) {
                throw new Exception("Por favor, informe a descrição do idioma: " . $aIdSigla[$nIdIdioma]);
            }
        }

        return true;
    }

    protected function addTransaction($oTema, $request) {
        $aIdioma = $request->get("aIdioma");
        if ($aIdioma) {
            $aTitulo = $request->get("aTitulo");
            $aDescricao = $request->get("aDescricao");

            $oTemaIdiomaAction = new TemaIdiomaAction($this->em);
            $rTemaIdioma = new Request(FALSE);
            $rTemaIdioma->set("Tema", $oTema->getId());
            foreach ($aIdioma as $id_idioma) {
                if (!isset($aTitulo[$id_idioma]) || strlen($aTitulo[$id_idioma]) == 0)
                    continue;
                $rTemaIdioma->set("Idioma", $id_idioma);
                $rTemaIdioma->set("titulo", $aTitulo[$id_idioma]);
                $rTemaIdioma->set("descricao", $aDescricao[$id_idioma]);

                if (strpos($id_idioma, "#") === FALSE) {
                    $oTemaIdiomaAction->add($rTemaIdioma, false, false);
                } else {
                    $rTemaIdioma->set("Idioma", substr($id_idioma, 0, strpos($id_idioma, "#")));
                    $oTemaIdiomaAction->edit($rTemaIdioma, false, false);
                }
            }
        }
    }

    protected function editTransaction($oTema, $request) {
        $this->addTransaction($oTema, $request);
    }

    protected function delTransaction($id) {
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Tema' => $id), $qb);
        $qb->delete()->from("TemaIdioma", "o")->where($where)->getQuery()->execute();
    }

}

?>