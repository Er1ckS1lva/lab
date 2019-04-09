<?php
require dirname(__FILE__) . '/../doctrine/Entities/PerfilModuloMenu.php';
class PerfilModuloMenuActionParent {

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
		$aFieldsStructure = PerfilModuloMenuAction::getFieldsStructure(); # estrutura da tabela
	
        
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oPerfilModuloMenu = new PerfilModuloMenu();
        $oPerfilModuloMenu->setPerfil(QueryHelper::verifyObject($Perfil, 'Perfil', $this->em));
	$oPerfilModuloMenu->setModuloMenu(QueryHelper::verifyObject($ModuloMenu, 'ModuloMenu', $this->em));
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oPerfilModuloMenu);
            $this->em->flush($oPerfilModuloMenu);
            $this->addTransaction($oPerfilModuloMenu, $request);
            
			
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
            return $oPerfilModuloMenu;
        }
        return true;
    }

    protected function addTransaction($oPerfilModuloMenu, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oPerfilModuloMenu = $this->em->find('PerfilModuloMenu',array('Perfil' => $Perfil, 'ModuloMenu' => $ModuloMenu));
        

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oPerfilModuloMenu);
            $this->em->flush($oPerfilModuloMenu);
            $this->editTransaction($oPerfilModuloMenu, $request);
            
			
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
            return $oPerfilModuloMenu;
        }
        return true;
    }

    protected function editTransaction($oPerfilModuloMenu, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('PerfilModuloMenu', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(PerfilModuloMenuAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Perfil') {
                    $query->leftJoin('o.Perfil', 'u');
                    $entityPrefix = "u";
                    $order = 'nome';
                }if($order == 'ModuloMenu') {
                    $query->leftJoin('o.ModuloMenu', 'u');
                    $entityPrefix = "u";
                    $order = 'descricao';
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
            ->from('PerfilModuloMenu', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(PerfilModuloMenuAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Perfil') {
                    $query->leftJoin('o.Perfil', 'u');
                    $entityPrefix = "u";
                    $order = 'nome';
                }if($order == 'ModuloMenu') {
                    $query->leftJoin('o.ModuloMenu', 'u');
                    $entityPrefix = "u";
                    $order = 'descricao';
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
            ->from('PerfilModuloMenu', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($Perfil, $ModuloMenu, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.ModuloMenu' => $ModuloMenu), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('PerfilModuloMenu', 'o')
            ->where( $where );
        
        $oPerfilModuloMenu = $query->getQuery()->getOneOrNullResult();
        return $oPerfilModuloMenu;
    }
	
	public function selectHistorico($Perfil, $ModuloMenu) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.ModuloMenu' => $ModuloMenu), $qb);
        $query = $qb->select('o')
            ->from('PerfilModuloMenu', 'o')
            ->where( $where );
        $oPerfilModuloMenu = $query->getQuery()->getOneOrNullResult();
        return $oPerfilModuloMenu;
    }

    public function delLogical($Perfil, $ModuloMenu, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.ModuloMenu' => $ModuloMenu), $qb);
        $query = $qb->update("PerfilModuloMenu o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Perfil, $ModuloMenu);
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

    public function delPhysical($Perfil, $ModuloMenu, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.ModuloMenu' => $ModuloMenu), $qb);
        $query = $qb->delete()->from("PerfilModuloMenu", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Perfil, $ModuloMenu);
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

    protected function delTransaction($Perfil, $ModuloMenu){
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
        return 'Modulo do Menu Perfil';
    }

    public static function getTableName(){
        return 'perfil_modulo_menu';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'PerfilModuloMenu';
    }
    
    public static function getBaseUrl() {
        return URL . PerfilModuloMenuAction::getModuleName(). "/PerfilModuloMenu/";
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
        $aValidateFields = array('id_perfil' => 'Perfil', 'id_modulo_menu' => 'ModuloMenu');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new PerfilModuloMenu();
        $o->setPerfil((isset($v['Perfil']) ? $this->em->find("Perfil",array( 'id' => $v['Perfil'])) : NULL));
        $o->setModuloMenu((isset($v['ModuloMenu']) ? $this->em->find("ModuloMenu",array( 'id' => $v['ModuloMenu'])) : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['Perfil'] = (($o->getPerfil()) ? PerfilAction::toArray($o->getPerfil()) : NULL);
        $v['ModuloMenu'] = (($o->getModuloMenu()) ? ModuloMenuAction::toArray($o->getModuloMenu()) : NULL);
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['Perfil'] = "id_perfil";
	$conditions = preg_replace('~^Perfil$~',"id_perfil",$conditions);
	$aFields['ModuloMenu'] = "id_modulo_menu";
	$conditions = preg_replace('~^ModuloMenu$~',"id_modulo_menu",$conditions);
        if(!$conditions){
            return $aFields;
        }
        return $conditions;
    }
	
	public static function getKeys($tipo = null) {
        # F- FieldName || A- AttributeName
        @$aKeys = array('o.Perfil' => $Perfil, 'o.ModuloMenu' => $ModuloMenu); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = PerfilModuloMenuAction::transformaColunas($attr);
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
        	$aFields['Perfil'] = array("obj","nome");
	$aFields['ModuloMenu'] = array("obj","descricao");
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
        
        if($request->get('Perfil')) {
            $conditions[] = "{$alias}.Perfil = " . $request->get('Perfil')  . "";
            $orderPageConditions .= "&Perfil={$request->get('Perfil')}";
            $response->set('Perfil',  $request->get("Perfil"));
        }
        if($request->get('PerfilSuggest')) {
            $conditions[] = $response->get('PerfilSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&PerfilSuggest={$request->get('PerfilSuggest')}";
            $response->set('PerfilSuggest',  $request->get("PerfilSuggest"));
        }
        if($request->get('ModuloMenu')) {
            $conditions[] = "{$alias}.ModuloMenu = " . $request->get('ModuloMenu')  . "";
            $orderPageConditions .= "&ModuloMenu={$request->get('ModuloMenu')}";
            $response->set('ModuloMenu',  $request->get("ModuloMenu"));
        }
        if($request->get('ModuloMenuSuggest')) {
            $conditions[] = $response->get('ModuloMenuSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&ModuloMenuSuggest={$request->get('ModuloMenuSuggest')}";
            $response->set('ModuloMenuSuggest',  $request->get("ModuloMenuSuggest"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new PerfilModuloMenuAction();
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
        $aFields = PerfilModuloMenuAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>