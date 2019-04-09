<?php

include_once(dirname(__FILE__) . '/../actionparent/PaginaActionParent.php');

class PaginaAction extends PaginaActionParent {

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
        foreach ($aTitulo as $nIdIdioma => $oTitulo) {
            if (!$oTitulo) {
                throw new Exception("Por favor, informe o título do idioma: " . $aIdSigla[$nIdIdioma]);
            }
        }

        return true;
    }

    protected function addTransaction($oPagina, $request) {
        $aIdioma = $request->get("aIdioma");
        if ($aIdioma) {
            $aTitulo = $request->get("aTitulo");
            $aConteudo = $request->get("aConteudo");

            $oPaginaIdiomaAction = new PaginaIdiomaAction($this->em);
            $rPaginaIdioma = new Request(FALSE);
            $rPaginaIdioma->set("Pagina", $oPagina->getId());
            foreach ($aIdioma as $id_idioma) {
                if (!isset($aTitulo[$id_idioma]) || strlen($aTitulo[$id_idioma]) == 0)
                    continue;
                $rPaginaIdioma->set("Idioma", $id_idioma);
                $rPaginaIdioma->set("titulo", $aTitulo[$id_idioma]);
                $rPaginaIdioma->set("conteudo", $aConteudo[$id_idioma]);

                if (strpos($id_idioma, "#") === FALSE) {
                    $oPaginaIdiomaAction->add($rPaginaIdioma, false, false);
                } else {
                    $rPaginaIdioma->set("Idioma", substr($id_idioma, 0, strpos($id_idioma, "#")));
                    $oPaginaIdiomaAction->edit($rPaginaIdioma, false, false);
                }
            }
        }
    }

    protected function editTransaction($oPagina, $request) {
        $this->addTransaction($oPagina, $request);
    }

    protected function delTransaction($id) {
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Pagina' => $id), $qb);
        $qb->delete()->from("PaginaIdioma", "o")->where($where)->getQuery()->execute();
    }

}

?>