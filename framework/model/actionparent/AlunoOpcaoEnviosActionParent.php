<?php
require dirname(__FILE__) . '/../doctrine/Entities/AlunoOpcaoEnvios.php';
class AlunoOpcaoEnviosActionParent {

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
		$aFieldsStructure = AlunoOpcaoEnviosAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Aluno") == '') {
            throw new Exception("Por favor, informe o campo Aluno!");
        }


if(isset($aFieldsStructure["Aluno"]) && !isset($aFieldsStructure["Aluno"]["isFk"]) && $aFieldsStructure["Aluno"]["length"]){
    if (strlen($request->get("Aluno")) > $aFieldsStructure["Aluno"]["length"]) {
        $this->setMsg("Por favor, informe o campo Aluno corretamente, o tamanho do campo é {$aFieldsStructure["Aluno"]["length"]}!");
        return false;
    }
}
	if ($request->get("ConteudoFormulario") == '') {
            throw new Exception("Por favor, informe o campo Conteudo Formulario!");
        }


if(isset($aFieldsStructure["ConteudoFormulario"]) && !isset($aFieldsStructure["ConteudoFormulario"]["isFk"]) && $aFieldsStructure["ConteudoFormulario"]["length"]){
    if (strlen($request->get("ConteudoFormulario")) > $aFieldsStructure["ConteudoFormulario"]["length"]) {
        $this->setMsg("Por favor, informe o campo Conteudo Formulario corretamente, o tamanho do campo é {$aFieldsStructure["ConteudoFormulario"]["length"]}!");
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
        
        $oAlunoOpcaoEnvios = new AlunoOpcaoEnvios();
        $oAlunoOpcaoEnvios->setAluno(QueryHelper::verifyObject($Aluno, 'Aluno', $this->em));
	$oAlunoOpcaoEnvios->setConteudoFormulario(QueryHelper::verifyObject($ConteudoFormulario, 'ConteudoFormulario', $this->em));
	$oAlunoOpcaoEnvios->setValor($valor);
	$oAlunoOpcaoEnvios->setLogData(isset($logData) ? new DateTime($logData) : NULL);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoOpcaoEnvios);
            $this->em->flush($oAlunoOpcaoEnvios);
            $this->addTransaction($oAlunoOpcaoEnvios, $request);
            
			
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
            return $oAlunoOpcaoEnvios;
        }
        return true;
    }

    protected function addTransaction($oAlunoOpcaoEnvios, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoOpcaoEnvios = $this->em->find('AlunoOpcaoEnvios',array('id' => $id));
        $oAlunoOpcaoEnvios->setAluno(QueryHelper::verifyObject($Aluno, 'Aluno', $this->em));
	$oAlunoOpcaoEnvios->setConteudoFormulario(QueryHelper::verifyObject($ConteudoFormulario, 'ConteudoFormulario', $this->em));
	$oAlunoOpcaoEnvios->setValor($valor);
	$oAlunoOpcaoEnvios->setLogData(isset($logData) ? new DateTime($logData) : NULL);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoOpcaoEnvios);
            $this->em->flush($oAlunoOpcaoEnvios);
            $this->editTransaction($oAlunoOpcaoEnvios, $request);
            
			
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
            return $oAlunoOpcaoEnvios;
        }
        return true;
    }

    protected function editTransaction($oAlunoOpcaoEnvios, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AlunoOpcaoEnvios', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoOpcaoEnviosAction::manualOrder($query, $order) === FALSE){
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
                }if($order == 'ConteudoFormulario') {
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
            ->from('AlunoOpcaoEnvios', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoOpcaoEnviosAction::manualOrder($query, $order) === FALSE){
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
                }if($order == 'ConteudoFormulario') {
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
            ->from('AlunoOpcaoEnvios', 'o');
        
        
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
            ->from('AlunoOpcaoEnvios', 'o')
            ->where( $where );
        
        $oAlunoOpcaoEnvios = $query->getQuery()->getOneOrNullResult();
        return $oAlunoOpcaoEnvios;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('AlunoOpcaoEnvios', 'o')
            ->where( $where );
        $oAlunoOpcaoEnvios = $query->getQuery()->getOneOrNullResult();
        return $oAlunoOpcaoEnvios;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("AlunoOpcaoEnvios o")
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
        $query = $qb->delete()->from("AlunoOpcaoEnvios", "o")
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
        return 'Aluno Opcao Envios';
    }

    public static function getTableName(){
        return 'aluno_opcao_envios';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'AlunoOpcaoEnvios';
    }
    
    public static function getBaseUrl() {
        return URL . AlunoOpcaoEnviosAction::getModuleName(). "/AlunoOpcaoEnvios/";
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
        $aValidateFields = array('id_aluno' => 'Aluno', 'id_conteudo_formulario' => 'ConteudoFormulario', 'valor' => 'valor');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AlunoOpcaoEnvios();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setAluno((isset($v['Aluno']) ? $this->em->find("Aluno",array( 'id' => $v['Aluno'])) : NULL));
        $o->setConteudoFormulario((isset($v['ConteudoFormulario']) ? $this->em->find("ConteudoFormulario",array( 'id' => $v['ConteudoFormulario'])) : NULL));
        $o->setValor((isset($v['valor']) ? $v['valor'] : NULL));
        $o->setLogData((isset($v['logData']) ? $v['logData'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Aluno'] = (($o->getAluno()) ? AlunoAction::toArray($o->getAluno()) : NULL);
        $v['ConteudoFormulario'] = (($o->getConteudoFormulario()) ? ConteudoFormularioAction::toArray($o->getConteudoFormulario()) : NULL);
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
	$aFields['Aluno'] = "id_aluno";
	$conditions = preg_replace('~^Aluno$~',"id_aluno",$conditions);
	$aFields['ConteudoFormulario'] = "id_conteudo_formulario";
	$conditions = preg_replace('~^ConteudoFormulario$~',"id_conteudo_formulario",$conditions);
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
            $aRet["F"][] = AlunoOpcaoEnviosAction::transformaColunas($attr);
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
	$aFields['ConteudoFormulario'] = array("suggest","id");
	$aFields['valor'] = "memo";
	$aFields['logData'] = "datetime";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
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
        
        if($request->get('Aluno')) {
            $conditions[] = "{$alias}.Aluno = " . $request->get('Aluno')  . "";
            $orderPageConditions .= "&Aluno={$request->get('Aluno')}";
            $response->set('Aluno',  $request->get("Aluno"));
        }
        if($request->get('AlunoSuggest')) {
            $conditions[] = $response->get('AlunoSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&AlunoSuggest={$request->get('AlunoSuggest')}";
            $response->set('AlunoSuggest',  $request->get("AlunoSuggest"));
        }
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
        $oAction = new AlunoOpcaoEnviosAction();
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
        $aFields = AlunoOpcaoEnviosAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>