<?php
require dirname(__FILE__) . '/../doctrine/Entities/Tema.php';
class TemaActionParent {

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
		$aFieldsStructure = TemaAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Laboratorio") == '') {
            throw new Exception("Por favor, informe o campo Laboratório!");
        }


if(isset($aFieldsStructure["Laboratorio"]) && !isset($aFieldsStructure["Laboratorio"]["isFk"]) && $aFieldsStructure["Laboratorio"]["length"]){
    if (strlen($request->get("Laboratorio")) > $aFieldsStructure["Laboratorio"]["length"]) {
        $this->setMsg("Por favor, informe o campo Laboratório corretamente, o tamanho do campo é {$aFieldsStructure["Laboratorio"]["length"]}!");
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
	$imagemCapa = $request->get("imagemCapa");
        if(isset($imagemCapa['error']) && $imagemCapa['error'] != 4){
            if ($imagemCapa['error'] != 0 && $imagemCapa['size'] <= 0 && !$edicao){
                throw new Exception("Por favor, informe a Imagem de Capa!");
            }elseif($imagemCapa['error'] === 0 && $imagemCapa['size'] > 0){
                $filename = basename($imagemCapa['name']);
                $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $extensions = Util::recuperaExtensaoImagem();
                $mimes = Util::recuperaTipoImagem();
                $fileMaxSize = 2097152;
                if ($imagemCapa["size"] > $fileMaxSize) {
                }
                if (!in_array($ext, $extensions) || !in_array($imagemCapa['type'], $mimes)) {
                    throw new Exception("Atenção: Somente arquivos com a extensão " . join(', ', $extensions) . " são aceitos para upload!");
                }
            }
        }
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oTema = new Tema();
        $oTema->setLaboratorio(QueryHelper::verifyObject($Laboratorio, 'Laboratorio', $this->em));
	$oTema->setTitulo($titulo);
	$oTema->setDescricao($descricao);
	if (isset($imagemCapa['error']) && $imagemCapa['error'] == 0)$oTema->setImagemCapa($imagemCapa['name']);
	$oTema->setOrdem($ordem);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oTema);
            $this->em->flush($oTema);
            $this->addTransaction($oTema, $request);
            FileUtil::makeFileUpload('Tema/imagemCapa', $oTema->getId(), 'imagemCapa', false);
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Tema com o índice '{$oTema->getId()}'", FALSE);
            ## LOG END ##
			}
			
            if ($commitable) {
                $this->em->commit();
            }
        } catch(Exception $e) {
            FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Tema/imagemCapa', $oTema->getId());

            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        if($returnObject === true){
            return $oTema;
        }
        return true;
    }

    protected function addTransaction($oTema, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oTema = $this->em->find('Tema',array('id' => $id));
        $oTema->setLaboratorio(QueryHelper::verifyObject($Laboratorio, 'Laboratorio', $this->em));
	$oTema->setTitulo($titulo);
	$oTema->setDescricao($descricao);
	if (isset($imagemCapa['error']) && $imagemCapa['error'] == 0) $oTema->setImagemCapa($imagemCapa['name']);
	$oTema->setOrdem($ordem);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oTema);
            $this->em->flush($oTema);
            $this->editTransaction($oTema, $request);
            FileUtil::makeFileUpload('Tema/imagemCapa', $id, 'imagemCapa', true);
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Tema com o índice {$id}", FALSE);
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
            return $oTema;
        }
        return true;
    }

    protected function editTransaction($oTema, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Tema', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(TemaAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
                if($order == 'Laboratorio') {
                    $query->leftJoin('o.Laboratorio', 'u');
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
            ->from('Tema', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(TemaAction::manualOrder($query, $order) === FALSE){
            if($order) {
                if(strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE){
                    list($order,$orderType) = explode(" ", $order, 2);
                }else{
                    $orderType = "ASC";
                }
                $entityPrefix = "o";
if($order == 'Laboratorio') {
                    $query->leftJoin('o.Laboratorio', 'u');
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
            ->from('Tema', 'o');
        
        
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
            ->from('Tema', 'o')
            ->where( $where );
        
        $oTema = $query->getQuery()->getOneOrNullResult();
        return $oTema;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Tema', 'o')
            ->where( $where );
        $oTema = $query->getQuery()->getOneOrNullResult();
        return $oTema;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Tema o")
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
            $oLog->register("O", "Excluído Tema com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("Tema", "o")
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
            $oLog->register("O", "Excluído Tema com o índice {$id}", FALSE);
            ## LOG END ##
			}

            FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Tema/imagemCapa', $id);

            
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
                FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Tema/imagemCapa', $id);

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
                FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Tema/imagemCapa', $id);

            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public static function getEntityName(){
        return 'Tema';
    }

    public static function getTableName(){
        return 'tema';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }
    
    public static function getClassName() {
        return 'Tema';
    }
    
    public static function getBaseUrl() {
        return URL . TemaAction::getModuleName(). "/Tema/";
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
        $aValidateFields = array('id_laboratorio' => 'Laboratorio', 'titulo' => 'titulo');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Tema();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setLaboratorio((isset($v['Laboratorio']) ? $this->em->find("Laboratorio",array( 'id' => $v['Laboratorio'])) : NULL));
        $o->setTitulo((isset($v['titulo']) ? $v['titulo'] : NULL));
        $o->setDescricao((isset($v['descricao']) ? $v['descricao'] : NULL));
        $o->setImagemCapa((isset($v['imagemCapa']) ? $v['imagemCapa'] : NULL));
        $o->setOrdem((isset($v['ordem']) ? $v['ordem'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Laboratorio'] = (($o->getLaboratorio()) ? LaboratorioAction::toArray($o->getLaboratorio()) : NULL);
        $v['titulo'] = $o->getTitulo();
        $v['descricao'] = $o->getDescricao();
        $v['imagemCapa'] = $o->getImagemCapa();
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
	$aFields['Laboratorio'] = "id_laboratorio";
	$conditions = preg_replace('~^Laboratorio$~',"id_laboratorio",$conditions);
	$aFields['titulo'] = "titulo";
	$conditions = preg_replace('~^titulo$~',"titulo",$conditions);
	$aFields['descricao'] = "descricao";
	$conditions = preg_replace('~^descricao$~',"descricao",$conditions);
	$aFields['imagemCapa'] = "imagem_capa";
	$conditions = preg_replace('~^imagemCapa$~',"imagem_capa",$conditions);
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
            $aRet["F"][] = TemaAction::transformaColunas($attr);
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
	$aFields['Laboratorio'] = array("suggest","titulo");
	$aFields['titulo'] = "str";
	$aFields['descricao'] = "editor";
	$aFields['imagemCapa'] = "file";
	$aFields['ordem'] = "int";
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
        
        if($request->get('Laboratorio')) {
            $conditions[] = "{$alias}.Laboratorio = " . $request->get('Laboratorio')  . "";
            $orderPageConditions .= "&Laboratorio={$request->get('Laboratorio')}";
            $response->set('Laboratorio',  $request->get("Laboratorio"));
        }
        if($request->get('LaboratorioSuggest')) {
            $conditions[] = $response->get('LaboratorioSuggestSQL'); // sql do campo mas ainda é necessário alterar o manualOrder e fazer join com a tabela
            $orderPageConditions .= "&LaboratorioSuggest={$request->get('LaboratorioSuggest')}";
            $response->set('LaboratorioSuggest',  $request->get("LaboratorioSuggest"));
        }
        if($request->get('titulo')) {
            $conditions[] = "{$alias}.titulo LIKE '%" . ($request->get('titulo') ) . "%'";
            $orderPageConditions .= "&titulo={$request->get('titulo')}";
            $response->set('titulo',  $request->get("titulo"));
        }
        if($request->get('ordem')) {
            $conditions[] = "{$alias}.ordem = '" . $request->get('ordem')  . "'";
            $orderPageConditions .= "&ordem={$request->get('ordem')}";
            $response->set('ordem',  $request->get("ordem"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new TemaAction();
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
        $aFields = TemaAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>