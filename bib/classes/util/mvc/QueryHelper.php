<?php

class QueryHelper {

    /**
     *
     * @param array $fieldsArray
     */
    public static function getSelectFields($fieldsArray) {
        if ($fieldsArray != null && !is_array($fieldsArray)) {
            throw new InvalidArgumentException("É necessário um array dos campos ou NULL para todos os campos.");
        } else if ($fieldsArray == null) {
            $fieldsArray = "o";
        } else {
            $fieldsArrayTmp = array();
            foreach ($fieldsArray as $k => $v) {
                if ($k === "partial") {
                    if (is_array($v)) {
                        $fieldsArrayTmp[] = 'partial o.{' . join(",", $v) . "}";
                    } else {
                        $fieldsArrayTmp[] = 'partial o.{' . $v . "}";
                    }
                } elseif (is_string($k))
                    $fieldsArrayTmp[] = $k . '.' . join(', o.', $v);
                else {
                    if (is_array($v)) {
                        $fieldsArrayTmp[] = 'o.' . join(', o.', $v);
                    } else {
                        $aux = explode(",", $v);
                        $fieldsArrayTmp[] = 'o.' . join(', o.', $aux);
                    }
                }
            }
            $fieldsArray = $fieldsArrayTmp;
        }
        return $fieldsArray;
    }


    public static function verifyObject($_aux, $class, $em) {
        if (!$_aux) {
            return NULL;
        } elseif (is_object($_aux)) {
            return $_aux;
        } elseif (is_numeric($_aux)) {
            return $em->find($class, $_aux);
        }else{
            throw new InvalidArgumentException("Valor inválido para a classe '$class'. Valor informado: $_aux.");
        }
    }

    public static function getAndEquals($aConditions, $qb) {
        if ($aConditions != null && !is_array($aConditions)) {
            throw new InvalidArgumentException("É necessário um array dos campos ou NULL para todos os campos.");
        }
        $and = $qb->expr()->andX();
        foreach ($aConditions as $nomeColuna => $value) {
            $and->add($qb->expr()->eq($nomeColuna, $value));
        }
        return $and;
    }
    
    public static function getAndUnequals($aConditions, $qb) {
        /* @var $qb \Doctrine\ORM\QueryBuilder */
        if ($aConditions != null && !is_array($aConditions)) {
            throw new InvalidArgumentException("É necessário um array dos campos ou NULL para todos os campos.");
        }
        $and = $qb->expr()->andX();
        foreach ($aConditions as $nomeColuna => $value) {
            $and->add($qb->expr()->neq($nomeColuna, $value));
        }
        return $and;
    }
    
    public static function getOrEquals($aConditions, $qb) {
        if ($aConditions != null && !is_array($aConditions)) {
            throw new InvalidArgumentException("É necessário um array dos campos ou NULL para todos os campos.");
        }
        $or = $qb->expr()->orX();
        foreach ($aConditions as $nomeColuna => $value) {
            $or->add($qb->expr()->eq($nomeColuna, $value));
        }
        return $or;
    }
	
	public static function getLikeExpression($aConditions, $qb) {
        if ($aConditions != null && !is_array($aConditions)) {
            throw new InvalidArgumentException("É necessário um array dos campos ou NULL para todos os campos.");
        }
        $or = $qb->expr()->orX();
        foreach ($aConditions as $nomeColuna => $value) {
            $or->add($qb->expr()->like("UPPER({$nomeColuna})", Util::acentosCaixaAlta($value)));            
        }
        return $or;
    }
	
	public static function getFieldsForClass($className, $entityManager, $isGetFk = true) {
        $aFields = $entityManager->getMetadataFactory()->getMetadataFor($className)->fieldMappings;
        if ($isGetFk) {
            $aFkFields = QueryHelper::getFkFieldsForClass($className, $entityManager);
            $aFields = array_merge($aFields, $aFkFields);
        }
        return $aFields;
    }

    public static function getFkFieldsForClass($className, $entityManager) {
        $FkFields = $entityManager->getMetadataFactory()->getMetadataFor($className)->getAssociationMappings();
        $aFkFields = array();
        if ($FkFields) {
            foreach ($FkFields as $field => $aField) {
                $aFkFields[$field]["isFk"] = true;
                $aFkFields[$field]["fieldName"] = $field;
                $aFieldProperties = array(
                    "columnName" => array(),
                    "columnDefinition" => array(),
                    "unique" => array(),
                    "nullable" => array(),
                    "referencedColumnName" => array()
                );
                if ($aField["joinColumns"]) {
                    foreach ($aField["joinColumns"] as $fieldJoin) {
                        $aFieldProperties["columnName"][] = $fieldJoin["name"];
                        $aFieldProperties["columnDefinition"][] = $fieldJoin["columnDefinition"];
                        $aFieldProperties["unique"][] = $fieldJoin["unique"];
                        $aFieldProperties["nullable"][] = $fieldJoin["nullable"];
                        $aFieldProperties["referencedColumnName"][] = $fieldJoin["referencedColumnName"];
                    }
                }
                $aFkFields[$field]["columnName"] = implode(", ", $aFieldProperties["columnName"]);
                $aFkFields[$field]["columnDefinition"] = implode(", ", $aFieldProperties["columnDefinition"]);
                $aFkFields[$field]["unique"] = implode(", ", $aFieldProperties["unique"]);
                $aFkFields[$field]["nullable"] = implode(", ", $aFieldProperties["nullable"]);

                if ($aFieldProperties["referencedColumnName"]) {
                    foreach ($aFieldProperties["referencedColumnName"] as $referencedColumnName) {
                        $aPkFkMap = array("map" => $entityManager->getMetadataFactory()->getMetadataFor("{$aField["targetEntity"]}")->fieldMappings);
                        $aPkFkFields = array();
                        foreach ($aPkFkMap["map"] as $k => $v) {
							$v["entity"] = $aField["targetEntity"];
                            $aPkFkFields["field"][$v["columnName"]] = $v;
                        }
                        $aPkFk = array_merge($aPkFkMap, $aPkFkFields);
                        $aFkFields[$field][] = ($aPkFk["field"][$referencedColumnName]);
                    }
                }
            }
        }
        return $aFkFields;
    }

}

?>
