<?php
require dirname(__FILE__) . '/../doctrine/Entities/ConteudoFormulario.php';
class ConteudoFormularioActionParent {

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
		$aFieldsStructure = ConteudoFormularioAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Conteudo") == '') {
            throw new Exception("Por favor, informe o campo Conteudo!");
        }


if(isset($aFieldsStructure["Conteudo"]) && !isset($aFieldsStructure["Conteudo"]["isFk"]) && $aFieldsStructure["Conteudo"]["length"]){
    if (strlen($request->get("Conteudo")) > $aFieldsStructure["Conteudo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Conteudo corretamente, o tamanho do campo é {$aFieldsStructure["Conteudo"]["length"]}!");
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
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oConteudoFormulario = new ConteudoFormulario();
        $oConteudoFormulario->setConteudo(QueryHelper::verifyObject($Conteudo, 'Conteudo', $this->em));
	$oConteudoFormulario->setTipo($tipo);
	$oConteudoFormulario->setEnunciado($enunciado);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oConteudoFormulario);
            $this->em->flush($oConteudoFormulario);
            $this->addTransaction($oConteudoFormulario, $request);
            
			
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
            return $oConteudoFormulario;
        }
        return true;
    }

    protected function addTransaction($oConteudoFormulario, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oConteudoFormulario = $this->em->find('ConteudoFormulario',array('id' => $id));
        $oConteudoFormulario->setConteudo(QueryHelper::verifyObject($Conteudo, 'Conteudo', $this->em));
	$oConteudoFormulario->setTipo($tipo);
	$oConteudoFormulario->setEnunciado($enunciado);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oConteudoFormulario);
            $this->em->flush($oConteudoFormulario);
            $this->editTransaction($oConteudoFormulario, $request);
            
			
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
            return $oConteudoFormulario;
        }
        return true;
    }

    protected function editTransaction($oConteudoFormulario, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('ConteudoFormulario', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ConteudoFormularioAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Conteudo') {
                    $query->leftJoin('o.Conteudo', 'u');
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
            ->from('ConteudoFormulario', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ConteudoFormularioAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Conteudo') {
                    $query->leftJoin('o.Conteudo', 'u');
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
            ->from('ConteudoFormulario', 'o');
        
        
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
            ->from('ConteudoFormulario', 'o')
            ->where( $where );
        
        $oConteudoFormulario = $query->getQuery()->getOneOrNullResult();
        return $oConteudoFormulario;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('ConteudoFormulario', 'o')
            ->where( $where );
        $oConteudoFormulario = $query->getQuery()->getOneOrNullResult();
        return $oConteudoFormulario;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("ConteudoFormulario o")
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
        $query = $qb->delete()->from("ConteudoFormulario", "o")
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
        return 'Conteudo Formulario';
    }

    public static function getTableName(){
        return 'conteudo_formulario';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'ConteudoFormulario';
    }
    
    public static function getBaseUrl() {
        return URL . ConteudoFormularioAction::getModuleName(). "/ConteudoFormulario/";
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
        $aValidateFields = array('id_conteudo' => 'Conteudo', 'tipo' => 'tipo');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new ConteudoFormulario();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setConteudo((isset($v['Conteudo']) ? $this->em->find("Conteudo",array( 'id' => $v['Conteudo'])) : NULL));
        $o->setTipo((isset($v['tipo']) ? $v['tipo'] : NULL));
        $o->setEnunciado((isset($v['enunciado']) ? $v['enunciado'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Conteudo'] = (($o->getConteudo()) ? ConteudoAction::toArray($o->getConteudo()) : NULL);
        $v['tipo'] = $o->getTipo();
        $v['enunciado'] = $o->getEnunciado();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['Conteudo'] = "id_conteudo";
	$conditions = preg_replace('~^Conteudo$~',"id_conteudo",$conditions);
	$aFields['tipo'] = "tipo";
	$conditions = preg_replace('~^tipo$~',"tipo",$conditions);
	$aFields['enunciado'] = "enunciado";
	$conditions = preg_replace('~^enunciado$~',"enunciado",$conditions);
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
            $aRet["F"][] = ConteudoFormularioAction::transformaColunas($attr);
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
	$aFields['Conteudo'] = array("suggest","id");
	$aFields['tipo'] = "sim/nao";
	$aFields['enunciado'] = "str";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForTipo($v) {
        switch($v){
	case 'NOT': 
		$value = ' ';
	break;
	case 'TXT': 
		$value = 'Caixa de texto';
	break;
	case 'MEI': 
		$value = 'Múltipla escolha(Individual)';
	break;
	case 'MEV': 
		$value = 'Múltipla escolha(Vários)';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForTipo() {
        return array('NOT' => ' ', 'TXT' => 'Caixa de texto', 'MEI' => 'Múltipla escolha(Individual)', 'MEV' => 'Múltipla escolha(Vários)');
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
        
        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new ConteudoFormularioAction();
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
        $aFields = ConteudoFormularioAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>