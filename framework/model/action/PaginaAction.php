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

        $videoApresentacao = $request->get("videoApresentacao");
        if (isset($videoApresentacao['error']) && $videoApresentacao['error'] != 4) {
            if ($videoApresentacao['error'] != 0 && $videoApresentacao['size'] <= 0 && !$edicao) {
                throw new Exception("Por favor, informe o Video de Apresentação!");
            } elseif ($videoApresentacao['error'] === 0 && $videoApresentacao['size'] > 0) {
                $filename = basename($videoApresentacao['name']);
                $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $extensions = $this->recuperaExtensaoVideo();
                $mimes = $this->recuperaTipoVideo();
                $fileMaxSizeMB = (int) ini_get('upload_max_filesize');
                $fileMaxSize = $fileMaxSizeMB * 1024 * 1024; # 10 MB
                if ($videoApresentacao["size"] > $fileMaxSize) {
                    throw new Exception("Atenção: Somente arquivos com tamanho máximo de {$fileMaxSizeMB}MB são aceitos para upload!");
                }
                if (!in_array($ext, $extensions) || !in_array($videoApresentacao['type'], $mimes)) {
                    throw new Exception("Atenção: Somente arquivos com a extensão " . join(', ', $extensions) . " são aceitos para upload!");
                }
            }
        }

        return true;
    }

    public static function recuperaExtensaoVideo() {
        return array('mp4');
    }

    public static function recuperaTipoVideo() {
        return array('video/mp4');
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

        $videoApresentacao = $request->get("videoApresentacao");
        if ($videoApresentacao && $videoApresentacao['error'] === 0) {
            FileUtil::makeFileUpload('Pagina/videoApresentacao', $oPagina->getId(), 'videoApresentacao', true);
        }
    }

    protected function editTransaction($oPagina, $request) {
        $this->addTransaction($oPagina, $request);
    }

    protected function delTransaction($id) {
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Pagina' => $id), $qb);
        $qb->delete()->from("PaginaIdioma", "o")->where($where)->getQuery()->execute();

        FileUtil::removeFile(dirname(__FILE__) . '/../../../upload/Pagina/videoApresentacao', $id);
    }

}

?>