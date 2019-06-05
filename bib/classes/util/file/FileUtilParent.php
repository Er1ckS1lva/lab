<?php

class FileUtilParent {

    private function __construct() {
        
    }

    public static function makeFileValidate($allowNull, $field, $type = "", $extensions = NULL, $fileMaxSize = "2097152") {
        if (!in_array($ext, $extensions) || !in_array($_FILES[$field]['type'], $mimes)) {
            throw new Exception("Erro: Somente arquivos de extensão " . join(', ', $extensions) . " são aceitos por upload!");
            return false;
        }
        if ($_FILES[$field]["size"] > $fileMaxSize) {
            throw new Exception("Erro: Tamanho do arquivo deve ser menor ou igual a 300000!");
            return false;
        }
        return true;
    }

    public static function makeFileUpload($entityPath, $id, $field, $edit) {
        if ((!empty($_FILES[$field])) && ($_FILES[$field]['error'] == 0)) {
            $filename = basename($_FILES[$field]['name']);

            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $newname = IGENIAL_DIR_UPLOAD . "/$entityPath/$id.$ext";

            if ($edit) {
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", $id);
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", "{$id}_c");
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", "{$id}_t");
            }
            if(!file_exists(dirname($newname))){
                mkdir(dirname($newname), 0777, true);
            }
            if (!(copy($_FILES[$field]['tmp_name'], $newname))) {
                throw new Exception("Atenção: Ocorreu um problema ao copiar o arquivo para a pasta de upload!");
            }
            chmod($newname, 0777);
        }
    }
	
	public static function makeFileUploadPosicao($entityPath, $id, $field, $nPosicao, $edit) {
        if ((!empty($_FILES[$field])) && ($_FILES[$field]['error'][$nPosicao] == 0)) {
            $filename = basename($_FILES[$field]['name'][$nPosicao]);

            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $newname = IGENIAL_DIR_UPLOAD . "/$entityPath/$id.$ext";

            if ($edit) {
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", $id);
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", "{$id}_c");
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", "{$id}_t");
            }
            if(!file_exists(dirname($newname))){
                mkdir(dirname($newname), 0777, true);
            }
            if (!(copy($_FILES[$field]['tmp_name'][$nPosicao], $newname))) {
                throw new Exception("Atenção: Ocorreu um problema ao copiar o arquivo para a pasta de upload!");
            }
            chmod($newname, 0777);
        }
    }
    
    public static function saveFileContents($entityPath, $id, $filename, $content, $edit = FALSE) {
        if (isset($content)) {
            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
            $newname = IGENIAL_DIR_UPLOAD . "/$entityPath/$id.$ext";

            if ($edit) {
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", $id);
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", "{$id}_c");
                self::removeAllFiles(IGENIAL_DIR_UPLOAD . "/$entityPath/", "{$id}_t");
            }
            
            if (file_put_contents($newname, $content) === FALSE) {
                throw new Exception("Atenção: Ocorreu um problema ao mover o arquivo para a pasta de upload!");
            }
            chmod($newname, 0777);
        }
    }

    /**
     * procura pelo id e pelo tipo, senão passar tipo lista todos pelo id passado
     * @param string $directory ok
     * @param integer $id ok
     * @param tipo do arquivo ok
     */
    public static function getFileNameByDirAndIdAndTipo($directory, $id, $tipo = null) {
        $result = null;
        $handler = opendir($directory);
        $result = array();
        while ($file = readdir($handler)) {
            if ($file != '.' && $file != '..') {
                $pos = strpos($file, '.');
                if ($pos !== false) {
                    $tipoDir = explode(".", $file);
                    if ($tipoDir[1] != 'svn') { // se tiver no repositorio
                        $tipoDir = $tipoDir[1];
                        if ($tipo) {
                            if (in_array($tipoDir, $tipo)) {
                                $str = substr($file, 0, $pos);
                                if ($str == $id) {
                                    $result = $file;
                                    break;
                                }
                            }
                        } else {
                            $str = substr($file, 0, $pos);
                            if ($str == $id) {
                                $result[] = $file;
                                //break;
                            }
                        }
                    }
                }
            }
        }
        closedir($handler);
        return $result;
    }

    /**
     * remove todos os arquivos id independente do tipo
     * @param string $directory ok
     * @param integer $id ok
     */
    public static function removeAllFiles($dir, $id) {
        $file = self::getFileNameByDirAndIdAndTipo($dir, $id);
        foreach ($file as $file) {
            if ($file) {
                if (!unlink($dir . '/' . $file)) {
                    throw new Exception('Erro ao excluir arquivo: ' . $file);
                }
            }
        }
    }

    /**
     * Lista um diretório, não deve ser usado de qualquer forma!
     * @param string $directory caminho para o diretório a ser listado
     * @return array um vetor com os aruivos/pastas encontrados no diretório
     */
    public static function dirList($directory) {
        $results = array();
        $handler = opendir($directory);
        while ($file = readdir($handler)) {
            if ($file != '.' && $file != '..')
                $results[] = $file;
        }
        closedir($handler);
        return $results;
    }

    /**
     * Recupera o arquivo pelo ID
     * @param string $directory diretorio do arquivo
     * @param integer $id indice (sem extensão)
     */
    public static function getFileNameByDirAndId($directory, $id) {
        $result = null;
        $handler = opendir($directory);
        while ($file = readdir($handler)) {
            if ($file != '.' && $file != '..') {
                $pos = strpos($file, '.');
                if ($pos !== false) {
                    $str = substr($file, 0, $pos);
                    if ($str == $id) {
                        $result = $file;
                        break;
                    }
                }
            }
        }
        closedir($handler);
        return $result;
    }

    public static function removeFile($dir, $id) {
        $file = self::getFileNameByDirAndId($dir, $id);
        if ($file) {
            if (!unlink($dir . '/' . $file)) {
                throw new Exception('Erro ao excluir arquivo: ' . $file);
            }
        }
    }

    public static function getFileByDirId($dir, $id) {
        $file = self::getFileNameByDirAndId($dir, $id);
        if (file_exists($dir . '/' . $file)) {
            return $dir . '/' . $file;
        } else {
            return "Arquivo '{$file}' não encontrado!";
        }
    }

}