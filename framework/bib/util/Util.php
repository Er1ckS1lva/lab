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

}

?>