<?php
require dirname(__FILE__) . '/../doctrine/Entities/AlunoAcesso.php';
class AlunoAcessoActionParent {

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
		$aFieldsStructure = AlunoAcessoAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Aluno") == '') {
            throw new Exception("Por favor, informe o campo Aluno!");
        }


if(isset($aFieldsStructure["Aluno"]) && !isset($aFieldsStructure["Aluno"]["isFk"]) && $aFieldsStructure["Aluno"]["length"]){
    if (strlen($request->get("Aluno")) > $aFieldsStructure["Aluno"]["length"]) {
        $this->setMsg("Por favor, informe o campo Aluno corretamente, o tamanho do campo é {$aFieldsStructure["Aluno"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoAcesso = new AlunoAcesso();
        $oAlunoAcesso->setAluno(QueryHelper::verifyObject($Aluno, 'Aluno', $this->em));
	$oAlunoAcesso->setDataRegistro(isset($dataRegistro) ? new DateTime($dataRegistro) : NULL);
	$oAlunoAcesso->setRecurso($recurso);
	$oAlunoAcesso->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoAcesso);
            $this->em->flush($oAlunoAcesso);
            $this->addTransaction($oAlunoAcesso, $request);
            
			
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
            return $oAlunoAcesso;
        }
        return true;
    }

    protected function addTransaction($oAlunoAcesso, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoAcesso = $this->em->find('AlunoAcesso',array('id' => $id));
        $oAlunoAcesso->setAluno(QueryHelper::verifyObject($Aluno, 'Aluno', $this->em));
	$oAlunoAcesso->setDataRegistro(isset($dataRegistro) ? new DateTime($dataRegistro) : NULL);
	$oAlunoAcesso->setRecurso($recurso);
	$oAlunoAcesso->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoAcesso);
            $this->em->flush($oAlunoAcesso);
            $this->editTransaction($oAlunoAcesso, $request);
            
			
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
            return $oAlunoAcesso;
        }
        return true;
    }

    protected function editTransaction($oAlunoAcesso, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AlunoAcesso', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoAcessoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Aluno') {
                    $query->leftJoin('o.Aluno', 'u');
                    $entityPrefix = "u";
                    $order = 'id';
                }if($order == 'Atividade') {
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
            ->from('AlunoAcesso', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoAcessoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Aluno') {
                    $query->leftJoin('o.Aluno', 'u');
                    $entityPrefix = "u";
                    $order = 'id';
                }if($order == 'Atividade') {
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
            ->from('AlunoAcesso', 'o');
        
        
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
            ->from('AlunoAcesso', 'o')
            ->where( $where );
        
        $oAlunoAcesso = $query->getQuery()->getOneOrNullResult();
        return $oAlunoAcesso;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('AlunoAcesso', 'o')
            ->where( $where );
        $oAlunoAcesso = $query->getQuery()->getOneOrNullResult();
        return $oAlunoAcesso;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("AlunoAcesso o")
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
        $query = $qb->delete()->from("AlunoAcesso", "o")
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
        return 'Acesso do Aluno';
    }

    public static function getTableName(){
        return 'aluno_acesso';
    }

    public static function getModuleName() {
        return 'relatorio';
    }
    
    public static function getClassName() {
        return 'AlunoAcesso';
    }
    
    public static function getBaseUrl() {
        return URL . AlunoAcessoAction::getModuleName(). "/AlunoAcesso/";
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
        $aValidateFields = array('id_aluno' => 'Aluno');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AlunoAcesso();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setAluno((isset($v['Aluno']) ? $this->em->find("Aluno",array( 'id' => $v['Aluno'])) : NULL));
        $o->setDataRegistro((isset($v['dataRegistro']) ? $v['dataRegistro'] : NULL));
        $o->setRecurso((isset($v['recurso']) ? $v['recurso'] : NULL));
        $o->setAtividade((isset($v['Atividade']) ? $this->em->find("Atividade",array( 'id' => $v['Atividade'])) : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Aluno'] = (($o->getAluno()) ? AlunoAction::toArray($o->getAluno()) : NULL);
        $v['dataRegistro'] = $o->getDataRegistro();
        $v['recurso'] = $o->getRecurso();
        $v['Atividade'] = (($o->getAtividade()) ? AtividadeAction::toArray($o->getAtividade()) : NULL);
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['Aluno'] = "id_aluno";
	$conditions = preg_replace('~^Aluno$~',"id_aluno",$conditions);
	$aFields['dataRegistro'] = "dt_registro";
	$conditions = preg_replace('~^dataRegistro$~',"dt_registro",$conditions);
	$aFields['recurso'] = "recurso";
	$conditions = preg_replace('~^recurso$~',"recurso",$conditions);
	$aFields['Atividade'] = "id_atividade";
	$conditions = preg_replace('~^Atividade$~',"id_atividade",$conditions);
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
            $aRet["F"][] = AlunoAcessoAction::transformaColunas($attr);
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
	$aFields['Aluno'] = array("suggest","id");
	$aFields['dataRegistro'] = "datetime";
	$aFields['recurso'] = "sim/nao";
	$aFields['Atividade'] = array("obj","id");
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForRecurso($v) {
        switch($v){
	case 'LOG': 
		$value = 'Acesso(login)';
	break;
	case 'ATV': 
		$value = 'Atividade Visualizar';
	break;
	case 'ATE': 
		$value = 'Atividade Executar';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForRecurso() {
        return array('LOG' => 'Acesso(login)', 'ATV' => 'Atividade Visualizar', 'ATE' => 'Atividade Executar');
    }

    public static function getComboBoxForRecurso($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'recurso') {
        $valores = self::getValuesForRecurso();
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

    public static function getRadioButtonForRecurso($v = NULL, $tabindex = "", $event = "", $name = 'recurso') {
        $valores = self::getValuesForRecurso();
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
        $oAction = new AlunoAcessoAction();
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
        $aFields = AlunoAcessoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>