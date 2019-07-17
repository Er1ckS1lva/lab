<?php
require dirname(__FILE__) . '/../doctrine/Entities/Log.php';
class LogActionParent {

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
    
    public function validateParent(&$request,$edicao = false){
		$aFieldsStructure = LogAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Usuario") == '') {
            throw new Exception("Por favor, informe o campo Usuário!");
        }


if(isset($aFieldsStructure["Usuario"]) && !isset($aFieldsStructure["Usuario"]["isFk"]) && $aFieldsStructure["Usuario"]["length"]){
    if (strlen($request->get("Usuario")) > $aFieldsStructure["Usuario"]["length"]) {
        $this->setMsg("Por favor, informe o campo Usuário corretamente, o tamanho do campo é {$aFieldsStructure["Usuario"]["length"]}!");
        return false;
    }
}
	if ($request->get("login") == '') {
            throw new Exception("Por favor, informe o campo Login!");
        }


if(isset($aFieldsStructure["login"]) && !isset($aFieldsStructure["login"]["isFk"]) && $aFieldsStructure["login"]["length"]){
    if (strlen($request->get("login")) > $aFieldsStructure["login"]["length"]) {
        $this->setMsg("Por favor, informe o campo Login corretamente, o tamanho do campo é {$aFieldsStructure["login"]["length"]}!");
        return false;
    }
}
	if ($request->get("dataHora") == '') {
            throw new Exception("Por favor, informe o campo Data e hora!");
        }


if(isset($aFieldsStructure["dataHora"]) && !isset($aFieldsStructure["dataHora"]["isFk"]) && $aFieldsStructure["dataHora"]["length"]){
    if (strlen($request->get("dataHora")) > $aFieldsStructure["dataHora"]["length"]) {
        $this->setMsg("Por favor, informe o campo Data e hora corretamente, o tamanho do campo é {$aFieldsStructure["dataHora"]["length"]}!");
        return false;
    }
}
	if ($request->get("acao") == '') {
            throw new Exception("Por favor, informe o campo Ação!");
        }


if(isset($aFieldsStructure["acao"]) && !isset($aFieldsStructure["acao"]["isFk"]) && $aFieldsStructure["acao"]["length"]){
    if (strlen($request->get("acao")) > $aFieldsStructure["acao"]["length"]) {
        $this->setMsg("Por favor, informe o campo Ação corretamente, o tamanho do campo é {$aFieldsStructure["acao"]["length"]}!");
        return false;
    }
}
	if ($request->get("operacao") == '') {
            throw new Exception("Por favor, informe o campo Operação!");
        }


if(isset($aFieldsStructure["operacao"]) && !isset($aFieldsStructure["operacao"]["isFk"]) && $aFieldsStructure["operacao"]["length"]){
    if (strlen($request->get("operacao")) > $aFieldsStructure["operacao"]["length"]) {
        $this->setMsg("Por favor, informe o campo Operação corretamente, o tamanho do campo é {$aFieldsStructure["operacao"]["length"]}!");
        return false;
    }
}
	if ($request->get("descricao") == '') {
            throw new Exception("Por favor, informe o campo Descrição!");
        }


if(isset($aFieldsStructure["descricao"]) && !isset($aFieldsStructure["descricao"]["isFk"]) && $aFieldsStructure["descricao"]["length"]){
    if (strlen($request->get("descricao")) > $aFieldsStructure["descricao"]["length"]) {
        $this->setMsg("Por favor, informe o campo Descrição corretamente, o tamanho do campo é {$aFieldsStructure["descricao"]["length"]}!");
        return false;
    }
}
	if ($request->get("ip") == '') {
            throw new Exception("Por favor, informe o campo IP!");
        }


if(isset($aFieldsStructure["ip"]) && !isset($aFieldsStructure["ip"]["isFk"]) && $aFieldsStructure["ip"]["length"]){
    if (strlen($request->get("ip")) > $aFieldsStructure["ip"]["length"]) {
        $this->setMsg("Por favor, informe o campo IP corretamente, o tamanho do campo é {$aFieldsStructure["ip"]["length"]}!");
        return false;
    }
}
	if ($request->get("nomeHost") == '') {
            throw new Exception("Por favor, informe o campo HOSTNAME!");
        }


if(isset($aFieldsStructure["nomeHost"]) && !isset($aFieldsStructure["nomeHost"]["isFk"]) && $aFieldsStructure["nomeHost"]["length"]){
    if (strlen($request->get("nomeHost")) > $aFieldsStructure["nomeHost"]["length"]) {
        $this->setMsg("Por favor, informe o campo HOSTNAME corretamente, o tamanho do campo é {$aFieldsStructure["nomeHost"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oLog = new Log();
        $oLog->setUsuario(QueryHelper::verifyObject($Usuario, 'Usuario', $this->em));
	$oLog->setLogin($login);
	$oLog->setDataHora(isset($dataHora) ? new DateTime($dataHora) : NULL);
	$oLog->setAcao($acao);
	$oLog->setOperacao($operacao);
	$oLog->setDescricao($descricao);
	$oLog->setIp($ip);
	$oLog->setNomeHost($nomeHost);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oLog);
            $this->em->flush($oLog);
            $this->addTransaction($oLog, $request);
            
			
			if($doLog){
				
			}
			
            if ($commitable) {
                $this->em->commit();
            }
        } catch(Exception $e) {
            
            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        if($returnObject === true){
            return $oLog;
        }
        return true;
    }

    protected function addTransaction($oLog, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oLog = $this->em->find('Log',array('id' => $id));
        $oLog->setUsuario(QueryHelper::verifyObject($Usuario, 'Usuario', $this->em));
	$oLog->setLogin($login);
	$oLog->setDataHora(isset($dataHora) ? new DateTime($dataHora) : NULL);
	$oLog->setAcao($acao);
	$oLog->setOperacao($operacao);
	$oLog->setDescricao($descricao);
	$oLog->setIp($ip);
	$oLog->setNomeHost($nomeHost);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oLog);
            $this->em->flush($oLog);
            $this->editTransaction($oLog, $request);
            
			
			if($doLog){
				
			}
			
            if ($commitable) {
                $this->em->commit();
            }
        } catch(Exception $e) {
            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        if($returnObject === true){
            return $oLog;
        }
        return true;
    }

