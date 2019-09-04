<?php
require dirname(__FILE__) . '/../doctrine/Entities/AlunoOpcao.php';
class AlunoOpcaoActionParent {

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
		$aFieldsStructure = AlunoOpcaoAction::getFieldsStructure(); # estrutura da tabela
	
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
        
        $oAlunoOpcao = new AlunoOpcao();
        $oAlunoOpcao->setValor($valor);
	$oAlunoOpcao->setLogData(isset($logData) ? new DateTime($logData) : NULL);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoOpcao);
            $this->em->flush($oAlunoOpcao);
            $this->addTransaction($oAlunoOpcao, $request);
            
			
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
            return $oAlunoOpcao;
        }
        return true;
    }

    protected function addTransaction($oAlunoOpcao, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoOpcao = $this->em->find('AlunoOpcao',array('id_aluno' => $id_aluno, 'id_conteudo_formulario' => $id_conteudo_formulario));
        $oAlunoOpcao->setValor($valor);
	$oAlunoOpcao->setLogData(isset($logData) ? new DateTime($logData) : NULL);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoOpcao);
            $this->em->flush($oAlunoOpcao);
            $this->editTransaction($oAlunoOpcao, $request);
            
			
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
            return $oAlunoOpcao;
        }
        return true;
    }

    protected function editTransaction($oAlunoOpcao, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AlunoOpcao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoOpcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                
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
            ->from('AlunoOpcao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoOpcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";

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
            ->from('AlunoOpcao', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($id_aluno, $id_conteudo_formulario, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id_aluno' => $id_aluno, 'o.id_conteudo_formulario' => $id_conteudo_formulario), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('AlunoOpcao', 'o')
            ->where( $where );
        
        $oAlunoOpcao = $query->getQuery()->getOneOrNullResult();
        return $oAlunoOpcao;
    }
	
	public function selectHistorico($id_aluno, $id_conteudo_formulario) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id_aluno' => $id_aluno, 'o.id_conteudo_formulario' => $id_conteudo_formulario), $qb);
        $query = $qb->select('o')
            ->from('AlunoOpcao', 'o')
            ->where( $where );
        $oAlunoOpcao = $query->getQuery()->getOneOrNullResult();
        return $oAlunoOpcao;
    }

    public function delLogical($id_aluno, $id_conteudo_formulario, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id_aluno' => $id_aluno, 'o.id_conteudo_formulario' => $id_conteudo_formulario), $qb);
        $query = $qb->update("AlunoOpcao o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id_aluno, $id_conteudo_formulario);
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

    public function delPhysical($id_aluno, $id_conteudo_formulario, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id_aluno' => $id_aluno, 'o.id_conteudo_formulario' => $id_conteudo_formulario), $qb);
        $query = $qb->delete()->from("AlunoOpcao", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id_aluno, $id_conteudo_formulario);
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

    protected function delTransaction($id_aluno, $id_conteudo_formulario){
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
        return 'Aluno Opcao';
    }

    public static function getTableName(){
        return 'aluno_opcao';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'AlunoOpcao';
    }
    
    public static function getBaseUrl() {
        return URL . AlunoOpcaoAction::getModuleName(). "/AlunoOpcao/";
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
        $aValidateFields = array('valor' => 'valor');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AlunoOpcao();
        $o->setId_aluno((isset($v['id_aluno']) ? $v['id_aluno'] : NULL));
        $o->setId_conteudo_formulario((isset($v['id_conteudo_formulario']) ? $v['id_conteudo_formulario'] : NULL));
        $o->setValor((isset($v['valor']) ? $v['valor'] : NULL));
        $o->setLogData((isset($v['logData']) ? $v['logData'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id_aluno'] = $o->getId_aluno();
        $v['id_conteudo_formulario'] = $o->getId_conteudo_formulario();
        $v['valor'] = $o->getValor();
        $v['logData'] = $o->getLogData();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id_aluno'] = "id_aluno";
	$conditions = preg_replace('~^id_aluno$~',"id_aluno",$conditions);
	$aFields['id_conteudo_formulario'] = "id_conteudo_formulario";
	$conditions = preg_replace('~^id_conteudo_formulario$~',"id_conteudo_formulario",$conditions);
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
        @$aKeys = array('o.id_aluno' => $id_aluno, 'o.id_conteudo_formulario' => $id_conteudo_formulario); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = AlunoOpcaoAction::transformaColunas($attr);
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
        	$aFields['id_aluno'] = "autoinc";
	$aFields['id_conteudo_formulario'] = "autoinc";
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
        $oAction = new AlunoOpcaoAction();
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
        $aFields = AlunoOpcaoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>