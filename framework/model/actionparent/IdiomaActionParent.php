<?php
require dirname(__FILE__) . '/../doctrine/Entities/Idioma.php';
class IdiomaActionParent {

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
		$aFieldsStructure = IdiomaAction::getFieldsStructure(); # estrutura da tabela
	
        
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oIdioma = new Idioma();
        $oIdioma->setTitulo($titulo);
	$oIdioma->setSigla($sigla);
	$oIdioma->setPadrao($padrao);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oIdioma);
            $this->em->flush($oIdioma);
            $this->addTransaction($oIdioma, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Idioma com o índice '{$oIdioma->getId()}'", FALSE);
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
            return $oIdioma;
        }
        return true;
    }

    protected function addTransaction($oIdioma, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oIdioma = $this->em->find('Idioma',array('id' => $id));
        $oIdioma->setTitulo($titulo);
	$oIdioma->setSigla($sigla);
	$oIdioma->setPadrao($padrao);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oIdioma);
            $this->em->flush($oIdioma);
            $this->editTransaction($oIdioma, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Idioma com o índice {$id}", FALSE);
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
            return $oIdioma;
        }
        return true;
    }

    protected function editTransaction($oIdioma, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Idioma', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(IdiomaAction::manualOrder($query, $order) === FALSE){
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
            ->from('Idioma', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(IdiomaAction::manualOrder($query, $order) === FALSE){
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
            ->from('Idioma', 'o');
        
        
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
            ->from('Idioma', 'o')
            ->where( $where );
        
        $oIdioma = $query->getQuery()->getOneOrNullResult();
        return $oIdioma;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Idioma', 'o')
            ->where( $where );
        $oIdioma = $query->getQuery()->getOneOrNullResult();
        return $oIdioma;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Idioma o")
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
            $oLog->register("O", "Excluído Idioma com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("Idioma", "o")
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
            $oLog->register("O", "Excluído Idioma com o índice {$id}", FALSE);
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
        return 'Idioma';
    }

    public static function getTableName(){
        return 'idioma';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'Idioma';
    }
    
    public static function getBaseUrl() {
        return URL . IdiomaAction::getModuleName(). "/Idioma/";
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
        $aValidateFields = array();
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Idioma();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setTitulo((isset($v['titulo']) ? $v['titulo'] : NULL));
        $o->setSigla((isset($v['sigla']) ? $v['sigla'] : NULL));
        $o->setPadrao((isset($v['padrao']) ? $v['padrao'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['titulo'] = $o->getTitulo();
        $v['sigla'] = $o->getSigla();
        $v['padrao'] = $o->getPadrao();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['titulo'] = "titulo";
	$conditions = preg_replace('~^titulo$~',"titulo",$conditions);
	$aFields['sigla'] = "sigla";
	$conditions = preg_replace('~^sigla$~',"sigla",$conditions);
	$aFields['padrao'] = "padrao";
	$conditions = preg_replace('~^padrao$~',"padrao",$conditions);
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
            $aRet["F"][] = IdiomaAction::transformaColunas($attr);
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
	$aFields['titulo'] = "str";
	$aFields['sigla'] = "str";
	$aFields['padrao'] = "sim/nao";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
    

    
        public static function getValueForPadrao($v) {
        switch($v){
	case '1': 
		$value = 'Sim';
	break;
	case '2': 
		$value = 'Não';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForPadrao() {
        return array('1' => 'Sim', '2' => 'Não');
    }

    public static function getComboBoxForPadrao($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'padrao') {
        $valores = self::getValuesForPadrao();
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

    public static function getRadioButtonForPadrao($v = NULL, $tabindex = "", $event = "", $name = 'padrao') {
        $valores = self::getValuesForPadrao();
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
        
        if($request->get('titulo')) {
            $conditions[] = "{$alias}.titulo LIKE '%" . ($request->get('titulo') ) . "%'";
            $orderPageConditions .= "&titulo={$request->get('titulo')}";
            $response->set('titulo',  $request->get("titulo"));
        }
        if($request->get('padrao')) {
            $conditions[] = "{$alias}.padrao = '" . $request->get('padrao')  . "'";
            $orderPageConditions .= "&padrao={$request->get('padrao')}";
            $response->set('padrao',  $request->get("padrao"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new IdiomaAction();
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
        $aFields = IdiomaAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>