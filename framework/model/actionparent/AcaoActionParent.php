<?php
require dirname(__FILE__) . '/../doctrine/Entities/Acao.php';
class AcaoActionParent {

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
		$aFieldsStructure = AcaoAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Modulo") == '') {
            throw new Exception("Por favor, informe o campo Módulo!");
        }


if(isset($aFieldsStructure["Modulo"]) && !isset($aFieldsStructure["Modulo"]["isFk"]) && $aFieldsStructure["Modulo"]["length"]){
    if (strlen($request->get("Modulo")) > $aFieldsStructure["Modulo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Módulo corretamente, o tamanho do campo é {$aFieldsStructure["Modulo"]["length"]}!");
        return false;
    }
}
        if (!Validate::validateCampoUnico("Acao", array('o.Modulo' => "'{$request->get('Modulo')}'", 'o.nome' => "'{$request->get('nome')}'"), array('o.id' => $request->get('id')), $this->em,$edicao)){
            throw new Exception("Já existe um registro cadastrado com o valor: [Módulo: {$request->get('Modulo')}] - [Nome: {$request->get('nome')}]");
        }

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAcao = new Acao();
        $oAcao->setModulo(QueryHelper::verifyObject($Modulo, 'Modulo', $this->em));
	$oAcao->setNome($nome);
	$oAcao->setDescricao($descricao);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAcao);
            $this->em->flush($oAcao);
            $this->addTransaction($oAcao, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Ação com o índice '{$oAcao->getId()}'", FALSE);
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
            return $oAcao;
        }
        return true;
    }

    protected function addTransaction($oAcao, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAcao = $this->em->find('Acao',array('id' => $id));
        $oAcao->setModulo(QueryHelper::verifyObject($Modulo, 'Modulo', $this->em));
	$oAcao->setNome($nome);
	$oAcao->setDescricao($descricao);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAcao);
            $this->em->flush($oAcao);
            $this->editTransaction($oAcao, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Ação com o índice {$id}", FALSE);
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
            return $oAcao;
        }
        return true;
    }

    protected function editTransaction($oAcao, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Acao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Modulo') {
                    $query->leftJoin('o.Modulo', 'u');
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
            ->from('Acao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AcaoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Modulo') {
                    $query->leftJoin('o.Modulo', 'u');
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
            ->from('Acao', 'o');
        
        
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
            ->from('Acao', 'o')
            ->where( $where );
        
        $oAcao = $query->getQuery()->getOneOrNullResult();
        return $oAcao;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Acao', 'o')
            ->where( $where );
        $oAcao = $query->getQuery()->getOneOrNullResult();
        return $oAcao;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Acao o")
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
            $oLog->register("O", "Excluído Ação com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("Acao", "o")
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
            $oLog->register("O", "Excluído Ação com o índice {$id}", FALSE);
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
        return 'Ação';
    }

    public static function getTableName(){
        return 'acao';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'Acao';
    }
    
    public static function getBaseUrl() {
        return URL . AcaoAction::getModuleName(). "/Acao/";
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
        $aValidateFields = array('id_modulo' => 'Modulo');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Acao();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setModulo((isset($v['Modulo']) ? $this->em->find("Modulo",array( 'id' => $v['Modulo'])) : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setDescricao((isset($v['descricao']) ? $v['descricao'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Modulo'] = (($o->getModulo()) ? ModuloAction::toArray($o->getModulo()) : NULL);
        $v['nome'] = $o->getNome();
        $v['descricao'] = $o->getDescricao();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['Modulo'] = "id_modulo";
	$conditions = preg_replace('~^Modulo$~',"id_modulo",$conditions);
	$aFields['nome'] = "nome";
	$conditions = preg_replace('~^nome$~',"nome",$conditions);
	$aFields['descricao'] = "descricao";
	$conditions = preg_replace('~^descricao$~',"descricao",$conditions);
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
            $aRet["F"][] = AcaoAction::transformaColunas($attr);
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
	$aFields['Modulo'] = array("suggest","nome");
	$aFields['nome'] = "str";
	$aFields['descricao'] = "str";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
        public function selectByModuloNome($Modulo,$nome, $fieldsToSelect = null) {
		/* @var $query \Doctrine\ORM\QueryBuilder */
		
        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Modulo' => "'$Modulo'", 'o.nome' => "'$nome'"), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('Acao', 'o')
            ->where( $where );
        
        $oAcao = $query->getQuery()->getOneOrNullResult();
        return $oAcao;
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
        
        if($request->get('Modulo')) {
            $conditions[] = "{$alias}.Modulo = " . $request->get('Modulo')  . "";
            $orderPageConditions .= "&Modulo={$request->get('Modulo')}";
            $response->set('Modulo',  $request->get("Modulo"));
        }
        if($request->get('ModuloSuggest')) {
            $conditions[] = $response->get('ModuloSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&ModuloSuggest={$request->get('ModuloSuggest')}";
            $response->set('ModuloSuggest',  $request->get("ModuloSuggest"));
        }
        if($request->get('nome')) {
            $conditions[] = "{$alias}.nome LIKE '%" . ($request->get('nome') ) . "%'";
            $orderPageConditions .= "&nome={$request->get('nome')}";
            $response->set('nome',  $request->get("nome"));
        }
        if($request->get('descricao')) {
            $conditions[] = "{$alias}.descricao LIKE '%" . ($request->get('descricao') ) . "%'";
            $orderPageConditions .= "&descricao={$request->get('descricao')}";
            $response->set('descricao',  $request->get("descricao"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AcaoAction();
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
        $aFields = AcaoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>