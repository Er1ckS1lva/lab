<?php
require dirname(__FILE__) . '/../doctrine/Entities/FormularioOpcao.php';
class FormularioOpcaoActionParent {

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
		$aFieldsStructure = FormularioOpcaoAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("ConteudoFormulario") == '') {
            throw new Exception("Por favor, informe o campo ConteudoFormulario!");
        }


if(isset($aFieldsStructure["ConteudoFormulario"]) && !isset($aFieldsStructure["ConteudoFormulario"]["isFk"]) && $aFieldsStructure["ConteudoFormulario"]["length"]){
    if (strlen($request->get("ConteudoFormulario")) > $aFieldsStructure["ConteudoFormulario"]["length"]) {
        $this->setMsg("Por favor, informe o campo ConteudoFormulario corretamente, o tamanho do campo é {$aFieldsStructure["ConteudoFormulario"]["length"]}!");
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
        
        $oFormularioOpcao = new FormularioOpcao();
        $oFormularioOpcao->setConteudoFormulario(QueryHelper::verifyObject($ConteudoFormulario, 'ConteudoFormulario', $this->em));
	$oFormularioOpcao->setValor($valor);
	$oFormularioOpcao->setCorreta($correta);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oFormularioOpcao);
            $this->em->flush($oFormularioOpcao);
            $this->addTransaction($oFormularioOpcao, $request);
            
			
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
            return $oFormularioOpcao;
        }
        return true;
    }

    protected function addTransaction($oFormularioOpcao, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oFormularioOpcao = $this->em->find('FormularioOpcao',array('id' => $id));
        $oFormularioOpcao->setConteudoFormulario(QueryHelper::verifyObject($ConteudoFormulario, 'ConteudoFormulario', $this->em));
	$oFormularioOpcao->setValor($valor);
	$oFormularioOpcao->setCorreta($correta);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oFormularioOpcao);
            $this->em->flush($oFormularioOpcao);
            $this->editTransaction($oFormularioOpcao, $request);
            
			
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
            return $oFormularioOpcao;
        }
        return true;
    }

    protected function editTransaction($oFormularioOpcao, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('FormularioOpcao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(FormularioOpcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'ConteudoFormulario') {
                    $query->leftJoin('o.ConteudoFormulario', 'u');
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
            ->from('FormularioOpcao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(FormularioOpcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'ConteudoFormulario') {
                    $query->leftJoin('o.ConteudoFormulario', 'u');
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
            ->from('FormularioOpcao', 'o');
        
        
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
            ->from('FormularioOpcao', 'o')
            ->where( $where );
        
        $oFormularioOpcao = $query->getQuery()->getOneOrNullResult();
        return $oFormularioOpcao;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('FormularioOpcao', 'o')
            ->where( $where );
        $oFormularioOpcao = $query->getQuery()->getOneOrNullResult();
        return $oFormularioOpcao;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("FormularioOpcao o")
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
        $query = $qb->delete()->from("FormularioOpcao", "o")
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
        return 'Formulario Opcao';
    }

    public static function getTableName(){
        return 'formulario_opcao';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'FormularioOpcao';
    }
    
    public static function getBaseUrl() {
        return URL . FormularioOpcaoAction::getModuleName(). "/FormularioOpcao/";
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
        $aValidateFields = array('id_conteudo_formulario' => 'ConteudoFormulario', 'correta' => 'correta');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new FormularioOpcao();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setConteudoFormulario((isset($v['ConteudoFormulario']) ? $this->em->find("ConteudoFormulario",array( 'id' => $v['ConteudoFormulario'])) : NULL));
        $o->setValor((isset($v['valor']) ? $v['valor'] : NULL));
        $o->setCorreta((isset($v['correta']) ? $v['correta'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['ConteudoFormulario'] = (($o->getConteudoFormulario()) ? ConteudoFormularioAction::toArray($o->getConteudoFormulario()) : NULL);
        $v['valor'] = $o->getValor();
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
	$aFields['ConteudoFormulario'] = "id_conteudo_formulario";
	$conditions = preg_replace('~^ConteudoFormulario$~',"id_conteudo_formulario",$conditions);
	$aFields['valor'] = "valor";
	$conditions = preg_replace('~^valor$~',"valor",$conditions);
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
            $aRet["F"][] = FormularioOpcaoAction::transformaColunas($attr);
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
	$aFields['ConteudoFormulario'] = array("suggest","id");
	$aFields['valor'] = "str";
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
        
        if($request->get('ConteudoFormulario')) {
            $conditions[] = "{$alias}.ConteudoFormulario = " . $request->get('ConteudoFormulario')  . "";
            $orderPageConditions .= "&ConteudoFormulario={$request->get('ConteudoFormulario')}";
            $response->set('ConteudoFormulario',  $request->get("ConteudoFormulario"));
        }
        if($request->get('ConteudoFormularioSuggest')) {
            $conditions[] = $response->get('ConteudoFormularioSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&ConteudoFormularioSuggest={$request->get('ConteudoFormularioSuggest')}";
            $response->set('ConteudoFormularioSuggest',  $request->get("ConteudoFormularioSuggest"));
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
        $oAction = new FormularioOpcaoAction();
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
        $aFields = FormularioOpcaoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>