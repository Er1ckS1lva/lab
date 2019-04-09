<?php

class ImageUtilParent {

    private function __construct() {
        
    }

    /**
     * Calcula as dimensões mínimas para gerar a miniatura do CROP. 
     * Pode ser usado para prever a largura ou altura mínima desejada de uma imagem a ser recortada.
     * Repasse a altura e largura MÍNIMA desejada nos parametros $width e $height,e escolha entre passar a nova largura ou altura, nunca ambos.
     * No caso, se passar a altura, passe nulo na largura, e vice versa.
     * @param int $width Largura da imagem (geralmente a largura mínima)
     * @param int $height Altura da imagem (geralmente a altura mínima)
     * @param int $new_width (opcional) Largura mímima desejada
     * @param int $new_height (opcional) Altura Mímima desejada
     * @return array um vetor com as posições X e Y (largura e altura, respectivamente)
     */
    public static function calculateMinimunDimension($width, $height, $new_width = NULL, $new_height = NULL) {
        #$height / $width = $new_height / $new_width 
        if ($new_width === NULL) {
            $new_width = round(($width / $height) * $new_height);
        } else {
            $new_height = round(($height / $width) * $new_width);
        }
        return array("x" => $new_width, "y" => $new_height);
    }

    /**
     * Calcula a dimensão desejada de uma imagem para ser redimensionada ou recortada
     * @param int $width a largura da imagem
     * @param int $height a altura da imagem
     * @param int $max_width a altura máxima que esta imagem deve ter
     * @param int $max_height a largura máxima que esta imagem deve ter
     * @return array com as duas dimensoes novas (posicao 'x' e 'y')
     */
    public static function calculateDimension($width, $height, $max_width = 800, $max_height = 600) {
        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;
        if (($width <= $max_width) && ($height <= $max_height)) {
            $new_width = $width;
            $new_height = $height;
        } elseif (($x_ratio * $height) < $max_height) {
            $new_height = ceil($x_ratio * $height);
            $new_width = $max_width;
        } else {
            $new_width = ceil($y_ratio * $width);
            $new_height = $max_height;
        }
        return array("x" => $new_width, "y" => $new_height);
    }

    public static function deleteImages($entityPath, $id) {
        $dir = dirname(__FILE__) . "/../../../../upload/$entityPath/";
        FileUtil::removeAllFiles($dir, $id);
        return true;
    }

    public static function deleteImageCrop($entityPath, $id) {
        $dir = dirname(__FILE__) . "/../../../../upload/$entityPath/";
        $name = FileUtil::getFileNameByDirAndId($dir, $id);
        $path_to_file = $dir . $name;
        $path_to_file_crop = $dir . str_replace(".", "_c.", $name);
        $path_to_file_thumb = $dir . str_replace(".", "_t.", $name);
        @unlink($path_to_file);
        @unlink($path_to_file_crop);
        @unlink($path_to_file_thumb);
    }

    /**
     * Função que recorta a imagem, utilizando parametros manipulados pelo jCrop
     * @param string $entityPath o nome da entidade
     * @param int $id o id pra recuperar a imagem
     * @param int $w a largura para cortar
     * @param int $h a altura para cortar
     * @param int $x a posicao X para cortar
     * @param int $y a posicao Y para cortar
     */
    public static function makeImageCrop($entityPath, $id, $w = 160, $h = 160, $x = -1, $y = -1) {
        $dir = dirname(__FILE__) . "/../../../../upload/$entityPath/";
        if (!$w || !$h) {
            throw new Exception("Erro 01: ao recortar a imagem!\nImagem não encontrada!");
        } else {
            $path_to_file = FileUtil::getFileByDirId($dir, $id);
            $name = FileUtil::getFileNameByDirAndId($dir, $id);
            if ($name && file_exists($path_to_file)) {
                $oImg = new m2brimagem($path_to_file);
                if ($oImg->valida() == 'OK') { //verifica se a img é valida
                    //redimensiona imagem
                    $new_dimension = ImageUtil::calculateDimension($oImg->getLargura(), $oImg->getAltura());
                    $oImg->redimensiona($new_dimension['x'], $new_dimension['y']);
                    $oImg->grava($path_to_file);

                    //constroi as imagens depois de redimensionar
                    $oImgCrop = new m2brimagem($path_to_file);
                    $oImgThumb = new m2brimagem($path_to_file);

                    //Cropar imagem
                    if ((isset($x) && isset($y)) && ($x >= 0 || $y >= 0)) {
                        $oImgCrop->posicaoCrop($x, $y);
                    }
                    $oImgCrop->redimensiona($w, $h, 'crop');
                    $path_to_file_crop = $dir . str_replace(".", "_c.", $name);
                    $oImgCrop->grava($path_to_file_crop);
                    chmod($path_to_file_crop, 0777);

                    //$oImgThumb->posicaoCrop(0, 0);
                    $oImgThumb->redimensiona(80, 80, 'crop');
                    $path_to_file_thumb = $dir . str_replace(".", "_t.", $name);
                    $oImgThumb->grava($path_to_file_thumb);
                    chmod($path_to_file_thumb, 0777);
                } else {
                    throw new Exception("Erro 02: ao recortar a imagem!\nImagem Inválida!");
                }
            }
        }
    }

