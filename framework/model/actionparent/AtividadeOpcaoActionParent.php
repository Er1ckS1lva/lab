<?php
require dirname(__FILE__) . '/../doctrine/Entities/AtividadeOpcao.php';
class AtividadeOpcaoActionParent {

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
		$aFieldsStructure = AtividadeOpcaoAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Atividade") == '') {
            throw new Exception("Por favor, informe o campo Atividade!");
        }


if(isset($aFieldsStructure["Atividade"]) && !isset($aFieldsStructure["Atividade"]["isFk"]) && $aFieldsStructure["Atividade"]["length"]){
    if (strlen($request->get("Atividade")) > $aFieldsStructure["Atividade"]["length"]) {
        $this->setMsg("Por favor, informe o campo Atividade corretamente, o tamanho do campo é {$aFieldsStructure["Atividade"]["length"]}!");
        return false;
    }
}
	if ($request->get("correta") == '') {
            throw new Exception("Por favor, informe o campo Correta!");
        }


if(isset($aFieldsStructure["correta"]) && !isset($aFieldsStructure["correta"]["isFk"]) && $aFieldsStructure["correta"]["length"]){
    if (strlen($request->get("correta")) > $aFieldsStructure["correta"]["length"]) {
        $this->setMsg("Por favor, informe o campo Correta corretamente, o tamanho do campo é {$aFieldsStructure["correta"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividadeOpcao = new AtividadeOpcao();
        $oAtividadeOpcao->setValor($valor);
	$oAtividadeOpcao->setValorFonetico($valorFonetico);
	$oAtividadeOpcao->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	$oAtividadeOpcao->setCorreta($correta);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeOpcao);
            $this->em->flush($oAtividadeOpcao);
            $this->addTransaction($oAtividadeOpcao, $request);
            
			
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
            return $oAtividadeOpcao;
        }
        return true;
    }

    protected function addTransaction($oAtividadeOpcao, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividadeOpcao = $this->em->find('AtividadeOpcao',array('id' => $id));
        $oAtividadeOpcao->setValor($valor);
	$oAtividadeOpcao->setValorFonetico($valorFonetico);
	$oAtividadeOpcao->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	$oAtividadeOpcao->setCorreta($correta);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeOpcao);
            $this->em->flush($oAtividadeOpcao);
            $this->editTransaction($oAtividadeOpcao, $request);
            
			
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
            return $oAtividadeOpcao;
        }
        return true;
    }

    protected function editTransaction($oAtividadeOpcao, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AtividadeOpcao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeOpcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Atividade') {
                    $query->leftJoin('o.Atividade', 'u');
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
            ->from('AtividadeOpcao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeOpcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Atividade') {
                    $query->leftJoin('o.Atividade', 'u');
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
            ->from('AtividadeOpcao', 'o');
        
        
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
            ->from('AtividadeOpcao', 'o')
            ->where( $where );
        
        $oAtividadeOpcao = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeOpcao;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('AtividadeOpcao', 'o')
            ->where( $where );
        $oAtividadeOpcao = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeOpcao;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("AtividadeOpcao o")
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
        $query = $qb->delete()->from("AtividadeOpcao", "o")
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
        return 'Atividade Opcao';
    }

    public static function getTableName(){
        return 'atividade_opcao';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'AtividadeOpcao';
    }
    
    public static function getBaseUrl() {
        return URL . AtividadeOpcaoAction::getModuleName(). "/AtividadeOpcao/";
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
        $aValidateFields = array('id_atividade' => 'Atividade', 'correta' => 'correta');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AtividadeOpcao();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setValor((isset($v['valor']) ? $v['valor'] : NULL));
        $o->setValorFonetico((isset($v['valorFonetico']) ? $v['valorFonetico'] : NULL));
        $o->setAtividade((isset($v['Atividade']) ? $this->em->find("Atividade",array( 'id' => $v['Atividade'])) : NULL));
        $o->setCorreta((isset($v['correta']) ? $v['correta'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['valor'] = $o->getValor();
        $v['valorFonetico'] = $o->getValorFonetico();
        $v['Atividade'] = (($o->getAtividade()) ? AtividadeAction::toArray($o->getAtividade()) : NULL);
        $v['correta'] = $o->getCorreta();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['valor'] = "valor";
	$conditions = preg_replace('~^valor$~',"valor",$conditions);
	$aFields['valorFonetico'] = "valor_fonetico";
	$conditions = preg_replace('~^valorFonetico$~',"valor_fonetico",$conditions);
	$aFields['Atividade'] = "id_atividade";
	$conditions = preg_replace('~^Atividade$~',"id_atividade",$conditions);
	$aFields['correta'] = "correta";
	$conditions = preg_replace('~^correta$~',"correta",$conditions);
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
            $aRet["F"][] = AtividadeOpcaoAction::transformaColunas($attr);
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
	$aFields['valor'] = "str";
	$aFields['valorFonetico'] = "str";
	$aFields['Atividade'] = array("suggest","id");
	$aFields['correta'] = "sim/nao";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForCorreta($v) {
        switch($v){
	case 'S': 
		$value = 'Sim';
	break;
	case 'N': 
		$value = 'Não';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForCorreta() {
        return array('S' => 'Sim', 'N' => 'Não');
    }

    public static function getComboBoxForCorreta($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'correta') {
        $valores = self::getValuesForCorreta();
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

    public static function getRadioButtonForCorreta($v = NULL, $tabindex = "", $event = "", $name = 'correta') {
        $valores = self::getValuesForCorreta();
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
        
        if($request->get('valor')) {
            $conditions[] = "{$alias}.valor LIKE '%" . ($request->get('valor') ) . "%'";
            $orderPageConditions .= "&valor={$request->get('valor')}";
            $response->set('valor',  $request->get("valor"));
        }
        if($request->get('valorFonetico')) {
            $conditions[] = "{$alias}.valorFonetico LIKE '%" . ($request->get('valorFonetico') ) . "%'";
            $orderPageConditions .= "&valorFonetico={$request->get('valorFonetico')}";
            $response->set('valorFonetico',  $request->get("valorFonetico"));
        }
        if($request->get('Atividade')) {
            $conditions[] = "{$alias}.Atividade = " . $request->get('Atividade')  . "";
            $orderPageConditions .= "&Atividade={$request->get('Atividade')}";
            $response->set('Atividade',  $request->get("Atividade"));
        }
        if($request->get('AtividadeSuggest')) {
            $conditions[] = $response->get('AtividadeSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&AtividadeSuggest={$request->get('AtividadeSuggest')}";
            $response->set('AtividadeSuggest',  $request->get("AtividadeSuggest"));
        }
        if($request->get('correta')) {
            $conditions[] = "{$alias}.correta = '" . $request->get('correta')  . "'";
            $orderPageConditions .= "&correta={$request->get('correta')}";
            $response->set('correta',  $request->get("correta"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AtividadeOpcaoAction();
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
        $aFields = AtividadeOpcaoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>