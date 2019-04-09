<?php

class MediaUtilParent {

    private function __construct() {

    }

    /**
     * procura pelo id e pelo tipo, senão passar tipo lista todos pelo id passado
     * @param string $entity ok
     * @param integer $id ok
     * @param tipo do arquivo ok
     */
    public static function getLinkForFileNameByTipo($entity, $id, $tipo=null) {
        $uploadHrefDir = "upload/$entity";
        $dir = dirname(__FILE__) . "/../../../$uploadHrefDir";
        $fileName = FileUtil::getFileNameByDirAndIdAndTipo($dir, $id, $tipo);

        if (!$fileName) {
            return 'javascript: void(0);';
        }

        return "$uploadHrefDir/$fileName";
    }
    
    public static function getLinkOrPlacehold($entity,$id,$hasImg,$t='',$empty='http://placehold.it/75&text=vazio',$notfound='http://placehold.it/75&text=404') {
        if($hasImg)
            $src = MediaUtil::getLinkForFileNameById($entity, $id.$t);
        else
            return $empty;

        return $src=='javascript: void(0);'? $notfound: $src ;
    }
    
    public static function getLinkForFileNameById($entity, $id) {
        $dir = IGENIAL_DIR_UPLOAD . "/$entity";
        $fileName = FileUtil::getFileNameByDirAndId($dir, $id);
        if (!$fileName) {
            return 'javascript: void(0);';
        }
        return URL_UPLOAD . "{$entity}/{$fileName}?id=" . time();
    }

    public static function treatLink($link) {
        if (strpos($link, 'void(0)') !== false) {
            return 'upload/../../../bib/img/nofile-icon-72x72.png';
        }
        $dotIndex = strpos($link, '.');
        $ext = substr($link, $dotIndex + 1, strlen($link));

        switch ($ext) {
            case 'jpg':
            case 'png':
            case 'gif':
                //do nothing, because it has to be the link itself
                break;
            case 'pdf':
                $link = 'upload/../../../bib/img/pdf-icon-72x72.png';
                break;
            case 'doc':
            case 'docx':
                $link = 'upload/../../../bib/img/word-icon-72x72.png';
                break;
            default:
                $link = 'upload/../../../bib/img/file-icon-72x72.png';
                break;
        }
        return $link;
    }

}

?>