<?php
require dirname(__FILE__) . '/../doctrine/Entities/Permissao.php';
class PermissaoActionParent {

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
		$aFieldsStructure = PermissaoAction::getFieldsStructure(); # estrutura da tabela
	
        
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oPermissao = new Permissao();
        $oPermissao->setPerfil(QueryHelper::verifyObject($Perfil, 'Perfil', $this->em));
	$oPermissao->setModulo(QueryHelper::verifyObject($Modulo, 'Modulo', $this->em));
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oPermissao);
            $this->em->flush($oPermissao);
            $this->addTransaction($oPermissao, $request);
            
			
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
            return $oPermissao;
        }
        return true;
    }

    protected function addTransaction($oPermissao, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oPermissao = $this->em->find('Permissao',array('Perfil' => $Perfil, 'Modulo' => $Modulo));
        

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oPermissao);
            $this->em->flush($oPermissao);
            $this->editTransaction($oPermissao, $request);
            
			
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
            return $oPermissao;
        }
        return true;
    }

    protected function editTransaction($oPermissao, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Permissao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(PermissaoAction::manualOrder($query, $order) === FALSE){
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
                }if($order == 'Modulo') {
                    $query->leftJoin('o.Modulo', 'u');
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
            ->from('Permissao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(PermissaoAction::manualOrder($query, $order) === FALSE){
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
                }if($order == 'Modulo') {
                    $query->leftJoin('o.Modulo', 'u');
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
            ->from('Permissao', 'o');
        
        
		if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $aTotal = $query->getQuery()->execute();
        return $aTotal[0][1];
    }

    public function select($Perfil, $Modulo, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */
		$queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.Modulo' => $Modulo), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('Permissao', 'o')
            ->where( $where );
        
        $oPermissao = $query->getQuery()->getOneOrNullResult();
        return $oPermissao;
    }
	
	public function selectHistorico($Perfil, $Modulo) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.Modulo' => $Modulo), $qb);
        $query = $qb->select('o')
            ->from('Permissao', 'o')
            ->where( $where );
        $oPermissao = $query->getQuery()->getOneOrNullResult();
        return $oPermissao;
    }

    public function delLogical($Perfil, $Modulo, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.Modulo' => $Modulo), $qb);
        $query = $qb->update("Permissao o")
            //->set([nome_atributo], 0)
            ->where( $where )->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Perfil, $Modulo);
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

    public function delPhysical($Perfil, $Modulo, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Perfil' => $Perfil, 'o.Modulo' => $Modulo), $qb);
        $query = $qb->delete()->from("Permissao", "o")
                ->where( $where )->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($Perfil, $Modulo);
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

    protected function delTransaction($Perfil, $Modulo){
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
        return 'Permissão';
    }

    public static function getTableName(){
        return 'permissao';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'Permissao';
    }
    
    public static function getBaseUrl() {
        return URL . PermissaoAction::getModuleName(). "/Permissao/";
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
        $aValidateFields = array('id_perfil' => 'Perfil', 'id_modulo' => 'Modulo');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Permissao();
        $o->setPerfil((isset($v['Perfil']) ? $this->em->find("Perfil",array( 'id' => $v['Perfil'])) : NULL));
        $o->setModulo((isset($v['Modulo']) ? $this->em->find("Modulo",array( 'id' => $v['Modulo'])) : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['Perfil'] = (($o->getPerfil()) ? PerfilAction::toArray($o->getPerfil()) : NULL);
        $v['Modulo'] = (($o->getModulo()) ? ModuloAction::toArray($o->getModulo()) : NULL);
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['Perfil'] = "id_perfil";
	$conditions = preg_replace('~^Perfil$~',"id_perfil",$conditions);
	$aFields['Modulo'] = "id_modulo";
	$conditions = preg_replace('~^Modulo$~',"id_modulo",$conditions);
        if(!$conditions){
            return $aFields;
        }
        return $conditions;
    }
	
	public static function getKeys($tipo = null) {
        # F- FieldName || A- AttributeName
        @$aKeys = array('o.Perfil' => $Perfil, 'o.Modulo' => $Modulo); # @ pois poem as variaveis nao definidas e o importante é a chave
        $aCamposId = array_keys($aKeys);
        $aRet = array();
        foreach ($aCamposId as $o) {
            $attr = str_replace("o.", "", $o);
            $aRet["A"][] = $attr;
            $aRet["F"][] = PermissaoAction::transformaColunas($attr);
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
	$aFields['Modulo'] = array("obj","id");
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

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new PermissaoAction();
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
        $aFields = PermissaoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>