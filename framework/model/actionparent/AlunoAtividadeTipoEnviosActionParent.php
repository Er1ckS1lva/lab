<?php
require dirname(__FILE__) . '/../doctrine/Entities/AlunoAtividadeTipoEnvios.php';
class AlunoAtividadeTipoEnviosActionParent {

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
		$aFieldsStructure = AlunoAtividadeTipoEnviosAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("aluno_id") == '') {
            throw new Exception("Por favor, informe o campo Aluno !");
        }


if(isset($aFieldsStructure["aluno_id"]) && !isset($aFieldsStructure["aluno_id"]["isFk"]) && $aFieldsStructure["aluno_id"]["length"]){
    if (strlen($request->get("aluno_id")) > $aFieldsStructure["aluno_id"]["length"]) {
        $this->setMsg("Por favor, informe o campo Aluno  corretamente, o tamanho do campo é {$aFieldsStructure["aluno_id"]["length"]}!");
        return false;
    }
}
	if ($request->get("adeId") == '') {
            throw new Exception("Por favor, informe o campo Atividade !");
        }


if(isset($aFieldsStructure["adeId"]) && !isset($aFieldsStructure["adeId"]["isFk"]) && $aFieldsStructure["adeId"]["length"]){
    if (strlen($request->get("adeId")) > $aFieldsStructure["adeId"]["length"]) {
        $this->setMsg("Por favor, informe o campo Atividade  corretamente, o tamanho do campo é {$aFieldsStructure["adeId"]["length"]}!");
        return false;
    }
}
	if ($request->get("tipo") == '') {
            throw new Exception("Por favor, informe o campo Tipo!");
        }


if(isset($aFieldsStructure["tipo"]) && !isset($aFieldsStructure["tipo"]["isFk"]) && $aFieldsStructure["tipo"]["length"]){
    if (strlen($request->get("tipo")) > $aFieldsStructure["tipo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Tipo corretamente, o tamanho do campo é {$aFieldsStructure["tipo"]["length"]}!");
        return false;
    }
}
	if ($request->get("valor") == '') {
            throw new Exception("Por favor, informe o campo Valor!");
        }


