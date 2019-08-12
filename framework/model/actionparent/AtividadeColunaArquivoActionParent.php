<?php
require dirname(__FILE__) . '/../doctrine/Entities/AtividadeColunaArquivo.php';
class AtividadeColunaArquivoActionParent {

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
		$aFieldsStructure = AtividadeColunaArquivoAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("AtividadeColuna") == '') {
            throw new Exception("Por favor, informe o campo Atividade de Coluna!");
        }


if(isset($aFieldsStructure["AtividadeColuna"]) && !isset($aFieldsStructure["AtividadeColuna"]["isFk"]) && $aFieldsStructure["AtividadeColuna"]["length"]){
    if (strlen($request->get("AtividadeColuna")) > $aFieldsStructure["AtividadeColuna"]["length"]) {
        $this->setMsg("Por favor, informe o campo Atividade de Coluna corretamente, o tamanho do campo é {$aFieldsStructure["AtividadeColuna"]["length"]}!");
        return false;
    }
}
	if ($request->get("coluna") == '') {
            throw new Exception("Por favor, informe o campo Coluna!");
        }


if(isset($aFieldsStructure["coluna"]) && !isset($aFieldsStructure["coluna"]["isFk"]) && $aFieldsStructure["coluna"]["length"]){
    if (strlen($request->get("coluna")) > $aFieldsStructure["coluna"]["length"]) {
        $this->setMsg("Por favor, informe o campo Coluna corretamente, o tamanho do campo é {$aFieldsStructure["coluna"]["length"]}!");
        return false;
    }
}
	if ($request->get("arquivo") == '') {
            throw new Exception("Por favor, informe o campo Arquivo!");
        }


