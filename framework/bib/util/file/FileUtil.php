<?php

class FileUtil extends FileUtilParent {

    public static function makeFileUploadPosicaoRoot($entityPath, $id, $field, $nPosicao, $edit) {
        if ((!empty($_FILES[$field])) && ($_FILES[$field]['error'][$nPosicao] == 0)) {
            $filename = basename($_FILES[$field]['name'][$nPosicao]);

            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $newname = LOCAL_CAMERA . "/$entityPath/$id.$ext";

            if ($edit) {
                self::removeAllFiles(LOCAL_CAMERA . "/$entityPath/", $id);
                self::removeAllFiles(LOCAL_CAMERA . "/$entityPath/", "{$id}_c");
                self::removeAllFiles(LOCAL_CAMERA . "/$entityPath/", "{$id}_t");
            }
            if (!file_exists(dirname($newname))) {
                mkdir(dirname($newname), 0777, true);
            }
            if (!(copy($_FILES[$field]['tmp_name'][$nPosicao], $newname))) {
                throw new Exception("Atenção: Ocorreu um problema ao copiar o arquivo para a pasta de upload!");
            }
            chmod($newname, 0777);
            
            return $newname;
        }
    }

}
