<?php

class Validate {

    public static function validateEmail($email) {
        // Create the syntactical validation regular expression
        $regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
        // Presume that the email is invalid
        $valid = 0;
        // Validate the syntax
        if (eregi($regexp, $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateLogin($login) {
        return ereg("^([a-z])([a-z_0-9]){1,23}([a-z0-9])$",$x);
        return true;
    }

    public static function validateDate($data, $formato = 'normal') {
        switch ($formato) {
            case 'normal':
                $vet = explode("/", $data);
                return checkdate((int) $vet[1], (int) $vet[0], (int) $vet[2]);
                break;
            case 'mysql':
                $vet = explode("-", $data);
                return checkdate((int) $vet[1], (int) $vet[2], (int) $vet[0]);
                break;
            default: return false;
        }
    }

    public static function validateTime($hora) {
        return ereg("^([0-9]){2}:([0-9]){2}$", $hora);
    }

    /**
     * Valida campo(s) único(s) dentro de uma entidade.
     * @param string $entidade A Entidade em questão
     * @param array $colunasUnicas um vetor com o(s) atributos(s) onde o atributo é a coluna e o valor é o seu valor
     * @param array $chaves um vetor com a(s) chave(s) primária(s), onde o atributo é a coluna e o valor é o seu valor
     * @param EntityManager $em Uma instancia do EntityManager com conexão ativa.
     * @param boolean $isEdicao (opcional) se for edição, para verificar a unicidade no caso da edição. É obrigatório se você está validando uma edição
     * @return boolean VERDADEIRO se não houver nenhuma ocorrencia no banco, FALSO caso contrário.
     */
    public static function validateCampoUnico( $entidade, $colunasUnicas, $chaves, $em, $isEdicao = false) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
        $qb = $em->createQueryBuilder();
        $query = $qb->select('o')->from($entidade, 'o');
        $where = QueryHelper::getAndEquals($colunasUnicas, $qb);
        $query->andWhere($where);
        if ($isEdicao) {
            $where = QueryHelper::getAndUnequals($chaves, $qb);
            $query->andWhere($where);
        }
//        exit($query->getQuery()->getSql());
        $object = $query->getQuery()->getOneOrNullResult();
        $result = true;
        if ($object)
            $result = false;
        return $result;
    }

}

?>
