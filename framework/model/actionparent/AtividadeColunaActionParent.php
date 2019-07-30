<?php
require dirname(__FILE__) . '/../doctrine/Entities/AtividadeColuna.php';
class AtividadeColunaActionParent {

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
		$aFieldsStructure = AtividadeColunaAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Idioma") == '') {
            throw new Exception("Por favor, informe o campo Idioma!");
        }


if(isset($aFieldsStructure["Idioma"]) && !isset($aFieldsStructure["Idioma"]["isFk"]) && $aFieldsStructure["Idioma"]["length"]){
    if (strlen($request->get("Idioma")) > $aFieldsStructure["Idioma"]["length"]) {
        $this->setMsg("Por favor, informe o campo Idioma corretamente, o tamanho do campo é {$aFieldsStructure["Idioma"]["length"]}!");
        return false;
    }
}
	if ($request->get("Atividade") == '') {
            throw new Exception("Por favor, informe o campo Atividade!");
        }


if(isset($aFieldsStructure["Atividade"]) && !isset($aFieldsStructure["Atividade"]["isFk"]) && $aFieldsStructure["Atividade"]["length"]){
    if (strlen($request->get("Atividade")) > $aFieldsStructure["Atividade"]["length"]) {
        $this->setMsg("Por favor, informe o campo Atividade corretamente, o tamanho do campo é {$aFieldsStructure["Atividade"]["length"]}!");
        return false;
    }
}
	if ($request->get("coluna1") == '') {
            throw new Exception("Por favor, informe o campo Coluna1!");
        }


if(isset($aFieldsStructure["coluna1"]) && !isset($aFieldsStructure["coluna1"]["isFk"]) && $aFieldsStructure["coluna1"]["length"]){
    if (strlen($request->get("coluna1")) > $aFieldsStructure["coluna1"]["length"]) {
        $this->setMsg("Por favor, informe o campo Coluna1 corretamente, o tamanho do campo é {$aFieldsStructure["coluna1"]["length"]}!");
        return false;
    }
}
	if ($request->get("coluna2") == '') {
            throw new Exception("Por favor, informe o campo Coluna2!");
        }


if(isset($aFieldsStructure["coluna2"]) && !isset($aFieldsStructure["coluna2"]["isFk"]) && $aFieldsStructure["coluna2"]["length"]){
    if (strlen($request->get("coluna2")) > $aFieldsStructure["coluna2"]["length"]) {
        $this->setMsg("Por favor, informe o campo Coluna2 corretamente, o tamanho do campo é {$aFieldsStructure["coluna2"]["length"]}!");
        return false;
    }
}
	if ($request->get("tipo1") == '') {
            throw new Exception("Por favor, informe o campo Tipo1!");
        }


if(isset($aFieldsStructure["tipo1"]) && !isset($aFieldsStructure["tipo1"]["isFk"]) && $aFieldsStructure["tipo1"]["length"]){
    if (strlen($request->get("tipo1")) > $aFieldsStructure["tipo1"]["length"]) {
        $this->setMsg("Por favor, informe o campo Tipo1 corretamente, o tamanho do campo é {$aFieldsStructure["tipo1"]["length"]}!");
        return false;
    }
}
	if ($request->get("tipo2") == '') {
            throw new Exception("Por favor, informe o campo Tipo2!");
        }


