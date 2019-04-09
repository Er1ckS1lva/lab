<?php
require dirname(__FILE__) . '/../doctrine/Entities/AtividadeIdioma.php';
class AtividadeIdiomaActionParent {

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
		$aFieldsStructure = AtividadeIdiomaAction::getFieldsStructure(); # estrutura da tabela
	
        
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividadeIdioma = new AtividadeIdioma();
        $oAtividadeIdioma->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	$oAtividadeIdioma->setIdioma(QueryHelper::verifyObject($Idioma, 'Idioma', $this->em));
	$oAtividadeIdioma->setTitulo($titulo);
	$oAtividadeIdioma->setDescricao($descricao);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeIdioma);
            $this->em->flush($oAtividadeIdioma);
            $this->addTransaction($oAtividadeIdioma, $request);
            
			
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
            return $oAtividadeIdioma;
        }
        return true;
    }

    protected function addTransaction($oAtividadeIdioma, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividadeIdioma = $this->em->find('AtividadeIdioma',array('Atividade' => $Atividade, 'Idioma' => $Idioma));
        $oAtividadeIdioma->setTitulo($titulo);
	$oAtividadeIdioma->setDescricao($descricao);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeIdioma);
            $this->em->flush($oAtividadeIdioma);
            $this->editTransaction($oAtividadeIdioma, $request);
            
			
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
            return $oAtividadeIdioma;
        }
        return true;
    }

    protected function editTransaction($oAtividadeIdioma, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AtividadeIdioma', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeIdiomaAction::manualOrder($query, $order) === FALSE){
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
            ->from('AtividadeIdioma', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeIdiomaAction::manualOrder($query, $order) === FALSE){
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
            ->from('AtividadeIdioma', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($Atividade, $Idioma, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $Atividade, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('AtividadeIdioma', 'o')
            ->where( $where );
        
        $oAtividadeIdioma = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeIdioma;
    }
	
	public function selectHistorico($Atividade, $Idioma) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $Atividade, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->select('o')
            ->from('AtividadeIdioma', 'o')
            ->where( $where );
        $oAtividadeIdioma = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeIdioma;
    }

    public function delLogical($Atividade, $Idioma, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $Atividade, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->update("AtividadeIdioma o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Atividade, $Idioma);
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

    public function delPhysical($Atividade, $Idioma, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $Atividade, 'o.Idioma' => $Idioma), $qb);
        $query = $qb->delete()->from("AtividadeIdioma", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Atividade, $Idioma);
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

    protected function delTransaction($Atividade, $Idioma){
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
        return 'Atividade Idioma';
    }

    public static function getTableName(){
        return 'atividade_idioma';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'AtividadeIdioma';
    }
    
    public static function getBaseUrl() {
        return URL . AtividadeIdiomaAction::getModuleName(). "/AtividadeIdioma/";
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
        $aValidateFields = array('id_atividade' => 'Atividade', 'id_idioma' => 'Idioma');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AtividadeIdioma();
        $o->setAtividade((isset($v['Atividade']) ? $this->em->find("Atividade",array( 'id' => $v['Atividade'])) : NULL));
        $o->setIdioma((isset($v['Idioma']) ? $this->em->find("Idioma",array( 'id' => $v['Idioma'])) : NULL));
        $o->setTitulo((isset($v['titulo']) ? $v['titulo'] : NULL));
        $o->setDescricao((isset($v['descricao']) ? $v['descricao'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['Atividade'] = (($o->getAtividade()) ? AtividadeAction::toArray($o->getAtividade()) : NULL);
        $v['Idioma'] = (($o->getIdioma()) ? IdiomaAction::toArray($o->getIdioma()) : NULL);
        $v['titulo'] = $o->getTitulo();
        $v['descricao'] = $o->getDescricao();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['Atividade'] = "id_atividade";
	$conditions = preg_replace('~^Atividade$~',"id_atividade",$conditions);
	$aFields['Idioma'] = "id_idioma";
	$conditions = preg_replace('~^Idioma$~',"id_idioma",$conditions);
	$aFields['titulo'] = "titulo";
	$conditions = preg_replace('~^titulo$~',"titulo",$conditions);
	$aFields['descricao'] = "descricao";
	$conditions = preg_replace('~^descricao$~',"descricao",$conditions);
        if(!$conditions){
            return $aFields;
        }
        return $conditions;
    }
	
	public static function getKeys($tipo = null) {
        # F- FieldName || A- AttributeName
        @$aKeys = array('o.Atividade' => $Atividade, 'o.Idioma' => $Idioma); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = AtividadeIdiomaAction::transformaColunas($attr);
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
        	$aFields['Atividade'] = array("suggest","titulo");
	$aFields['Idioma'] = array("suggest","titulo");
	$aFields['titulo'] = "str";
	$aFields['descricao'] = "str";
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
        if($request->get('descricao')) {
            $conditions[] = "{$alias}.descricao LIKE '%" . ($request->get('descricao') ) . "%'";
            $orderPageConditions .= "&descricao={$request->get('descricao')}";
            $response->set('descricao',  $request->get("descricao"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AtividadeIdiomaAction();
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
        $aFields = AtividadeIdiomaAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>