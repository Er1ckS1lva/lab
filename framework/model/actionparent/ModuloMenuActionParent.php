<?php
require dirname(__FILE__) . '/../doctrine/Entities/ModuloMenu.php';
class ModuloMenuActionParent {

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
		$aFieldsStructure = ModuloMenuAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("nome") == '') {
            throw new Exception("Por favor, informe o campo Nome!");
        }


if(isset($aFieldsStructure["nome"]) && !isset($aFieldsStructure["nome"]["isFk"]) && $aFieldsStructure["nome"]["length"]){
    if (strlen($request->get("nome")) > $aFieldsStructure["nome"]["length"]) {
        $this->setMsg("Por favor, informe o campo Nome corretamente, o tamanho do campo é {$aFieldsStructure["nome"]["length"]}!");
        return false;
    }
}
        if (!Validate::validateCampoUnico("ModuloMenu", array('o.nome' => "'{$request->get('nome')}'"), array('o.id' => $request->get('id')), $this->em,$edicao)){
            throw new Exception("Já existe um registro cadastrado com o valor: [Nome: {$request->get('nome')}]");
        }

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oModuloMenu = new ModuloMenu();
        $oModuloMenu->setNome($nome);
	$oModuloMenu->setDescricao($descricao);
	$oModuloMenu->setClass($class);
	$oModuloMenu->setIcon($icon);
	$oModuloMenu->setOrdem($ordem);
	$oModuloMenu->setLogUsuario(UtilAuth::recuperaLoginUsuario($this->em));
	$oModuloMenu->setLogDel("N");
	$oModuloMenu->setLogData(new DateTime('now'));
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oModuloMenu);
            $this->em->flush($oModuloMenu);
            $this->addTransaction($oModuloMenu, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Menu do Modulo com o índice '{$oModuloMenu->getId()}'", FALSE);
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
            return $oModuloMenu;
        }
        return true;
    }

    protected function addTransaction($oModuloMenu, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oModuloMenu = $this->em->find('ModuloMenu',array('id' => $id));
        $oModuloMenu->setNome($nome);
	$oModuloMenu->setDescricao($descricao);
	$oModuloMenu->setClass($class);
	$oModuloMenu->setIcon($icon);
	$oModuloMenu->setOrdem($ordem);
	$oModuloMenu->setLogUsuario(UtilAuth::recuperaLoginUsuario($this->em));
	$oModuloMenu->setLogData(new DateTime('now'));
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oModuloMenu);
            $this->em->flush($oModuloMenu);
            $this->editTransaction($oModuloMenu, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Menu do Modulo com o índice {$id}", FALSE);
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
            return $oModuloMenu;
        }
        return true;
    }

    protected function editTransaction($oModuloMenu, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('ModuloMenu', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $query->andWhere("o.logDel = 'N'");
        if(ModuloMenuAction::manualOrder($query, $order) === FALSE){
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
            ->from('ModuloMenu', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $query->andWhere("o.logDel = 'N'");
        if(ModuloMenuAction::manualOrder($query, $order) === FALSE){
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
            ->from('ModuloMenu', 'o');
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
            ->from('ModuloMenu', 'o')
            ->where( $where );
        $query->andWhere("o.logDel = 'N'");
        $oModuloMenu = $query->getQuery()->getOneOrNullResult();
        return $oModuloMenu;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('ModuloMenu', 'o')
            ->where( $where );
        $oModuloMenu = $query->getQuery()->getOneOrNullResult();
        return $oModuloMenu;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("ModuloMenu o")
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
            $oLog->register("O", "Excluído Menu do Modulo com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("ModuloMenu", "o")
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
            $oLog->register("O", "Excluído Menu do Modulo com o índice {$id}", FALSE);
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
        return 'Menu do Modulo';
    }

    public static function getTableName(){
        return 'modulo_menu';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'ModuloMenu';
    }
    
    public static function getBaseUrl() {
        return URL . ModuloMenuAction::getModuleName(). "/ModuloMenu/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return $o->getNome();
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('nome' => 'nome', 'log_del' => 'logDel');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new ModuloMenu();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setDescricao((isset($v['descricao']) ? $v['descricao'] : NULL));
        $o->setClass((isset($v['class']) ? $v['class'] : NULL));
        $o->setIcon((isset($v['icon']) ? $v['icon'] : NULL));
        $o->setOrdem((isset($v['ordem']) ? $v['ordem'] : NULL));
        $o->setLogUsuario((isset($v['logUsuario']) ? $v['logUsuario'] : NULL));
        $o->setLogDel((isset($v['logDel']) ? $v['logDel'] : NULL));
        $o->setLogData((isset($v['logData']) ? $v['logData'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['nome'] = $o->getNome();
        $v['descricao'] = $o->getDescricao();
        $v['class'] = $o->getClass();
        $v['icon'] = $o->getIcon();
        $v['ordem'] = $o->getOrdem();
        $v['logUsuario'] = $o->getLogUsuario();
        $v['logDel'] = $o->getLogDel();
        $v['logData'] = $o->getLogData();
        return $v;
    }

    public function getAdmFields(){
        return null;
    }

	public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        	$aFields['id'] = "id";
	$conditions = preg_replace('~^id$~',"id",$conditions);
	$aFields['nome'] = "nome";
	$conditions = preg_replace('~^nome$~',"nome",$conditions);
	$aFields['descricao'] = "descricao";
	$conditions = preg_replace('~^descricao$~',"descricao",$conditions);
	$aFields['class'] = "class";
	$conditions = preg_replace('~^class$~',"class",$conditions);
	$aFields['icon'] = "icon";
	$conditions = preg_replace('~^icon$~',"icon",$conditions);
	$aFields['ordem'] = "ordem";
	$conditions = preg_replace('~^ordem$~',"ordem",$conditions);
	$aFields['logUsuario'] = "log_usuario";
	$conditions = preg_replace('~^logUsuario$~',"log_usuario",$conditions);
	$aFields['logDel'] = "log_del";
	$conditions = preg_replace('~^logDel$~',"log_del",$conditions);
	$aFields['logData'] = "log_data";
	$conditions = preg_replace('~^logData$~',"log_data",$conditions);
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
            $aRet["F"][] = ModuloMenuAction::transformaColunas($attr);
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
	$aFields['nome'] = "str";
	$aFields['descricao'] = "str";
	$aFields['class'] = "str";
	$aFields['icon'] = "str";
	$aFields['ordem'] = "int";
	$aFields['logUsuario'] = "log_usuario";
	$aFields['logDel'] = "log_del";
	$aFields['logData'] = "log_data";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
        public function selectByNome($nome, $fieldsToSelect = null) {
		/* @var $query \Doctrine\ORM\QueryBuilder */
		
        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.nome' => "'$nome'"), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('ModuloMenu', 'o')
            ->where( $where );
        $query->andWhere("o.logDel = 'N'");
        $oModuloMenu = $query->getQuery()->getOneOrNullResult();
        return $oModuloMenu;
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
        
        if($request->get('nome')) {
            $conditions[] = "{$alias}.nome LIKE '%" . ($request->get('nome') ) . "%'";
            $orderPageConditions .= "&nome={$request->get('nome')}";
            $response->set('nome',  $request->get("nome"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new ModuloMenuAction();
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
        $aFields = ModuloMenuAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>