if(isset($aFieldsStructure["tipo2"]) && !isset($aFieldsStructure["tipo2"]["isFk"]) && $aFieldsStructure["tipo2"]["length"]){
    if (strlen($request->get("tipo2")) > $aFieldsStructure["tipo2"]["length"]) {
        $this->setMsg("Por favor, informe o campo Tipo2 corretamente, o tamanho do campo é {$aFieldsStructure["tipo2"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividadeColuna = new AtividadeColuna();
        $oAtividadeColuna->setIdioma(QueryHelper::verifyObject($Idioma, 'Idioma', $this->em));
	$oAtividadeColuna->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	$oAtividadeColuna->setColuna1($coluna1);
	$oAtividadeColuna->setColuna2($coluna2);
	$oAtividadeColuna->setTipo1($tipo1);
	$oAtividadeColuna->setTipo2($tipo2);
	$oAtividadeColuna->setColuna1Text($coluna1Text);
	$oAtividadeColuna->setColuna2Text($coluna2Text);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeColuna);
            $this->em->flush($oAtividadeColuna);
            $this->addTransaction($oAtividadeColuna, $request);
            
			
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
            return $oAtividadeColuna;
        }
        return true;
    }

    protected function addTransaction($oAtividadeColuna, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oAtividadeColuna = $this->em->find('AtividadeColuna',array('id' => $id));
        $oAtividadeColuna->setIdioma(QueryHelper::verifyObject($Idioma, 'Idioma', $this->em));
	$oAtividadeColuna->setAtividade(QueryHelper::verifyObject($Atividade, 'Atividade', $this->em));
	$oAtividadeColuna->setColuna1($coluna1);
	$oAtividadeColuna->setColuna2($coluna2);
	$oAtividadeColuna->setTipo1($tipo1);
	$oAtividadeColuna->setTipo2($tipo2);
	$oAtividadeColuna->setColuna1Text($coluna1Text);
	$oAtividadeColuna->setColuna2Text($coluna2Text);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAtividadeColuna);
            $this->em->flush($oAtividadeColuna);
            $this->editTransaction($oAtividadeColuna, $request);
            
			
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
            return $oAtividadeColuna;
        }
        return true;
    }

    protected function editTransaction($oAtividadeColuna, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('AtividadeColuna', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeColunaAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Idioma') {
                    $query->leftJoin('o.Idioma', 'u');
                    $entityPrefix = "u";
                    $order = 'titulo';
                }if($order == 'Atividade') {
                    $query->leftJoin('o.Atividade', 'u');
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
            ->from('AtividadeColuna', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(AtividadeColunaAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Idioma') {
                    $query->leftJoin('o.Idioma', 'u');
                    $entityPrefix = "u";
                    $order = 'titulo';
                }if($order == 'Atividade') {
                    $query->leftJoin('o.Atividade', 'u');
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
            ->from('AtividadeColuna', 'o');
        
        
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
            ->from('AtividadeColuna', 'o')
            ->where( $where );
        
        $oAtividadeColuna = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeColuna;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('AtividadeColuna', 'o')
            ->where( $where );
        $oAtividadeColuna = $query->getQuery()->getOneOrNullResult();
        return $oAtividadeColuna;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("AtividadeColuna o")
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
        $query = $qb->delete()->from("AtividadeColuna", "o")
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
        return 'Atividade de Coluna';
    }

    public static function getTableName(){
        return 'atividade_coluna';
    }

    public static function getModuleName() {
        return '';
    }
    
    public static function getClassName() {
        return 'AtividadeColuna';
    }
    
    public static function getBaseUrl() {
        return URL . AtividadeColunaAction::getModuleName(). "/AtividadeColuna/";
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
        $aValidateFields = array('id_idioma' => 'Idioma', 'id_atividade' => 'Atividade', 'coluna1' => 'coluna1', 'coluna2' => 'coluna2', 'tipo1' => 'tipo1', 'tipo2' => 'tipo2');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new AtividadeColuna();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setIdioma((isset($v['Idioma']) ? $this->em->find("Idioma",array( 'id' => $v['Idioma'])) : NULL));
        $o->setAtividade((isset($v['Atividade']) ? $this->em->find("Atividade",array( 'id' => $v['Atividade'])) : NULL));
        $o->setColuna1((isset($v['coluna1']) ? $v['coluna1'] : NULL));
        $o->setColuna2((isset($v['coluna2']) ? $v['coluna2'] : NULL));
        $o->setTipo1((isset($v['tipo1']) ? $v['tipo1'] : NULL));
        $o->setTipo2((isset($v['tipo2']) ? $v['tipo2'] : NULL));
        $o->setColuna1Text((isset($v['coluna1Text']) ? $v['coluna1Text'] : NULL));
        $o->setColuna2Text((isset($v['coluna2Text']) ? $v['coluna2Text'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Idioma'] = (($o->getIdioma()) ? IdiomaAction::toArray($o->getIdioma()) : NULL);
        $v['Atividade'] = (($o->getAtividade()) ? AtividadeAction::toArray($o->getAtividade()) : NULL);
        $v['coluna1'] = $o->getColuna1();
        $v['coluna2'] = $o->getColuna2();
        $v['tipo1'] = $o->getTipo1();
        $v['tipo2'] = $o->getTipo2();
        $v['coluna1Text'] = $o->getColuna1Text();
        $v['coluna2Text'] = $o->getColuna2Text();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['Idioma'] = "id_idioma";
	$conditions = preg_replace('~^Idioma$~',"id_idioma",$conditions);
	$aFields['Atividade'] = "id_atividade";
	$conditions = preg_replace('~^Atividade$~',"id_atividade",$conditions);
	$aFields['coluna1'] = "coluna1";
	$conditions = preg_replace('~^coluna1$~',"coluna1",$conditions);
	$aFields['coluna2'] = "coluna2";
	$conditions = preg_replace('~^coluna2$~',"coluna2",$conditions);
	$aFields['tipo1'] = "tipo1";
	$conditions = preg_replace('~^tipo1$~',"tipo1",$conditions);
	$aFields['tipo2'] = "tipo2";
	$conditions = preg_replace('~^tipo2$~',"tipo2",$conditions);
	$aFields['coluna1Text'] = "coluna1Text";
	$conditions = preg_replace('~^coluna1Text$~',"coluna1Text",$conditions);
	$aFields['coluna2Text'] = "coluna2Text";
	$conditions = preg_replace('~^coluna2Text$~',"coluna2Text",$conditions);
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
            $aRet["F"][] = AtividadeColunaAction::transformaColunas($attr);
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
	$aFields['Idioma'] = array("suggest","titulo");
	$aFields['Atividade'] = array("suggest","id");
	$aFields['coluna1'] = "int";
	$aFields['coluna2'] = "int";
	$aFields['tipo1'] = "sim/nao";
	$aFields['tipo2'] = "sim/nao";
	$aFields['coluna1Text'] = "memo";
	$aFields['coluna2Text'] = "memo";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForTipo1($v) {
        switch($v){
	case 'TEX': 
		$value = 'Texto';
	break;
	case 'IMG': 
		$value = 'Imagem';
	break;
	case 'VID': 
		$value = 'Vídeo';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForTipo1() {
        return array('TEX' => 'Texto', 'IMG' => 'Imagem', 'VID' => 'Vídeo');
    }

    public static function getComboBoxForTipo1($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'tipo1') {
        $valores = self::getValuesForTipo1();
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

    public static function getRadioButtonForTipo1($v = NULL, $tabindex = "", $event = "", $name = 'tipo1') {
        $valores = self::getValuesForTipo1();
        $radio = "";
        foreach($valores as $key => $value){
            $checked = '';
            if( ($v) == ($key) ) $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='".$name."' name='".$name."' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }

    public static function getValueForTipo2($v) {
        switch($v){
	case 'TEX': 
		$value = 'Texto';
	break;
	case 'IMG': 
		$value = 'Imagem';
	break;
	case 'VID': 
		$value = 'Vídeo';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForTipo2() {
        return array('TEX' => 'Texto', 'IMG' => 'Imagem', 'VID' => 'Vídeo');
    }

    public static function getComboBoxForTipo2($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'tipo2') {
        $valores = self::getValuesForTipo2();
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

    public static function getRadioButtonForTipo2($v = NULL, $tabindex = "", $event = "", $name = 'tipo2') {
        $valores = self::getValuesForTipo2();
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
        if($request->get('coluna1')) {
            $conditions[] = "{$alias}.coluna1 = '" . $request->get('coluna1')  . "'";
            $orderPageConditions .= "&coluna1={$request->get('coluna1')}";
            $response->set('coluna1',  $request->get("coluna1"));
        }
        if($request->get('coluna2')) {
            $conditions[] = "{$alias}.coluna2 = '" . $request->get('coluna2')  . "'";
            $orderPageConditions .= "&coluna2={$request->get('coluna2')}";
            $response->set('coluna2',  $request->get("coluna2"));
        }
        if($request->get('tipo1')) {
            $conditions[] = "{$alias}.tipo1 = '" . $request->get('tipo1')  . "'";
            $orderPageConditions .= "&tipo1={$request->get('tipo1')}";
            $response->set('tipo1',  $request->get("tipo1"));
        }
        if($request->get('tipo2')) {
            $conditions[] = "{$alias}.tipo2 = '" . $request->get('tipo2')  . "'";
            $orderPageConditions .= "&tipo2={$request->get('tipo2')}";
            $response->set('tipo2',  $request->get("tipo2"));
        }
        if($request->get('coluna1Text')) {
            $conditions[] = "{$alias}.coluna1Text LIKE '%" . ($request->get('coluna1Text') ) . "%'";
            $orderPageConditions .= "&coluna1Text={$request->get('coluna1Text')}";
            $response->set('coluna1Text',  $request->get("coluna1Text"));
        }
        if($request->get('coluna2Text')) {
            $conditions[] = "{$alias}.coluna2Text LIKE '%" . ($request->get('coluna2Text') ) . "%'";
            $orderPageConditions .= "&coluna2Text={$request->get('coluna2Text')}";
            $response->set('coluna2Text',  $request->get("coluna2Text"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AtividadeColunaAction();
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
        $aFields = AtividadeColunaAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>