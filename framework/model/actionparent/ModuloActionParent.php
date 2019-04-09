<?php
require dirname(__FILE__) . '/../doctrine/Entities/Modulo.php';
class ModuloActionParent {

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
		$aFieldsStructure = ModuloAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Entidade") == '') {
            throw new Exception("Por favor, informe o campo Entidade!");
        }


if(isset($aFieldsStructure["Entidade"]) && !isset($aFieldsStructure["Entidade"]["isFk"]) && $aFieldsStructure["Entidade"]["length"]){
    if (strlen($request->get("Entidade")) > $aFieldsStructure["Entidade"]["length"]) {
        $this->setMsg("Por favor, informe o campo Entidade corretamente, o tamanho do campo é {$aFieldsStructure["Entidade"]["length"]}!");
        return false;
    }
}
	if ($request->get("nome") == '') {
            throw new Exception("Por favor, informe o campo Nome!");
        }


if(isset($aFieldsStructure["nome"]) && !isset($aFieldsStructure["nome"]["isFk"]) && $aFieldsStructure["nome"]["length"]){
    if (strlen($request->get("nome")) > $aFieldsStructure["nome"]["length"]) {
        $this->setMsg("Por favor, informe o campo Nome corretamente, o tamanho do campo é {$aFieldsStructure["nome"]["length"]}!");
        return false;
    }
}
        if (!Validate::validateCampoUnico("Modulo", array('o.nome' => "'{$request->get('nome')}'"), array('o.id' => $request->get('id')), $this->em,$edicao)){
            throw new Exception("Já existe um registro cadastrado com o valor: [Nome: {$request->get('nome')}]");
        }

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oModulo = new Modulo();
        $oModulo->setEntidade(QueryHelper::verifyObject($Entidade, 'Entidade', $this->em));
	$oModulo->setNome($nome);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oModulo);
            $this->em->flush($oModulo);
            $this->addTransaction($oModulo, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Módulo com o índice '{$oModulo->getId()}'", FALSE);
            ## LOG END ##
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
            return $oModulo;
        }
        return true;
    }

    protected function addTransaction($oModulo, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oModulo = $this->em->find('Modulo',array('id' => $id));
        $oModulo->setEntidade(QueryHelper::verifyObject($Entidade, 'Entidade', $this->em));
	$oModulo->setNome($nome);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oModulo);
            $this->em->flush($oModulo);
            $this->editTransaction($oModulo, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Módulo com o índice {$id}", FALSE);
            ## LOG END ##
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
            return $oModulo;
        }
        return true;
    }

    protected function editTransaction($oModulo, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Modulo', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ModuloAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Entidade') {
                    $query->leftJoin('o.Entidade', 'u');
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
            ->from('Modulo', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ModuloAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Entidade') {
                    $query->leftJoin('o.Entidade', 'u');
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
            ->from('Modulo', 'o');
        
        
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
            ->from('Modulo', 'o')
            ->where( $where );
        
        $oModulo = $query->getQuery()->getOneOrNullResult();
        return $oModulo;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Modulo', 'o')
            ->where( $where );
        $oModulo = $query->getQuery()->getOneOrNullResult();
        return $oModulo;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Modulo o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id);
            $query->execute();
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Excluído Módulo com o índice {$id}", FALSE);
            ## LOG END ##
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
        $query = $qb->delete()->from("Modulo", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id);
            $query->execute();
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Excluído Módulo com o índice {$id}", FALSE);
            ## LOG END ##
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
        return 'Módulo';
    }

    public static function getTableName(){
        return 'modulo';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'Modulo';
    }
    
    public static function getBaseUrl() {
        return URL . ModuloAction::getModuleName(). "/Modulo/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return $o->getNome();
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('id_entidade' => 'Entidade', 'nome' => 'nome');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Modulo();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setEntidade((isset($v['Entidade']) ? $this->em->find("Entidade",array( 'id' => $v['Entidade'])) : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Entidade'] = (($o->getEntidade()) ? EntidadeAction::toArray($o->getEntidade()) : NULL);
        $v['nome'] = $o->getNome();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['Entidade'] = "id_entidade";
	$conditions = preg_replace('~^Entidade$~',"id_entidade",$conditions);
	$aFields['nome'] = "nome";
	$conditions = preg_replace('~^nome$~',"nome",$conditions);
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
            $aRet["F"][] = ModuloAction::transformaColunas($attr);
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
	$aFields['Entidade'] = array("suggest","nome");
	$aFields['nome'] = "str";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
        public function selectByNome($nome, $fieldsToSelect = null) {
		/* @var $query \Doctrine\ORM\QueryBuilder */
		
        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.nome' => "'$nome'"), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('Modulo', 'o')
            ->where( $where );
        
        $oModulo = $query->getQuery()->getOneOrNullResult();
        return $oModulo;
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
        
        if($request->get('Entidade')) {
            $conditions[] = "{$alias}.Entidade = " . $request->get('Entidade')  . "";
            $orderPageConditions .= "&Entidade={$request->get('Entidade')}";
            $response->set('Entidade',  $request->get("Entidade"));
        }
        if($request->get('EntidadeSuggest')) {
            $conditions[] = $response->get('EntidadeSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&EntidadeSuggest={$request->get('EntidadeSuggest')}";
            $response->set('EntidadeSuggest',  $request->get("EntidadeSuggest"));
        }
        if($request->get('nome')) {
            $conditions[] = "{$alias}.nome LIKE '%" . ($request->get('nome') ) . "%'";
            $orderPageConditions .= "&nome={$request->get('nome')}";
            $response->set('nome',  $request->get("nome"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new ModuloAction();
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
        $aFields = ModuloAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>