    /**
     * Função que redimensiona a imagem, podendo cortar ou preencher espaços que faltam para o tamanho ideal
     * @param string $entityPath Nome da entidade (podendo ter subníveis utilizando a '/' (barra)
     * @param string $id O id, que é o NOME da imagem em questão
     * @param int $w Largura máxima, aqui é a largura do objeto a ser cortado
     * @param int $h 
     * @param string $method Tipo de redimensionamento, pode ser CROP ou FILL (padrão)
     * @param array $color vetor com a cor em RGB
     * @throws Exception Caso dê algum erro, esta lança uma exceção com o contexto do erro.
     */
    public static function makeImageResize($entityPath, $id, $w = 160, $h = 160, $method = "fill", $color = array(255, 255, 255)) {
        $dir = dirname(__FILE__) . "/../../../../upload/$entityPath/";
        if (!$w || !$h) {
            throw new Exception("Erro 01: ao recortar a imagem!\nImagem não encontrada!");
        } else {
            $path_to_file = FileUtil::getFileByDirId($dir, $id);
            $name = FileUtil::getFileNameByDirAndId($dir, $id);
            if ($name && file_exists($path_to_file)) {
                $oImg = new m2brimagem($path_to_file);
                if ($oImg->valida() == 'OK') { //verifica se a img é valida
                    //redimensiona imagem
                    $new_dimension = ImageUtil::calculateDimension($oImg->getLargura(), $oImg->getAltura());
                    $oImg->redimensiona($new_dimension['x'], $new_dimension['y'], $method);
                    $oImg->grava($path_to_file);

                    //constroi as imagens depois de redimensionar
                    $oImgCrop = new m2brimagem($path_to_file);
                    $oImgThumb = new m2brimagem($path_to_file);
                    $oImgMini = new m2brimagem($path_to_file);

                    $oImgCrop->redimensiona($w, $h);
                    $path_to_file_crop = $dir . str_replace(".", "_c.", $name);
                    $oImgCrop->grava($path_to_file_crop);
                    chmod($path_to_file_crop, 0777);

                    //$oImgThumb->posicaoCrop(0, 0);
                    $oImgThumb->redimensiona(75, 75, $method);
                    $path_to_file_thumb = $dir . str_replace(".", "_t.", $name);
                    $oImgThumb->grava($path_to_file_thumb);
                    chmod($path_to_file_thumb, 0777);

                    //$oImgThumb->posicaoCrop(0, 0);
                    $oImgMini->redimensiona(33, 33, $method);
                    $path_to_file_thumb = $dir . str_replace(".", "_m.", $name);
                    $oImgMini->grava($path_to_file_thumb);
                    chmod($path_to_file_thumb, 0777);
                } else {
                    throw new Exception("Erro 02: ao recortar a imagem!\nImagem Inválida!");
                }
            }
        }
    }

    /**
     * Função que reduz a imagem original e cria apenas uma miniatura da mesma
     * @param type $entityPath Nome da entidade
     * @param type $id Id da imagem principal
     * @param type $sufix (opcional) O Sufixo desejado (pode ser uma ou mais letras, mas lembre de apagar os sufixos não padrões quando remover a imagem principal!)
     * @param type $w (opcional) Largura desejada da miniatura
     * @param type $h (opcional) Altura desejada da miniatura
     * @param type $x (opcional) Numero positivo e menor que altura máxima da imagem para o corte no eixo X
     * @param type $y (opcional) Numero positivo e menor que altura máxima da imagem para o corte no eixo Y
     * @throws Exception Caso falhe, lança uma exceção para voltar a transação.
     */
    public static function makeImageThumb($entityPath, $id, $sufix = "t", $w = 80, $h = 80, $x = -1, $y = -1) {
        $dir = dirname(__FILE__) . "/../../../../upload/$entityPath/";
        $path_to_file = FileUtil::getFileByDirId($dir, $id);
        $name = FileUtil::getFileNameByDirAndId($dir, $id);
        if ($name && file_exists($path_to_file)) {
            $oImg = new m2brimagem($path_to_file);
            if ($oImg->valida() == 'OK') { //verifica se a img é valida
                //redimensiona imagem
//            $new_dimension = ImageUtil::calculateDimension($oImg->getLargura(), $oImg->getAltura());
//            $oImg->redimensiona($new_dimension['x'], $new_dimension['y']);
//            $oImg->grava($path_to_file);
                //constroi as imagens depois de redimensionar
                $oImgThumb = new m2brimagem($path_to_file);

                if ($x > 0 && $y > 0) {
                    #$oImgThumb->posicaoCrop($x, $y);
                }
                $oImgThumb->redimensiona($w, $h, 'crop');
                $path_to_file_thumb = $dir . str_replace(".", "_{$sufix}.", $name);
                $oImgThumb->grava($path_to_file_thumb);
                chmod($path_to_file_thumb, 0777);
            } else {
                FileUtil::removeFile($dir, $id);
                throw new Exception("Erro 02: ao recortar a imagem!\nImagem Inválida!");
            }
        }
//        else{
//            exit($path_to_file);
//        }
    }

}