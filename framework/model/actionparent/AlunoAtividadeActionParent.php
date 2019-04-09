<?php
require dirname(__FILE__) . '/../doctrine/Entities/AlunoAtividade.php';
class AlunoAtividadeActionParent {

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
		$aFieldsStructure = AlunoAtividadeAction::getFieldsStructure(); # estrutura da tabela
	
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
	if ($request->get("score") == '') {
            throw new Exception("Por favor, informe o campo Score!");
        }


if(isset($aFieldsStructure["score"]) && !isset($aFieldsStructure["score"]["isFk"]) && $aFieldsStructure["score"]["length"]){
    if (strlen($request->get("score")) > $aFieldsStructure["score"]["length"]) {
        $this->setMsg("Por favor, informe o campo Score corretamente, o tamanho do campo é {$aFieldsStructure["score"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoAtividade = new AlunoAtividade();
        $oAlunoAtividade->setAluno(QueryHelper::verifyObject($Aluno, 'Aluno', $this->em));
	$oAlunoAtividade->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	$oAlunoAtividade->setArquivo($arquivo);
	$oAlunoAtividade->setNome($nome);
	$oAlunoAtividade->setTipo($tipo);
	$oAlunoAtividade->setScore($score);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoAtividade);
            $this->em->flush($oAlunoAtividade);
            $this->addTransaction($oAlunoAtividade, $request);
            
			
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
            return $oAlunoAtividade;
        }
        return true;
    }

    protected function addTransaction($oAlunoAtividade, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAlunoAtividade = $this->em->find('AlunoAtividade',array('Aluno' => $Aluno, 'Atividade' => $Atividade));
        $oAlunoAtividade->setArquivo($arquivo);
	$oAlunoAtividade->setNome($nome);
	$oAlunoAtividade->setTipo($tipo);
	$oAlunoAtividade->setScore($score);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAlunoAtividade);
            $this->em->flush($oAlunoAtividade);
            $this->editTransaction($oAlunoAtividade, $request);
            
			
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
            return $oAlunoAtividade;
        }
        return true;
    }

    protected function editTransaction($oAlunoAtividade, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AlunoAtividade', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoAtividadeAction::manualOrder($query, $order) === FALSE){
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
                    $order = 'titulo';
                }if($order == 'Atividade') {
                    $query->leftJoin('o.Atividade', 'u');
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
            ->from('AlunoAtividade', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AlunoAtividadeAction::manualOrder($query, $order) === FALSE){
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
                    $order = 'titulo';
                }if($order == 'Atividade') {
                    $query->leftJoin('o.Atividade', 'u');
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
            ->from('AlunoAtividade', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($Aluno, $Atividade, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Aluno' => $Aluno, 'o.Atividade' => $Atividade), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('AlunoAtividade', 'o')
            ->where( $where );
        
        $oAlunoAtividade = $query->getQuery()->getOneOrNullResult();
        return $oAlunoAtividade;
    }
	
	public function selectHistorico($Aluno, $Atividade) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Aluno' => $Aluno, 'o.Atividade' => $Atividade), $qb);
        $query = $qb->select('o')
            ->from('AlunoAtividade', 'o')
            ->where( $where );
        $oAlunoAtividade = $query->getQuery()->getOneOrNullResult();
        return $oAlunoAtividade;
    }

    public function delLogical($Aluno, $Atividade, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Aluno' => $Aluno, 'o.Atividade' => $Atividade), $qb);
        $query = $qb->update("AlunoAtividade o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Aluno, $Atividade);
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

    public function delPhysical($Aluno, $Atividade, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Aluno' => $Aluno, 'o.Atividade' => $Atividade), $qb);
        $query = $qb->delete()->from("AlunoAtividade", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Aluno, $Atividade);
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

    protected function delTransaction($Aluno, $Atividade){
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
        return 'Atividade do Aluno';
    }

    public static function getTableName(){
        return 'aluno_atividade';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'AlunoAtividade';
    }
    
    public static function getBaseUrl() {
        return URL . AlunoAtividadeAction::getModuleName(). "/AlunoAtividade/";
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
        $aValidateFields = array('id_aluno' => 'Aluno', 'id_atividade' => 'Atividade', 'arquivo' => 'arquivo', 'nome' => 'nome', 'tipo' => 'tipo', 'score' => 'score');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AlunoAtividade();
        $o->setAluno((isset($v['Aluno']) ? $this->em->find("Aluno",array( 'id' => $v['Aluno'])) : NULL));
        $o->setAtividade((isset($v['Atividade']) ? $this->em->find("Atividade",array( 'id' => $v['Atividade'])) : NULL));
        $o->setArquivo((isset($v['arquivo']) ? $v['arquivo'] : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setTipo((isset($v['tipo']) ? $v['tipo'] : NULL));
        $o->setScore((isset($v['score']) ? $v['score'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['Aluno'] = (($o->getAluno()) ? AlunoAction::toArray($o->getAluno()) : NULL);
        $v['Atividade'] = (($o->getAtividade()) ? AtividadeAction::toArray($o->getAtividade()) : NULL);
        $v['arquivo'] = $o->getArquivo();
        $v['nome'] = $o->getNome();
        $v['tipo'] = $o->getTipo();
        $v['score'] = $o->getScore();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['Aluno'] = "id_aluno";
	$conditions = preg_replace('~^Aluno$~',"id_aluno",$conditions);
	$aFields['Atividade'] = "id_atividade";
	$conditions = preg_replace('~^Atividade$~',"id_atividade",$conditions);
	$aFields['arquivo'] = "arquivo";
	$conditions = preg_replace('~^arquivo$~',"arquivo",$conditions);
	$aFields['nome'] = "nome";
	$conditions = preg_replace('~^nome$~',"nome",$conditions);
	$aFields['tipo'] = "tipo";
	$conditions = preg_replace('~^tipo$~',"tipo",$conditions);
	$aFields['score'] = "score";
	$conditions = preg_replace('~^score$~',"score",$conditions);
        if(!$conditions){
            return $aFields;
        }
        return $conditions;
    }
	
	public static function getKeys($tipo = null) {
        # F- FieldName || A- AttributeName
        @$aKeys = array('o.Aluno' => $Aluno, 'o.Atividade' => $Atividade); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = AlunoAtividadeAction::transformaColunas($attr);
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
        	$aFields['Aluno'] = array("suggest","titulo");
	$aFields['Atividade'] = array("suggest","titulo");
	$aFields['arquivo'] = "str";
	$aFields['nome'] = "str";
	$aFields['tipo'] = "str";
	$aFields['score'] = "str";
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
        if($request->get('score')) {
            $conditions[] = "{$alias}.score LIKE '%" . ($request->get('score') ) . "%'";
            $orderPageConditions .= "&score={$request->get('score')}";
            $response->set('score',  $request->get("score"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AlunoAtividadeAction();
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
        $aFields = AlunoAtividadeAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>