if(isset($aFieldsStructure["valor"]) && !isset($aFieldsStructure["valor"]["isFk"]) && $aFieldsStructure["valor"]["length"]){
    if (strlen($request->get("valor")) > $aFieldsStructure["valor"]["length"]) {
        $this->setMsg("Por favor, informe o campo Valor corretamente, o tamanho do campo é {$aFieldsStructure["valor"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoAtividadeTipoEnvios = new AlunoAtividadeTipoEnvios();
        $oAlunoAtividadeTipoEnvios->setAluno_id(QueryHelper::verifyObject($aluno_id, 'Aluno', $this->em));
	$oAlunoAtividadeTipoEnvios->setAdeId(QueryHelper::verifyObject($adeId, 'Atividade', $this->em));
	$oAlunoAtividadeTipoEnvios->setTipo($tipo);
	$oAlunoAtividadeTipoEnvios->setValor($valor);
	$oAlunoAtividadeTipoEnvios->setLogData(isset($logData) ? new DateTime($logData) : NULL);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoAtividadeTipoEnvios);
            $this->em->flush($oAlunoAtividadeTipoEnvios);
            $this->addTransaction($oAlunoAtividadeTipoEnvios, $request);
            
			
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
            return $oAlunoAtividadeTipoEnvios;
        }
        return true;
    }

    protected function addTransaction($oAlunoAtividadeTipoEnvios, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoAtividadeTipoEnvios = $this->em->find('AlunoAtividadeTipoEnvios',array('id' => $id));
        $oAlunoAtividadeTipoEnvios->setAluno_id(QueryHelper::verifyObject($aluno_id, 'Aluno', $this->em));
	$oAlunoAtividadeTipoEnvios->setAdeId(QueryHelper::verifyObject($adeId, 'Atividade', $this->em));
	$oAlunoAtividadeTipoEnvios->setTipo($tipo);
	$oAlunoAtividadeTipoEnvios->setValor($valor);
	$oAlunoAtividadeTipoEnvios->setLogData(isset($logData) ? new DateTime($logData) : NULL);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoAtividadeTipoEnvios);
            $this->em->flush($oAlunoAtividadeTipoEnvios);
            $this->editTransaction($oAlunoAtividadeTipoEnvios, $request);
            
			
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
            return $oAlunoAtividadeTipoEnvios;
        }
        return true;
    }

    protected function editTransaction($oAlunoAtividadeTipoEnvios, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AlunoAtividadeTipoEnvios', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoAtividadeTipoEnviosAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'aluno_id') {
                    $query->leftJoin('o.aluno_id', 'u');
                    $entityPrefix = "u";
                    $order = 'id';
                }if($order == 'adeId') {
                    $query->leftJoin('o.adeId', 'u');
                    $entityPrefix = "u";
                    $order = 'id';
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
            ->from('AlunoAtividadeTipoEnvios', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoAtividadeTipoEnviosAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'aluno_id') {
                    $query->leftJoin('o.aluno_id', 'u');
                    $entityPrefix = "u";
                    $order = 'id';
                }if($order == 'adeId') {
                    $query->leftJoin('o.adeId', 'u');
                    $entityPrefix = "u";
                    $order = 'id';
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
            ->from('AlunoAtividadeTipoEnvios', 'o');
        
        
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
            ->from('AlunoAtividadeTipoEnvios', 'o')
            ->where( $where );
        
        $oAlunoAtividadeTipoEnvios = $query->getQuery()->getOneOrNullResult();
        return $oAlunoAtividadeTipoEnvios;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('AlunoAtividadeTipoEnvios', 'o')
            ->where( $where );
        $oAlunoAtividadeTipoEnvios = $query->getQuery()->getOneOrNullResult();
        return $oAlunoAtividadeTipoEnvios;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("AlunoAtividadeTipoEnvios o")
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
        $query = $qb->delete()->from("AlunoAtividadeTipoEnvios", "o")
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
        return 'Aluno Atividade Tipo Envios';
    }

    public static function getTableName(){
        return 'aluno_atividade_tipo_envios';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'AlunoAtividadeTipoEnvios';
    }
    
    public static function getBaseUrl() {
        return URL . AlunoAtividadeTipoEnviosAction::getModuleName(). "/AlunoAtividadeTipoEnvios/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return NULL;
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('aluno_id' => 'aluno_id', 'atividade_id' => 'adeId', 'tipo' => 'tipo', 'valor' => 'valor');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AlunoAtividadeTipoEnvios();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setAluno_id((isset($v['aluno_id']) ? $this->em->find("aluno_id",array( 'id' => $v['aluno_id'])) : NULL));
        $o->setAdeId((isset($v['adeId']) ? $this->em->find("adeId",array( 'id' => $v['adeId'])) : NULL));
        $o->setTipo((isset($v['tipo']) ? $v['tipo'] : NULL));
        $o->setValor((isset($v['valor']) ? $v['valor'] : NULL));
        $o->setLogData((isset($v['logData']) ? $v['logData'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['aluno_id'] = (($o->getAluno_id()) ? AlunoAction::toArray($o->getAluno_id()) : NULL);
        $v['adeId'] = (($o->getAdeId()) ? AtividadeAction::toArray($o->getAdeId()) : NULL);
        $v['tipo'] = $o->getTipo();
        $v['valor'] = $o->getValor();
        $v['logData'] = $o->getLogData();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['aluno_id'] = "aluno_id";
	$conditions = preg_replace('~^aluno_id$~',"aluno_id",$conditions);
	$aFields['adeId'] = "atividade_id";
	$conditions = preg_replace('~^adeId$~',"atividade_id",$conditions);
	$aFields['tipo'] = "tipo";
	$conditions = preg_replace('~^tipo$~',"tipo",$conditions);
	$aFields['valor'] = "valor";
	$conditions = preg_replace('~^valor$~',"valor",$conditions);
	$aFields['logData'] = "log_data";
	$conditions = preg_replace('~^logData$~',"log_data",$conditions);
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
            $aRet["F"][] = AlunoAtividadeTipoEnviosAction::transformaColunas($attr);
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
	$aFields['aluno_id'] = array("suggest","id");
	$aFields['adeId'] = array("suggest","id");
	$aFields['tipo'] = "sim/nao";
	$aFields['valor'] = "memo";
	$aFields['logData'] = "datetime";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForTipo($v) {
        switch($v){
	case 'EXISTE_VALUES_TABELA': 
		$value = '';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForTipo() {
        return array('EXISTE_VALUES_TABELA' => '');
    }

    public static function getComboBoxForTipo($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'tipo') {
        $valores = self::getValuesForTipo();
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

    public static function getRadioButtonForTipo($v = NULL, $tabindex = "", $event = "", $name = 'tipo') {
        $valores = self::getValuesForTipo();
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
        
        if($request->get('aluno_id')) {
            $conditions[] = "{$alias}.aluno_id = " . $request->get('aluno_id')  . "";
            $orderPageConditions .= "&aluno_id={$request->get('aluno_id')}";
            $response->set('aluno_id',  $request->get("aluno_id"));
        }
        if($request->get('aluno_idSuggest')) {
            $conditions[] = $response->get('aluno_idSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&aluno_idSuggest={$request->get('aluno_idSuggest')}";
            $response->set('aluno_idSuggest',  $request->get("aluno_idSuggest"));
        }
        if($request->get('adeId')) {
            $conditions[] = "{$alias}.adeId = " . $request->get('adeId')  . "";
            $orderPageConditions .= "&adeId={$request->get('adeId')}";
            $response->set('adeId',  $request->get("adeId"));
        }
        if($request->get('adeIdSuggest')) {
            $conditions[] = $response->get('adeIdSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&adeIdSuggest={$request->get('adeIdSuggest')}";
            $response->set('adeIdSuggest',  $request->get("adeIdSuggest"));
        }
        if($request->get('tipo')) {
            $conditions[] = "{$alias}.tipo = '" . $request->get('tipo')  . "'";
            $orderPageConditions .= "&tipo={$request->get('tipo')}";
            $response->set('tipo',  $request->get("tipo"));
        }
        if($request->get('valor')) {
            $conditions[] = "{$alias}.valor LIKE '%" . ($request->get('valor') ) . "%'";
            $orderPageConditions .= "&valor={$request->get('valor')}";
            $response->set('valor',  $request->get("valor"));
        }
        if($request->get('logData')) {
            $conditions[] = "{$alias}.logData = '" . $request->get('logData')  . "'";
            $orderPageConditions .= "&logData={$request->get('logData')}";
            $response->set('logData',  $request->get("logData"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AlunoAtividadeTipoEnviosAction();
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
        $aFields = AlunoAtividadeTipoEnviosAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>