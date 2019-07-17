<?php
require dirname(__FILE__) . '/../doctrine/Entities/ConteudoArquivo.php';
class ConteudoArquivoActionParent {

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
		$aFieldsStructure = ConteudoArquivoAction::getFieldsStructure(); # estrutura da tabela
	
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
        
        $oConteudoArquivo = new ConteudoArquivo();
        $oConteudoArquivo->setConteudo(QueryHelper::verifyObject($Conteudo, 'Conteudo', $this->em));
	$oConteudoArquivo->setArquivo($arquivo);
	$oConteudoArquivo->setNome($nome);
	$oConteudoArquivo->setTipo($tipo);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oConteudoArquivo);
            $this->em->flush($oConteudoArquivo);
            $this->addTransaction($oConteudoArquivo, $request);
            
			
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
            return $oConteudoArquivo;
        }
        return true;
    }

    protected function addTransaction($oConteudoArquivo, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oConteudoArquivo = $this->em->find('ConteudoArquivo',array('Conteudo' => $Conteudo));
        $oConteudoArquivo->setArquivo($arquivo);
	$oConteudoArquivo->setNome($nome);
	$oConteudoArquivo->setTipo($tipo);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oConteudoArquivo);
            $this->em->flush($oConteudoArquivo);
            $this->editTransaction($oConteudoArquivo, $request);
            
			
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
            return $oConteudoArquivo;
        }
        return true;
    }

    protected function editTransaction($oConteudoArquivo, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('ConteudoArquivo', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ConteudoArquivoAction::manualOrder($query, $order) === FALSE){
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
            ->from('ConteudoArquivo', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ConteudoArquivoAction::manualOrder($query, $order) === FALSE){
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
            ->from('ConteudoArquivo', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($Conteudo, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Conteudo' => $Conteudo), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('ConteudoArquivo', 'o')
            ->where( $where );
        
        $oConteudoArquivo = $query->getQuery()->getOneOrNullResult();
        return $oConteudoArquivo;
    }
	
	public function selectHistorico($Conteudo) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Conteudo' => $Conteudo), $qb);
        $query = $qb->select('o')
            ->from('ConteudoArquivo', 'o')
            ->where( $where );
        $oConteudoArquivo = $query->getQuery()->getOneOrNullResult();
        return $oConteudoArquivo;
    }

    public function delLogical($Conteudo, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Conteudo' => $Conteudo), $qb);
        $query = $qb->update("ConteudoArquivo o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Conteudo);
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

    public function delPhysical($Conteudo, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Conteudo' => $Conteudo), $qb);
        $query = $qb->delete()->from("ConteudoArquivo", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Conteudo);
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

    protected function delTransaction($Conteudo){
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
        return 'Arquivo do Conteúdo';
    }

    public static function getTableName(){
        return 'conteudo_arquivo';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'ConteudoArquivo';
    }
    
    public static function getBaseUrl() {
        return URL . ConteudoArquivoAction::getModuleName(). "/ConteudoArquivo/";
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
        $aValidateFields = array('id_conteudo' => 'Conteudo', 'arquivo' => 'arquivo', 'nome' => 'nome', 'tipo' => 'tipo');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new ConteudoArquivo();
        $o->setConteudo((isset($v['Conteudo']) ? $this->em->find("Conteudo",array( 'id' => $v['Conteudo'])) : NULL));
        $o->setArquivo((isset($v['arquivo']) ? $v['arquivo'] : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setTipo((isset($v['tipo']) ? $v['tipo'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['Conteudo'] = (($o->getConteudo()) ? ConteudoAction::toArray($o->getConteudo()) : NULL);
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
        	$aFields['Conteudo'] = "id_conteudo";
	$conditions = preg_replace('~^Conteudo$~',"id_conteudo",$conditions);
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
        @$aKeys = array('o.Conteudo' => $Conteudo); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = ConteudoArquivoAction::transformaColunas($attr);
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
        	$aFields['Conteudo'] = array("suggest","titulo");
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
        
        if($request->get('Conteudo')) {
            $conditions[] = "{$alias}.Conteudo = " . $request->get('Conteudo')  . "";
            $orderPageConditions .= "&Conteudo={$request->get('Conteudo')}";
            $response->set('Conteudo',  $request->get("Conteudo"));
        }
        if($request->get('ConteudoSuggest')) {
            $conditions[] = $response->get('ConteudoSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&ConteudoSuggest={$request->get('ConteudoSuggest')}";
            $response->set('ConteudoSuggest',  $request->get("ConteudoSuggest"));
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
        $oAction = new ConteudoArquivoAction();
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
        $aFields = ConteudoArquivoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>