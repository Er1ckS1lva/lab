<?php
require dirname(__FILE__) . '/../doctrine/Entities/Atividade.php';
class AtividadeActionParent {

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
		$aFieldsStructure = AtividadeAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Tema") == '') {
            throw new Exception("Por favor, informe o campo Tema!");
        }


if(isset($aFieldsStructure["Tema"]) && !isset($aFieldsStructure["Tema"]["isFk"]) && $aFieldsStructure["Tema"]["length"]){
    if (strlen($request->get("Tema")) > $aFieldsStructure["Tema"]["length"]) {
        $this->setMsg("Por favor, informe o campo Tema corretamente, o tamanho do campo é {$aFieldsStructure["Tema"]["length"]}!");
        return false;
    }
}
	if ($request->get("titulo") == '') {
            throw new Exception("Por favor, informe o campo Título!");
        }


if(isset($aFieldsStructure["titulo"]) && !isset($aFieldsStructure["titulo"]["isFk"]) && $aFieldsStructure["titulo"]["length"]){
    if (strlen($request->get("titulo")) > $aFieldsStructure["titulo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Título corretamente, o tamanho do campo é {$aFieldsStructure["titulo"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividade = new Atividade();
        $oAtividade->setTema(QueryHelper::verifyObject($Tema, 'Tema', $this->em));
	$oAtividade->setTitulo($titulo);
	$oAtividade->setDescricao($descricao);
	$oAtividade->setTipo($tipo);
	$oAtividade->setLogDel("N");
	$oAtividade->setOrdem($ordem);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividade);
            $this->em->flush($oAtividade);
            $this->addTransaction($oAtividade, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Atividade com o índice '{$oAtividade->getId()}'", FALSE);
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
            return $oAtividade;
        }
        return true;
    }

    protected function addTransaction($oAtividade, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividade = $this->em->find('Atividade',array('id' => $id));
        $oAtividade->setTema(QueryHelper::verifyObject($Tema, 'Tema', $this->em));
	$oAtividade->setTitulo($titulo);
	$oAtividade->setDescricao($descricao);
	$oAtividade->setTipo($tipo);
	$oAtividade->setOrdem($ordem);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividade);
            $this->em->flush($oAtividade);
            $this->editTransaction($oAtividade, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Atividade com o índice {$id}", FALSE);
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
            return $oAtividade;
        }
        return true;
    }

    protected function editTransaction($oAtividade, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Atividade', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $query->andWhere("o.logDel = 'N'");
        if(AtividadeAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Tema') {
                    $query->leftJoin('o.Tema', 'u');
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
            ->from('Atividade', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $query->andWhere("o.logDel = 'N'");
        if(AtividadeAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Tema') {
                    $query->leftJoin('o.Tema', 'u');
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
            ->from('Atividade', 'o');
        $query->andWhere("o.logDel = 'N'");
        
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
            ->from('Atividade', 'o')
            ->where( $where );
        $query->andWhere("o.logDel = 'N'");
        $oAtividade = $query->getQuery()->getOneOrNullResult();
        return $oAtividade;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Atividade', 'o')
            ->where( $where );
        $oAtividade = $query->getQuery()->getOneOrNullResult();
        return $oAtividade;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Atividade o")
            ->set('o.logDel', "'S'")
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
            $oLog->register("O", "Excluído Atividade com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("Atividade", "o")
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
            $oLog->register("O", "Excluído Atividade com o índice {$id}", FALSE);
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
        return 'Atividade';
    }

    public static function getTableName(){
        return 'atividade';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'Atividade';
    }
    
    public static function getBaseUrl() {
        return URL . AtividadeAction::getModuleName(). "/Atividade/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return $o->getTitulo();
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('id_tema' => 'Tema', 'titulo' => 'titulo', 'log_del' => 'logDel');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Atividade();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setTema((isset($v['Tema']) ? $this->em->find("Tema",array( 'id' => $v['Tema'])) : NULL));
        $o->setTitulo((isset($v['titulo']) ? $v['titulo'] : NULL));
        $o->setDescricao((isset($v['descricao']) ? $v['descricao'] : NULL));
        $o->setTipo((isset($v['tipo']) ? $v['tipo'] : NULL));
        $o->setLogDel((isset($v['logDel']) ? $v['logDel'] : NULL));
        $o->setOrdem((isset($v['ordem']) ? $v['ordem'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Tema'] = (($o->getTema()) ? TemaAction::toArray($o->getTema()) : NULL);
        $v['titulo'] = $o->getTitulo();
        $v['descricao'] = $o->getDescricao();
        $v['tipo'] = $o->getTipo();
        $v['logDel'] = $o->getLogDel();
        $v['ordem'] = $o->getOrdem();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['Tema'] = "id_tema";
	$conditions = preg_replace('~^Tema$~',"id_tema",$conditions);
	$aFields['titulo'] = "titulo";
	$conditions = preg_replace('~^titulo$~',"titulo",$conditions);
	$aFields['descricao'] = "descricao";
	$conditions = preg_replace('~^descricao$~',"descricao",$conditions);
	$aFields['tipo'] = "tipo";
	$conditions = preg_replace('~^tipo$~',"tipo",$conditions);
	$aFields['logDel'] = "log_del";
	$conditions = preg_replace('~^logDel$~',"log_del",$conditions);
	$aFields['ordem'] = "ordem";
	$conditions = preg_replace('~^ordem$~',"ordem",$conditions);
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
            $aRet["F"][] = AtividadeAction::transformaColunas($attr);
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
	$aFields['Tema'] = array("suggest","titulo");
	$aFields['titulo'] = "str";
	$aFields['descricao'] = "editor";
	$aFields['tipo'] = "sim/nao";
	$aFields['logDel'] = "log_del";
	$aFields['ordem'] = "int";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForTipo($v) {
        switch($v){
	case 'RPT': 
		$value = 'Escuta e repetição dos diálogos';
	break;
	case 'PRC': 
		$value = 'Preenchimento de balões em branco';
	break;
	case 'VID': 
		$value = 'Vídeo com explicação';
	break;
	case 'PRN': 
		$value = 'Exercício de pronúncias';
	break;
	case 'MUL': 
		$value = 'Conteúdo multimídia (textual, auditivo ou audiovisual)';
	break;
	case 'EMO': 
		$value = 'Detecção da Emoção';
	break;
	case 'EMI': 
		$value = 'Análise de Emoção(Imagem)';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForTipo() {
        return array('RPT' => 'Escuta e repetição dos diálogos', 'PRC' => 'Preenchimento de balões em branco', 'VID' => 'Vídeo com explicação', 'PRN' => 'Exercício de pronúncias', 'MUL' => 'Conteúdo multimídia (textual, auditivo ou audiovisual)', 'EMO' => 'Detecção da Emoção', 'EMI' => 'Análise de Emoção(Imagem)');
    }

    public static function getComboBoxForTipo($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'tipo') {
        $valores = self::getValuesForTipo();
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

    public static function getRadioButtonForTipo($v = NULL, $tabindex = "", $event = "", $name = 'tipo') {
        $valores = self::getValuesForTipo();
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
        
        if($request->get('Tema')) {
            $conditions[] = "{$alias}.Tema = " . $request->get('Tema')  . "";
            $orderPageConditions .= "&Tema={$request->get('Tema')}";
            $response->set('Tema',  $request->get("Tema"));
        }
        if($request->get('TemaSuggest')) {
            $conditions[] = $response->get('TemaSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&TemaSuggest={$request->get('TemaSuggest')}";
            $response->set('TemaSuggest',  $request->get("TemaSuggest"));
        }
        if($request->get('titulo')) {
            $conditions[] = "{$alias}.titulo LIKE '%" . ($request->get('titulo') ) . "%'";
            $orderPageConditions .= "&titulo={$request->get('titulo')}";
            $response->set('titulo',  $request->get("titulo"));
        }
        if($request->get('tipo')) {
            $conditions[] = "{$alias}.tipo = '" . $request->get('tipo')  . "'";
            $orderPageConditions .= "&tipo={$request->get('tipo')}";
            $response->set('tipo',  $request->get("tipo"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AtividadeAction();
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
        $aFields = AtividadeAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>