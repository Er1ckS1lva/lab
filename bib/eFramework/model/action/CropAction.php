<?php

class CropAction {

    protected $msg;

    public function __construct() {
        
    }

    public function setMsg($msg) {
        $this->msg = $msg;
    }

    public function getMsg() {
        return $this->msg;
    }

    public function manipulaImagem($request, &$response) {
        unset($_SESSION['imagem']);
        $fieldName = ($request->get('fieldName') ? $request->get('fieldName') : 'imagem');
        $imagem = $request->get($fieldName);
        if (!isset($imagem['name'])) {
            $this->setMsg("Selecione uma imagem!");
            return false;
        }

        $dir = dirname(__FILE__) . "/../../../../upload/tmp"; #volta pra raiz
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true); # se não tiver pasta tmp ele cria
        }
        $ext = substr($imagem['name'], (strlen($imagem['name'])) - 3, 4);
        do {
            $name = rand(1, 99999);
            $newfile = $dir . '/' . "$name.$ext";
        } while (file_exists($newfile));
        if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $newfile)) {
            $this->setMsg("Erro ao mover o arquivo!");
            return false;
        }
        $oImg = new m2brimagem($newfile);
        if ($oImg->valida() == "OK") {
            $new_mini_dimension = ImageUtil::calculateMinimunDimension($request->get('minWidth'), $request->get('minHeight'), NULL, 100);
            $response->set('minWidth', $new_mini_dimension['x']);
            $response->set('minHeight', $new_mini_dimension['y']);

            $new_dimension = ImageUtil::calculateDimension($oImg->getLargura(), $oImg->getAltura());
            #Util::debug($new_dimension);
            $oImg->redimensiona($new_dimension['x'], $new_dimension['y']);
            $oImg->grava($newfile);
            if (is_file($newfile)) {
                $_SESSION['imagem'] = file_get_contents($newfile);
            } else {
                $this->setMsg("Erro: Imagem não encontrada!");
                return false;
            }
            @unlink($newfile);
        } else {
            $this->setMsg("Selecione uma imagem válida!");
            return false;
        }
        $response->set('width', $new_dimension['x']);
        $response->set('height', $new_dimension['y']);
        return true;
    }

}

?>