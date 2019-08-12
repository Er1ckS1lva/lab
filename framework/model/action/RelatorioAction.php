<?php

class RelatorioAction {

    protected $msg;
    protected $em;

    public function __construct($em = NULL) {
        $this->em = $em === NULL ? DoctrineBootstrap::iGenialConnection('') : $em;
    }

    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($e) {
        $this->msg = ExceptionHandler::getMessage($e);
    }

    public function getConnection() {
        return $this->em;
    }

    public static function getEntityName() {
        return 'Relatório';
    }

//
//    public static function getTableName() {
//        return 'aluno_acesso';
//    }

    public static function getModuleName() {
        return 'relatorio';
    }

    public static function getClassName() {
        return 'Relatorio';
    }

    public static function getBaseUrl() {
        return URL . AlunoAcessoAction::getModuleName() . "/Relatorio/";
    }

    public static function getValuesHora() {
        return array('00:00' => '00:00hs', '01:00' => '01:00hs', '02:00' => '02:00hs', '03:00' => '03:00hs', '04:00' => '04:00hs', '05:00' => '05:00hs', '06:00' => '06:00hs', '07:00' => '07:00hs', '08:00' => '08:00hs', '09:00' => '09:00hs', '10:00' => '10:00hs', '11:00' => '11:00hs', '12:00' => '12:00hs', '13:00' => '13:00hs', '14:00' => '14:00hs', '15:00' => '15:00hs', '16:00' => '16:00hs', '17:00' => '17:00hs', '18:00' => '18:00hs', '19:00' => '19:00hs', '20:00' => '20:00hs', '21:00' => '21:00hs', '22:00' => '22:00hs', '23:00' => '23:00hs');
    }

    public static function getComboBoxHora($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'hora') {
        $valores = self::getValuesHora();
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getValuesMes() {
        return array("01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril",
            "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", "09" => "Setembro",
            "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro");
    }

    public static function getComboBoxMes($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'mes') {
        $valores = self::getValuesMes();
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    // BEGIN QUERIES GERAIS PARAMETIZADAS
    public function collectionNative($table, $fieldsToSelect = "*", $conditions = NULL, $joins = array(), $order = NULL, $groupBy = NULL, $limit = FALSE) {
        $fields = is_array($fieldsToSelect) ? $fieldsToSelect : array($fieldsToSelect);
        $sql = "SELECT " . implode(", ", $fields) . "
                FROM {$table} o ";

        if ($joins) {
            foreach ($joins as $join) {
                $sql .= " {$join["type"]} JOIN {$join["table"]} {$join["alias"]} ON {$join["joinConditions"]} ";
            }
        }

        if ($conditions) {
            $aConditions = is_array($conditions) ? $conditions : array($conditions);
            $sql .= " WHERE " . (join(" AND ", $aConditions));
        }

        if ($groupBy) {
            $sql .= " GROUP BY {$groupBy} ";
        }

        if ($order) {
            $sql .= " ORDER BY {$order} ";
        }

        if ($limit !== FALSE) {
            $sql .= " LIMIT {$limit} ";
        }
//        Util::Debug(nl2br($sql));

        try {
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $objects = $stmt->fetchAll();
        } catch (Exception $e) {
            throw($e);
        }
        return $objects;
    }

    public function selectNative($table, $fieldsToSelect = "*", $conditions = NULL, $joins = array(), $order = NULL, $groupBy = NULL, $limit = FALSE) {
        $fields = is_array($fieldsToSelect) ? $fieldsToSelect : array($fieldsToSelect);
        $sql = "SELECT " . implode(", ", $fields) . "
                FROM {$table} o ";

        if ($joins) {
            foreach ($joins as $join) {
                $sql .= " {$join["type"]} JOIN {$join["table"]} {$join["alias"]} ON {$join["joinConditions"]} ";
            }
        }

        if ($conditions) {
            $aConditions = is_array($conditions) ? $conditions : array($conditions);
            $sql .= " WHERE " . (join(" AND ", $aConditions));
        }

        if ($groupBy) {
            $sql .= " GROUP BY {$groupBy} ";
        }

        if ($order) {
            $sql .= " ORDER BY {$order} ";
        }

        if ($limit !== FALSE) {
            $sql .= " LIMIT {$limit} ";
        }
//        Util::Debug(nl2br($sql));

        try {
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $objects = $stmt->fetch();
        } catch (Exception $e) {
            throw($e);
        }
        return $objects;
    }

    public function paginatedCollectionNative($table, $fieldsToSelect = "*", $conditions = array(), $joins = array(), $orderBy = NULL, $groupBy = NULL, $limit = NULL, $page = 0) {
        $fields = is_array($fieldsToSelect) ? $fieldsToSelect : array($fieldsToSelect);
        $sql = "SELECT " . implode(", ", $fields) . "
                FROM {$table} o ";

        if ($joins) {
            foreach ($joins as $join) {
                $sql .= " {$join["type"]} JOIN {$join["table"]} {$join["alias"]} ON {$join["joinConditions"]} ";
            }
        }

        if ($conditions) {
            $aConditions = is_array($conditions) ? $conditions : array($conditions);
            $sql .= " WHERE " . (join(" AND ", $aConditions));
        }

        if ($groupBy) {
            $sql .= " GROUP BY {$groupBy} ";
        }

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy} ";
        }

        if ($limit) {
            $pageIni = ($page * $limit);
            $sql .= " LIMIT {$pageIni}, {$limit} ";
        }

//        Util::Debug(nl2br($sql));

        try {
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $objects = $stmt->fetchAll();
        } catch (Exception $e) {
            throw($e);
        }
        return $objects;
    }