if(isset($aFieldsStructure["arquivo"]) && !isset($aFieldsStructure["arquivo"]["isFk"]) && $aFieldsStructure["arquivo"]["length"]){
    if (strlen($request->get("arquivo")) > $aFieldsStructure["arquivo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Arquivo corretamente, o tamanho do campo é {$aFieldsStructure["arquivo"]["length"]}!");
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
        
        $oAtividadeColunaArquivo = new AtividadeColunaArquivo();
        $oAtividadeColunaArquivo->setAtividadeColuna(QueryHelper::verifyObject($AtividadeColuna, 'AtividadeColuna', $this->em));
	$oAtividadeColunaArquivo->setColuna($coluna);
	$oAtividadeColunaArquivo->setArquivo($arquivo);
	$oAtividadeColunaArquivo->setNome($nome);
	$oAtividadeColunaArquivo->setTipo($tipo);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeColunaArquivo);
            $this->em->flush($oAtividadeColunaArquivo);
            $this->addTransaction($oAtividadeColunaArquivo, $request);
            
			
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
            return $oAtividadeColunaArquivo;
        }
        return true;
    }

    protected function addTransaction($oAtividadeColunaArquivo, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividadeColunaArquivo = $this->em->find('AtividadeColunaArquivo',array('id' => $id));
        $oAtividadeColunaArquivo->setAtividadeColuna(QueryHelper::verifyObject($AtividadeColuna, 'AtividadeColuna', $this->em));
	$oAtividadeColunaArquivo->setColuna($coluna);
	$oAtividadeColunaArquivo->setArquivo($arquivo);
	$oAtividadeColunaArquivo->setNome($nome);
	$oAtividadeColunaArquivo->setTipo($tipo);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeColunaArquivo);
            $this->em->flush($oAtividadeColunaArquivo);
            $this->editTransaction($oAtividadeColunaArquivo, $request);
            
			
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
            return $oAtividadeColunaArquivo;
        }
        return true;
    }

    protected function editTransaction($oAtividadeColunaArquivo, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AtividadeColunaArquivo', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeColunaArquivoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'AtividadeColuna') {
                    $query->leftJoin('o.AtividadeColuna', 'u');
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
            ->from('AtividadeColunaArquivo', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeColunaArquivoAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'AtividadeColuna') {
                    $query->leftJoin('o.AtividadeColuna', 'u');
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
            ->from('AtividadeColunaArquivo', 'o');
        
        
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
            ->from('AtividadeColunaArquivo', 'o')
            ->where( $where );
        
        $oAtividadeColunaArquivo = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeColunaArquivo;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('AtividadeColunaArquivo', 'o')
            ->where( $where );
        $oAtividadeColunaArquivo = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeColunaArquivo;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("AtividadeColunaArquivo o")
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
        $query = $qb->delete()->from("AtividadeColunaArquivo", "o")
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
        return 'Arquivo da Atividade de Coluna';
    }

    public static function getTableName(){
        return 'atividade_coluna_arquivo';
    }

    public static function getModuleName() {
        return '';
    }
    
    public static function getClassName() {
        return 'AtividadeColunaArquivo';
    }
    
    public static function getBaseUrl() {
        return URL . AtividadeColunaArquivoAction::getModuleName(). "/AtividadeColunaArquivo/";
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
        $aValidateFields = array('id_atividade_coluna' => 'AtividadeColuna', 'coluna' => 'coluna', 'arquivo' => 'arquivo', 'nome' => 'nome', 'tipo' => 'tipo');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AtividadeColunaArquivo();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setAtividadeColuna((isset($v['AtividadeColuna']) ? $this->em->find("AtividadeColuna",array( 'id' => $v['AtividadeColuna'])) : NULL));
        $o->setColuna((isset($v['coluna']) ? $v['coluna'] : NULL));
        $o->setArquivo((isset($v['arquivo']) ? $v['arquivo'] : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setTipo((isset($v['tipo']) ? $v['tipo'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['AtividadeColuna'] = (($o->getAtividadeColuna()) ? AtividadeColunaAction::toArray($o->getAtividadeColuna()) : NULL);
        $v['coluna'] = $o->getColuna();
        $v['arquivo'] = $o->getArquivo();
        $v['nome'] = $o->getNome();
        $v['tipo'] = $o->getTipo();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['AtividadeColuna'] = "id_atividade_coluna";
	$conditions = preg_replace('~^AtividadeColuna$~',"id_atividade_coluna",$conditions);
	$aFields['coluna'] = "coluna";
	$conditions = preg_replace('~^coluna$~',"coluna",$conditions);
	$aFields['arquivo'] = "arquivo";
	$conditions = preg_replace('~^arquivo$~',"arquivo",$conditions);
	$aFields['nome'] = "nome";
	$conditions = preg_replace('~^nome$~',"nome",$conditions);
	$aFields['tipo'] = "tipo";
	$conditions = preg_replace('~^tipo$~',"tipo",$conditions);
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
            $aRet["F"][] = AtividadeColunaArquivoAction::transformaColunas($attr);
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
	$aFields['AtividadeColuna'] = array("suggest","id");
	$aFields['coluna'] = "int";
	$aFields['arquivo'] = "str";
	$aFields['nome'] = "str";
	$aFields['tipo'] = "str";
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
        
        if($request->get('AtividadeColuna')) {
            $conditions[] = "{$alias}.AtividadeColuna = " . $request->get('AtividadeColuna')  . "";
            $orderPageConditions .= "&AtividadeColuna={$request->get('AtividadeColuna')}";
            $response->set('AtividadeColuna',  $request->get("AtividadeColuna"));
        }
        if($request->get('AtividadeColunaSuggest')) {
            $conditions[] = $response->get('AtividadeColunaSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&AtividadeColunaSuggest={$request->get('AtividadeColunaSuggest')}";
            $response->set('AtividadeColunaSuggest',  $request->get("AtividadeColunaSuggest"));
        }
        if($request->get('coluna')) {
            $conditions[] = "{$alias}.coluna = '" . $request->get('coluna')  . "'";
            $orderPageConditions .= "&coluna={$request->get('coluna')}";
            $response->set('coluna',  $request->get("coluna"));
        }
        if($request->get('arquivo')) {
            $conditions[] = "{$alias}.arquivo LIKE '%" . ($request->get('arquivo') ) . "%'";
            $orderPageConditions .= "&arquivo={$request->get('arquivo')}";
            $response->set('arquivo',  $request->get("arquivo"));
        }
        if($request->get('nome')) {
            $conditions[] = "{$alias}.nome LIKE '%" . ($request->get('nome') ) . "%'";
            $orderPageConditions .= "&nome={$request->get('nome')}";
            $response->set('nome',  $request->get("nome"));
        }
        if($request->get('tipo')) {
            $conditions[] = "{$alias}.tipo LIKE '%" . ($request->get('tipo') ) . "%'";
            $orderPageConditions .= "&tipo={$request->get('tipo')}";
            $response->set('tipo',  $request->get("tipo"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AtividadeColunaArquivoAction();
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
        $aFields = AtividadeColunaArquivoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>