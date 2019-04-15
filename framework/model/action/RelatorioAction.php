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

    public function collectionUsuario($fieldsToSelect = "*", $conditions = NULL, $order = NULL, $limit = FALSE) {
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

}

?>