    public function totalRegistros($conditions = NULL) {
        # METODO POR ENQUANTO PARA LABORATORIO
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('count(o)')->from('Laboratorio', 'o');

        if ($conditions) {
            $aConditions = is_array($conditions) ? $conditions : array($conditions);
            foreach ($aConditions as $condition) {
                $query->andWhere($condition);
            }
        }

        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    // END QUERIES GERAIS PARAMETIZADAS

    public function paginatedCollectionLogAcesso($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT aa.*, a.nome aluno, ati.titulo atividade, te.titulo tema
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id=aa.id_aluno)
                LEFT JOIN atividade ati ON(ati.id=aa.id_atividade)
                LEFT JOIN atividade te ON(te.id=ati.id_tema)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        if ($order)
            $sql .= " ORDER BY {$order} ";

        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionLogAcesso($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT aa.*, a.nome aluno, ati.titulo atividade, te.titulo tema
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id=aa.id_aluno)
                LEFT JOIN atividade ati ON(ati.id=aa.id_atividade)
                LEFT JOIN atividade te ON(te.id=ati.id_tema)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        if ($order)
            $sql .= " ORDER BY {$order} ";

        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
        #Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function paginatedCollectionQuantidadeAcessoTema($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT te.titulo as tema, count(te.id) as acesso
                FROM aluno_acesso aa
                INNER JOIN atividade ati ON(ati.id=aa.id_atividade)
                LEFT JOIN tema te ON(te.id=ati.id_tema)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY te.id ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionQuantidadeAcessoTema($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT aa.*, a.nome aluno, ati.titulo atividade, te.titulo tema
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id=aa.id_aluno)
                LEFT JOIN atividade ati ON(ati.id=aa.id_atividade)
                LEFT JOIN atividade te ON(te.id=ati.id_tema)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY te.id ";

        if ($order)
            $sql .= " ORDER BY {$order} ";

        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
        #Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function paginatedCollectionQuantidadeAcessoAtividade($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT ati.titulo as atividade, count(ati.id) as acesso
                FROM aluno_acesso aa
                INNER JOIN atividade ati ON(ati.id=aa.id_atividade)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY ati.id ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionQuantidadeAcessoAtividade($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT ati.titulo as atividade, count(ati.id) as acesso
                FROM aluno_acesso aa
                INNER JOIN atividade ati ON(ati.id=aa.id_atividade)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY te.id ";


        if ($order)
            $sql .= " ORDER BY {$order} ";

        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
        #Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function paginatedCollectionQuantidadeAcessoUsuario($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT a.nome as aluno, count(a.id) as acesso
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id = aa.id_aluno)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY a.id ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionQuantidadeAcessoUsuario($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT ati.titulo as atividade, count(ati.id) as acesso
                FROM aluno_acesso aa
                INNER JOIN atividade ati ON(ati.id=aa.id_atividade)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY te.id ";


        if ($order)
            $sql .= " ORDER BY {$order} ";

        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
        #Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function paginatedCollectionQuantidadeAcessoUsuarioHora($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT a.id, a.nome AS aluno, COUNT(a.id) AS acesso, HOUR(aa.dt_registro) as hora
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id = aa.id_aluno)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY a.id, DAY(aa.dt_registro), HOUR(aa.dt_registro) ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionQuantidadeAcessoUsuarioHora($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT a.id, a.nome AS aluno, COUNT(a.id) AS acesso, HOUR(aa.dt_registro) as hora
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id = aa.id_aluno)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY a.id, DAY(aa.dt_registro), HOUR(aa.dt_registro) ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function paginatedCollectionQuantidadeAcessoAtividadeMensal($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT a.id, a.nome AS aluno, COUNT(a.id) AS acesso, HOUR(aa.dt_registro) as hora
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id = aa.id_aluno)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY a.id, DAY(aa.dt_registro), HOUR(aa.dt_registro) ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionQuantidadeAcessoAtividadeMensal($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT a.id, a.nome AS aluno, COUNT(a.id) AS acesso, HOUR(aa.dt_registro) as hora
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id = aa.id_aluno)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY a.id, DAY(aa.dt_registro), HOUR(aa.dt_registro) ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function paginatedCollectionQuantidadeAcessoTemaPeriodo($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT te.titulo as tema, count(te.id) as acesso
                FROM aluno_acesso aa
                INNER JOIN atividade ati ON(ati.id=aa.id_atividade)
                LEFT JOIN tema te ON(te.id=ati.id_tema)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY te.id ";

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
//        Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionQuantidadeAcessoTemaPeriodo($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT aa.*, a.nome aluno, ati.titulo atividade, te.titulo tema
                FROM aluno_acesso aa
                INNER JOIN aluno a ON(a.id=aa.id_aluno)
                LEFT JOIN atividade ati ON(ati.id=aa.id_atividade)
                LEFT JOIN atividade te ON(te.id=ati.id_tema)
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        $sql .= " GROUP BY te.id ";

        if ($order)
            $sql .= " ORDER BY {$order} ";

        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
        #Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function paginatedCollectionUsuario($fieldsToSelect = "*", $page = 0, $resultsPerPage = 10, $conditions = null, $order = null) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT * FROM aluno a
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }


        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function collectionUsuario($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
        $conditions_join = join($conditions, " AND ");
        $sql = "
                SELECT * FROM aluno a
               ";
        if ($conditions_join) {
            $sql .= " WHERE {$conditions_join} ";
        }

        if ($order)
            $sql .= " ORDER BY {$order} ";


        if ($page !== FALSE && $resultsPerPage !== FALSE) {
            $sql .= " LIMIT {$page}, {$resultsPerPage} ";
        }
        #Util::debug($sql);

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->fetchAll();

        return $aObj;
    }

    public function colletionUsuarioDetalhe($id, $div = NULL) {
        $sql = "";
        switch ($div) {
            case 'div_matricula':
                $sql = "SELECT t.id, t.titulo tema, COUNT(aa.id) qtd_acesso, MIN(aa.dt_registro) primeiro_acesso, MAX(aa.dt_registro) ultimo_acesso
                        FROM aluno a
                        LEFT JOIN aluno_acesso aa ON(a.id=aa.id_aluno AND aa.id_atividade IS NOT NULL)
                        LEFT JOIN atividade ati ON(aa.id_atividade = ati.id)
                        INNER JOIN tema t ON(ati.id_tema = t.id)
                        WHERE a.id={$id}
                        GROUP BY t.id
                        ORDER BY a.nome ASC";
                $methodName = "fetchAll";
                break;
            case 'div_avaliacao':
                $sql = "SELECT t.titulo as tema, 100 as escala_nota, COALESCE(avg(aa.score), 0) as media, COALESCE((SELECT avg(subaa.score) as media_tema FROM tema subt
                        LEFT JOIN atividade suba ON(suba.id_tema = subt.id)
                        LEFT JOIN aluno_atividade subaa ON(subaa.id_atividade = suba.id)
                        LEFT JOIN aluno subal ON(subal.id = subaa.id_aluno)
                        WHERE subt.id=t.id
                        GROUP BY subt.id), 0) as media_tema
                        FROM tema t
                        LEFT JOIN atividade a ON(a.id_tema = t.id)
                        LEFT JOIN aluno_atividade aa ON(aa.id_atividade = a.id)
                        LEFT JOIN aluno al ON(al.id = aa.id_aluno)
                        WHERE al.id={$id}
                        GROUP BY t.id
                        ORDER BY t.titulo ASC";
                $methodName = "fetchAll";
                break;

            default:
                $sql = "SELECT a.nome, a.email, a.id, COUNT(aa.id) qtd_acesso, COUNT(distinct ati.id) qtd_atividade, COUNT(distinct t.id) qtd_tema, MIN(aa.dt_registro) primeiro_acesso, MAX(aa.dt_registro) ultimo_acesso
                FROM aluno a
                LEFT JOIN aluno_acesso aa ON(a.id=aa.id_aluno)
                LEFT JOIN atividade ati ON(aa.id_atividade = ati.id)
                LEFT JOIN tema t ON(ati.id_tema = t.id)
                WHERE a.id={$id}
                GROUP BY a.id
                ORDER BY a.nome ASC";
                $methodName = "fetch";
                break;
        }
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aObj = $stmt->{$methodName}();
        return $aObj;
    }

    public function getTotalScore($id_atividade, $id_aluno) {
        $sql = "SELECT o.id, o.score
                FROM aluno_atividade_envios o ";
        $sql .= " WHERE o.id_aluno = '{$id_aluno}' AND o.id_atividade = '{$id_atividade}' ";
//        Util::Debug(nl2br($sql));

        try {
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $objects = $stmt->fetch();
        } catch (Exception $e) {
            throw($e);
        }
        return $objects;
    }

}

?>