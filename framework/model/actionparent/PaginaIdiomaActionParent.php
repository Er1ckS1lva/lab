<?php
require dirname(__FILE__) . '/../doctrine/Entities/PaginaIdioma.php';
class PaginaIdiomaActionParent {

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
		$aFieldsStructure = PaginaIdiomaAction::getFieldsStructure(); # estrutura da tabela
	
        
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oPaginaIdioma = new PaginaIdioma();
        $oPaginaIdioma->setPagina(QueryHelper::verifyObject($Pagina, 'Pagina', $this->em));
	$oPaginaIdioma->setIdioma(QueryHelper::verifyObject($Idioma, 'Idioma', $this->em));
	$oPaginaIdioma->setTitulo($titulo);
	$oPaginaIdioma->setConteudo($conteudo);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oPaginaIdioma);
            $this->em->flush($oPaginaIdioma);
            $this->addTransaction($oPaginaIdioma, $request);
            
			
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
            return $oPaginaIdioma;
        }
        return true;
    }

    protected function addTransaction($oPaginaIdioma, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oPaginaIdioma = $this->em->find('PaginaIdioma',array('Pagina' => $Pagina, 'Idioma' => $Idioma));
        $oPaginaIdioma->setTitulo($titulo);
	$oPaginaIdioma->setConteudo($conteudo);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oPaginaIdioma);
            $this->em->flush($oPaginaIdioma);
            $this->editTransaction($oPaginaIdioma, $request);
            
			
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
            return $oPaginaIdioma;
        }
        return true;
    }

    protected function editTransaction($oPaginaIdioma, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('PaginaIdioma', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(PaginaIdiomaAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Pagina') {
                    $query->leftJoin('o.Pagina', 'u');
                    $entityPrefix = "u";
                    $order = 'titulo';
                }if($order == 'Idioma') {
                    $query->leftJoin('o.Idioma', 'u');
                    $entityPrefix = "u";
                    $order = 'titulo';
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
            ->from('PaginaIdioma', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(PaginaIdiomaAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Pagina') {
                    $query->leftJoin('o.Pagina', 'u');
                    $entityPrefix = "u";
                    $order = 'titulo';
                }if($order == 'Idioma') {
                    $query->leftJoin('o.Idioma', 'u');
                    $entityPrefix = "u";
                    $order = 'titulo';
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
            ->from('PaginaIdioma', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($Pagina, $Idioma, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Pagina' => $Pagina, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('PaginaIdioma', 'o')
            ->where( $where );
        
        $oPaginaIdioma = $query->getQuery()->getOneOrNullResult();
        return $oPaginaIdioma;
    }
	
	public function selectHistorico($Pagina, $Idioma) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Pagina' => $Pagina, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->select('o')
            ->from('PaginaIdioma', 'o')
            ->where( $where );
        $oPaginaIdioma = $query->getQuery()->getOneOrNullResult();
        return $oPaginaIdioma;
    }

    public function delLogical($Pagina, $Idioma, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Pagina' => $Pagina, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->update("PaginaIdioma o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Pagina, $Idioma);
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

    public function delPhysical($Pagina, $Idioma, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Pagina' => $Pagina, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->delete()->from("PaginaIdioma", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Pagina, $Idioma);
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

    protected function delTransaction($Pagina, $Idioma){
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
        return 'Pagina Idioma';
    }

    public static function getTableName(){
        return 'pagina_idioma';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'PaginaIdioma';
    }
    
    public static function getBaseUrl() {
        return URL . PaginaIdiomaAction::getModuleName(). "/PaginaIdioma/";
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
        $aValidateFields = array('id_pagina' => 'Pagina', 'id_idioma' => 'Idioma');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new PaginaIdioma();
        $o->setPagina((isset($v['Pagina']) ? $this->em->find("Pagina",array( 'id' => $v['Pagina'])) : NULL));
        $o->setIdioma((isset($v['Idioma']) ? $this->em->find("Idioma",array( 'id' => $v['Idioma'])) : NULL));
        $o->setTitulo((isset($v['titulo']) ? $v['titulo'] : NULL));
        $o->setConteudo((isset($v['conteudo']) ? $v['conteudo'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['Pagina'] = (($o->getPagina()) ? PaginaAction::toArray($o->getPagina()) : NULL);
        $v['Idioma'] = (($o->getIdioma()) ? IdiomaAction::toArray($o->getIdioma()) : NULL);
        $v['titulo'] = $o->getTitulo();
        $v['conteudo'] = $o->getConteudo();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['Pagina'] = "id_pagina";
	$conditions = preg_replace('~^Pagina$~',"id_pagina",$conditions);
	$aFields['Idioma'] = "id_idioma";
	$conditions = preg_replace('~^Idioma$~',"id_idioma",$conditions);
	$aFields['titulo'] = "titulo";
	$conditions = preg_replace('~^titulo$~',"titulo",$conditions);
	$aFields['conteudo'] = "conteudo";
	$conditions = preg_replace('~^conteudo$~',"conteudo",$conditions);
        if(!$conditions){
            return $aFields;
        }
        return $conditions;
    }
	
	public static function getKeys($tipo = null) {
        # F- FieldName || A- AttributeName
        @$aKeys = array('o.Pagina' => $Pagina, 'o.Idioma' => $Idioma); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = PaginaIdiomaAction::transformaColunas($attr);
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
        	$aFields['Pagina'] = array("suggest","titulo");
	$aFields['Idioma'] = array("suggest","titulo");
	$aFields['titulo'] = "str";
	$aFields['conteudo'] = "editor";
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
        
        if($request->get('Pagina')) {
            $conditions[] = "{$alias}.Pagina = " . $request->get('Pagina')  . "";
            $orderPageConditions .= "&Pagina={$request->get('Pagina')}";
            $response->set('Pagina',  $request->get("Pagina"));
        }
        if($request->get('PaginaSuggest')) {
            $conditions[] = $response->get('PaginaSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&PaginaSuggest={$request->get('PaginaSuggest')}";
            $response->set('PaginaSuggest',  $request->get("PaginaSuggest"));
        }
        if($request->get('Idioma')) {
            $conditions[] = "{$alias}.Idioma = " . $request->get('Idioma')  . "";
            $orderPageConditions .= "&Idioma={$request->get('Idioma')}";
            $response->set('Idioma',  $request->get("Idioma"));
        }
        if($request->get('IdiomaSuggest')) {
            $conditions[] = $response->get('IdiomaSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&IdiomaSuggest={$request->get('IdiomaSuggest')}";
            $response->set('IdiomaSuggest',  $request->get("IdiomaSuggest"));
        }
        if($request->get('titulo')) {
            $conditions[] = "{$alias}.titulo LIKE '%" . ($request->get('titulo') ) . "%'";
            $orderPageConditions .= "&titulo={$request->get('titulo')}";
            $response->set('titulo',  $request->get("titulo"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new PaginaIdiomaAction();
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
        $aFields = PaginaIdiomaAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>