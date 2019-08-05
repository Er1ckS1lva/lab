<?php

class Util extends UtilParent {

    public static function IdiomaGetDados($aDados, $idioma_classe, $idIdioma = null, $aFieldToSet = array("titulo", "descricao", "conteudo")) {
        $aRet = array();
        if ($aDados) {
            $aDados = is_array($aDados) ? $aDados : array($aDados);
            # recupera o idioma padrao
            if (!$idIdioma)
                $idIdioma = IdiomaAction::getIdIdioma();

            # instancia as classes em tempo de execucao
            eval("\$action_idioma = new {$idioma_classe}Action();");
            $classe = get_class($aDados[0]); # classe para qual o objeto recupera
            eval("\$action = new {$classe}Action();");

            foreach ($aDados as $dado) {
                $obj = $action_idioma->select($dado->getId(), $idIdioma);
                if ($obj) {
                    error_reporting(E_ALL & ~E_NOTICE);
                    /*
                     * Este erro ocorreu mas não tem problema, ver erro aqui:
                      Notice: Array to string conversion in D:\www\laboratoriovirtual_ufu\src\trunk\ext\doctrine\vendor\doctrine\orm\lib\Doctrine\ORM\UnitOfWork.php on line 2913
                     */
                    $aDado = $action_idioma->toArray($obj);
                    if ($obj) {
                        # recupera os valores e seta em array e depois reconverte para object
                        eval("\$o = \$obj->get{$classe}();");
                        $aObj = $action->toArray($o);
                        foreach ($aFieldToSet as $field) {
                            $field_input = $aDado[$field];
                            $aObj[$field] = $field_input;
                        }
//                        $aRet["{$o->getId()}_{$idIdioma}"] = $action->toObject($aObj);
                        $aRet[] = $action->toObject($aObj);
                    }
                } else {
//                    exit("O registro com: ID {$dado->getId()} - Não esta com o idioma selecionado: ID {$idIdioma}!"); # para validar senão tiver - verificar
                }
            }
        }
        return $aRet;
    }

    public static function convert2stdClass($object) {
        $serializedObj = serialize($object);
        $stdClassObj = preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen('stdClass') . ':"stdClass"', $serializedObj);

        return unserialize($stdClassObj);
    }

    public static function doLogFile($cmd) {
        error_reporting(E_ALL); # volta ao padrao
        try {
            $output = shell_exec($cmd);
            
            //exec($cmd, $output, $return_var);
            var_dump($output);
            var_dump($return_var); 
            
        } catch (Exception $ex) {
            var_dump($ex);
        }
        var_dump($output);
        $write = ob_get_contents();
        ob_end_clean();

        # tenta criar o arquivo
        $new_file = 'log-' . date("dmY") . '.log';
        $file_name = IGENIAL_ROOT_DIR . "/upload/temp/{$new_file}";

        if (!file_exists($file_name)) {
            fopen($file_name, 'w+');
            if ($file_name == false)
                die("Não foi possível criar o arquivo: {$new_file}.");

            chmod($file_name, 0777);
            if (!file_put_contents($file_name, PHP_EOL . implode(' ', array(
                                date("H:i:s") . " -",
                                "({$cmd})",
                                $write,
                            )), FILE_APPEND)) {
                exit("Impossivel criar o arquivo '{$file_name}'");
            }
        } else {
            file_put_contents($file_name, PHP_EOL . implode(' ', array(
                        date("H:i:s") . " -",
                        "({$cmd})",
                        $write,
                    )), FILE_APPEND);
        }
        return $output;
    }

}

?>