    protected function editTransaction($oLog, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Log', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(LogAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Usuario') {
                    $query->leftJoin('o.Usuario', 'u');
                    $entityPrefix = "u";
                    $order = 'nome';
                }
                $query->addOrderBy("{$entityPrefix}.{$order}",$orderType);
            }
        }
        $aObject = $query->getQuery()->setFirstResult($page)->setMaxResults($resultsPerPage)->execute();
        if ($fieldsToSelect !== "o") {
            $query->select("o");
        }
        $paginator = new Doctrine\ORM\Tools\Pagination\Paginator($query->getQuery()->setFirstResult($page)->setMaxResults($resultsPerPage), true);
        return $aObject;
    }

    public function collection($fieldsToSelect = null, $conditions = NULL, $order = NULL, $limit = NULL, $distinct = FALSE) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Log', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(LogAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Usuario') {
                    $query->leftJoin('o.Usuario', 'u');
                    $entityPrefix = "u";
                    $order = 'nome';
                }
                $query->addOrderBy("{$entityPrefix}.{$order}",$orderType);
            }
        }
        if($limit !== NULL) {
            $query->setMaxResults($limit);
        }
        $itens = $query->getQuery()->getResult();
        if (count($itens) == 0) {
            return false;
        }
        return $itens;
    }

    public function totalRegistros($conditions = NULL) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select('count(o)')
            ->from('Log', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($id, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('Log', 'o')
            ->where( $where );
        
        $oLog = $query->getQuery()->getOneOrNullResult();
        return $oLog;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Log', 'o')
            ->where( $where );
        $oLog = $query->getQuery()->getOneOrNullResult();
        return $oLog;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Log o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id);
            $query->execute();
			
			if($doLog){
				
			}
			
            if ($commitable) {
                $this->em->commit();
            }
        } catch (Exception $e) {
            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        return true;
    }

    public function delPhysical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->delete()->from("Log", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id);
            $query->execute();
			
			if($doLog){
				
			}

            
            
            if ($commitable) {
                $this->em->commit();
            }
        } catch (Exception $e) {
            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        return true;
    }

    protected function delTransaction($id){
    }

    public function delLogicalSelected($ids) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        try {
            $this->em->beginTransaction();
            foreach($ids as $id){
                $this->delLogical($id, false);
            }
            foreach($ids as $id){
                # apaga os arquivos
                
            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public function delPhysicalSelected($ids) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        try {
            $this->em->beginTransaction();
            foreach($ids as $id){
                $this->delPhysical($id, false);
            }
            foreach($ids as $id){
                # apaga os arquivos
                
            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public static function getEntityName(){
        return 'Log';
    }

    public static function getTableName(){
        return 'log_admin';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'Log';
    }
    
    public static function getBaseUrl() {
        return URL . LogAction::getModuleName(). "/Log/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return $o->getUsuario();
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('id_usuario' => 'Usuario', 'login' => 'login', 'data_hora' => 'dataHora', 'acao' => 'acao', 'tipo_operacao' => 'operacao', 'descricao' => 'descricao', 'ip' => 'ip', 'nome_host' => 'nomeHost');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Log();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setUsuario((isset($v['Usuario']) ? $this->em->find("Usuario",array( 'id' => $v['Usuario'])) : NULL));
        $o->setLogin((isset($v['login']) ? $v['login'] : NULL));
        $o->setDataHora((isset($v['dataHora']) ? $v['dataHora'] : NULL));
        $o->setAcao((isset($v['acao']) ? $v['acao'] : NULL));
        $o->setOperacao((isset($v['operacao']) ? $v['operacao'] : NULL));
        $o->setDescricao((isset($v['descricao']) ? $v['descricao'] : NULL));
        $o->setIp((isset($v['ip']) ? $v['ip'] : NULL));
        $o->setNomeHost((isset($v['nomeHost']) ? $v['nomeHost'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Usuario'] = (($o->getUsuario()) ? UsuarioAction::toArray($o->getUsuario()) : NULL);
        $v['login'] = $o->getLogin();
        $v['dataHora'] = $o->getDataHora();
        $v['acao'] = $o->getAcao();
        $v['operacao'] = $o->getOperacao();
        $v['descricao'] = $o->getDescricao();
        $v['ip'] = $o->getIp();
        $v['nomeHost'] = $o->getNomeHost();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['Usuario'] = "id_usuario";
	$conditions = preg_replace('~^Usuario$~',"id_usuario",$conditions);
	$aFields['login'] = "login";
	$conditions = preg_replace('~^login$~',"login",$conditions);
	$aFields['dataHora'] = "data_hora";
	$conditions = preg_replace('~^dataHora$~',"data_hora",$conditions);
	$aFields['acao'] = "acao";
	$conditions = preg_replace('~^acao$~',"acao",$conditions);
	$aFields['operacao'] = "tipo_operacao";
	$conditions = preg_replace('~^operacao$~',"tipo_operacao",$conditions);
	$aFields['descricao'] = "descricao";
	$conditions = preg_replace('~^descricao$~',"descricao",$conditions);
	$aFields['ip'] = "ip";
	$conditions = preg_replace('~^ip$~',"ip",$conditions);
	$aFields['nomeHost'] = "nome_host";
	$conditions = preg_replace('~^nomeHost$~',"nome_host",$conditions);
        if(!$conditions){
            return $aFields;
        }
        return $conditions;
    }
	
	public static function getKeys($tipo = null) {
        # F- FieldName || A- AttributeName
        @$aKeys = array('o.id' => $id); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = LogAction::transformaColunas($attr);
        }
        if ($tipo == "F") {
            return implode(", ", $aRet["F"]);
        } else if ($tipo == "A") {
            return implode(", ", $aRet["A"]);
        }
        return $aRet;
    }
	
	public static function getFieldsTypeGenial($field = null) {
        # mostra o atributo que foi utilizado dos types do genial
		$aFields = array();
        	$aFields['id'] = "autoinc";
	$aFields['Usuario'] = array("obj","nome");
	$aFields['login'] = "str";
	$aFields['dataHora'] = "datetime";
	$aFields['acao'] = "str";
	$aFields['operacao'] = "sim/nao";
	$aFields['descricao'] = "memo";
	$aFields['ip'] = "str";
	$aFields['nomeHost'] = "str";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForOperacao($v) {
        switch($v){
	case 'O': 
		$value = 'Operação de banco';
	break;
	case 'A': 
		$value = 'Acesso ao sistema';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForOperacao() {
        return array('O' => 'Operação de banco', 'A' => 'Acesso ao sistema');
    }

    public static function getComboBoxForOperacao($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'operacao') {
        $valores = self::getValuesForOperacao();
        $select = '<select ' . $events . ' id="'.$name.'" name="'.$name.'" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if($emptyDefaultText){
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach($valores as $key => $value){
            $selected = '';
            if( ($v) == ($key) ) $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getRadioButtonForOperacao($v = NULL, $tabindex = "", $event = "", $name = 'operacao') {
        $valores = self::getValuesForOperacao();
        $radio = "";
        foreach($valores as $key => $value){
            $checked = '';
            if( ($v) == ($key) ) $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='".$name."' name='".$name."' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }


    public function validateDel($id, $isSingleDel = true){
		#$ids = is_array($id) ? $id : array($id);
        #foreach ($ids as $id_del) {
	
        if($isSingleDel){
            return true;
        }else{
            return true;
        }
    }
    
    public function filterConditions(&$request, &$response, &$orderPageConditions, $alias = "o", $conditions = array()){
        
        if($request->get('Usuario')) {
            $conditions[] = "{$alias}.Usuario = " . $request->get('Usuario')  . "";
            $orderPageConditions .= "&Usuario={$request->get('Usuario')}";
            $response->set('Usuario',  $request->get("Usuario"));
        }
        if($request->get('UsuarioSuggest')) {
            $conditions[] = $response->get('UsuarioSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&UsuarioSuggest={$request->get('UsuarioSuggest')}";
            $response->set('UsuarioSuggest',  $request->get("UsuarioSuggest"));
        }
        if($request->get('login')) {
            $conditions[] = "{$alias}.login LIKE '%" . ($request->get('login') ) . "%'";
            $orderPageConditions .= "&login={$request->get('login')}";
            $response->set('login',  $request->get("login"));
        }
        if($request->get('operacao')) {
            $conditions[] = "{$alias}.operacao = '" . $request->get('operacao')  . "'";
            $orderPageConditions .= "&operacao={$request->get('operacao')}";
            $response->set('operacao',  $request->get("operacao"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new LogAction();
        $entityManager = $oAction->getConnection();
        $aFields = QueryHelper::getFieldsForClass($oAction->getClassName(),$entityManager);
        if ($field) {
            if (isset($aFields[$field]))
                return $aFields[$field];
            else
                return NAO_DEFINIDO;
        }
        return $aFields;
    }
	
	public static function maxlengthFields() {
        $aFields = LogAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>