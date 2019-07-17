<?php
require dirname(__FILE__) . '/../doctrine/Entities/BibliotecaObraArte.php';
class BibliotecaObraArteActionParent {

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
		$aFieldsStructure = BibliotecaObraArteAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("titulo") == '') {
            throw new Exception("Por favor, informe o campo Título!");
        }


if(isset($aFieldsStructure["titulo"]) && !isset($aFieldsStructure["titulo"]["isFk"]) && $aFieldsStructure["titulo"]["length"]){
    if (strlen($request->get("titulo")) > $aFieldsStructure["titulo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Título corretamente, o tamanho do campo é {$aFieldsStructure["titulo"]["length"]}!");
        return false;
    }
}
	if ($request->get("palavraChaveMusica") == '') {
            throw new Exception("Por favor, informe o campo Palavra chave!");
        }


if(isset($aFieldsStructure["palavraChaveMusica"]) && !isset($aFieldsStructure["palavraChaveMusica"]["isFk"]) && $aFieldsStructure["palavraChaveMusica"]["length"]){
    if (strlen($request->get("palavraChaveMusica")) > $aFieldsStructure["palavraChaveMusica"]["length"]) {
        $this->setMsg("Por favor, informe o campo Palavra chave corretamente, o tamanho do campo é {$aFieldsStructure["palavraChaveMusica"]["length"]}!");
        return false;
    }
}
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oBibliotecaObraArte = new BibliotecaObraArte();
        $oBibliotecaObraArte->setTitulo($titulo);
	$oBibliotecaObraArte->setNomeArtista($nomeArtista);
	$oBibliotecaObraArte->setEstiloArte($estiloArte);
	$oBibliotecaObraArte->setAno($ano);
	$oBibliotecaObraArte->setFonte($fonte);
	$oBibliotecaObraArte->setPalavraChaveMusica($palavraChaveMusica);
	$oBibliotecaObraArte->setArquivo($arquivo);
	$oBibliotecaObraArte->setArquivoName($arquivoName);
	$oBibliotecaObraArte->setArquivoType($arquivoType);
	$oBibliotecaObraArte->setArquivoSize($arquivoSize);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oBibliotecaObraArte);
            $this->em->flush($oBibliotecaObraArte);
            $this->addTransaction($oBibliotecaObraArte, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Obra de arte com o índice '{$oBibliotecaObraArte->getId()}'", FALSE);
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
            return $oBibliotecaObraArte;
        }
        return true;
    }

    protected function addTransaction($oBibliotecaObraArte, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oBibliotecaObraArte = $this->em->find('BibliotecaObraArte',array('id' => $id));
        $oBibliotecaObraArte->setTitulo($titulo);
	$oBibliotecaObraArte->setNomeArtista($nomeArtista);
	$oBibliotecaObraArte->setEstiloArte($estiloArte);
	$oBibliotecaObraArte->setAno($ano);
	$oBibliotecaObraArte->setFonte($fonte);
	$oBibliotecaObraArte->setPalavraChaveMusica($palavraChaveMusica);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oBibliotecaObraArte);
            $this->em->flush($oBibliotecaObraArte);
            $this->editTransaction($oBibliotecaObraArte, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Obra de arte com o índice {$id}", FALSE);
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
            return $oBibliotecaObraArte;
        }
        return true;
    }

    protected function editTransaction($oBibliotecaObraArte, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('BibliotecaObraArte', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(BibliotecaObraArteAction::manualOrder($query, $order) === FALSE){
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
            ->from('BibliotecaObraArte', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(BibliotecaObraArteAction::manualOrder($query, $order) === FALSE){
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
            ->from('BibliotecaObraArte', 'o');
        
        
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
            ->from('BibliotecaObraArte', 'o')
            ->where( $where );
        
        $oBibliotecaObraArte = $query->getQuery()->getOneOrNullResult();
        return $oBibliotecaObraArte;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('BibliotecaObraArte', 'o')
            ->where( $where );
        $oBibliotecaObraArte = $query->getQuery()->getOneOrNullResult();
        return $oBibliotecaObraArte;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("BibliotecaObraArte o")
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
            $oLog->register("O", "Excluído Obra de arte com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("BibliotecaObraArte", "o")
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
            $oLog->register("O", "Excluído Obra de arte com o índice {$id}", FALSE);
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
        return 'Obra de arte';
    }

    public static function getTableName(){
        return 'biblioteca_obra_arte';
    }

    public static function getModuleName() {
        return 'biblioteca';
    }
    
    public static function getClassName() {
        return 'BibliotecaObraArte';
    }
    
    public static function getBaseUrl() {
        return URL . BibliotecaObraArteAction::getModuleName(). "/BibliotecaObraArte/";
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
        $aValidateFields = array('titulo' => 'titulo', 'palavra_chave' => 'palavraChaveMusica');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new BibliotecaObraArte();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setTitulo((isset($v['titulo']) ? $v['titulo'] : NULL));
        $o->setNomeArtista((isset($v['nomeArtista']) ? $v['nomeArtista'] : NULL));
        $o->setEstiloArte((isset($v['estiloArte']) ? $v['estiloArte'] : NULL));
        $o->setAno((isset($v['ano']) ? $v['ano'] : NULL));
        $o->setFonte((isset($v['fonte']) ? $v['fonte'] : NULL));
        $o->setPalavraChaveMusica((isset($v['palavraChaveMusica']) ? $v['palavraChaveMusica'] : NULL));
        $o->setArquivo((isset($v['arquivo']) ? $v['arquivo'] : NULL));
        $o->setArquivoName((isset($v['arquivoName']) ? $v['arquivoName'] : NULL));
        $o->setArquivoType((isset($v['arquivoType']) ? $v['arquivoType'] : NULL));
        $o->setArquivoSize((isset($v['arquivoSize']) ? $v['arquivoSize'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['titulo'] = $o->getTitulo();
        $v['nomeArtista'] = $o->getNomeArtista();
        $v['estiloArte'] = $o->getEstiloArte();
        $v['ano'] = $o->getAno();
        $v['fonte'] = $o->getFonte();
        $v['palavraChaveMusica'] = $o->getPalavraChaveMusica();
        $v['arquivo'] = $o->getArquivo();
        $v['arquivoName'] = $o->getArquivoName();
        $v['arquivoType'] = $o->getArquivoType();
        $v['arquivoSize'] = $o->getArquivoSize();
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
	$aFields['nomeArtista'] = "nome_artista";
	$conditions = preg_replace('~^nomeArtista$~',"nome_artista",$conditions);
	$aFields['estiloArte'] = "estilo_arte";
	$conditions = preg_replace('~^estiloArte$~',"estilo_arte",$conditions);
	$aFields['ano'] = "ano";
	$conditions = preg_replace('~^ano$~',"ano",$conditions);
	$aFields['fonte'] = "fonte";
	$conditions = preg_replace('~^fonte$~',"fonte",$conditions);
	$aFields['palavraChaveMusica'] = "palavra_chave";
	$conditions = preg_replace('~^palavraChaveMusica$~',"palavra_chave",$conditions);
	$aFields['arquivo'] = "arquivo";
	$conditions = preg_replace('~^arquivo$~',"arquivo",$conditions);
	$aFields['arquivoName'] = "arquivo_name";
	$conditions = preg_replace('~^arquivoName$~',"arquivo_name",$conditions);
	$aFields['arquivoType'] = "arquivo_type";
	$conditions = preg_replace('~^arquivoType$~',"arquivo_type",$conditions);
	$aFields['arquivoSize'] = "arquivo_size";
	$conditions = preg_replace('~^arquivoSize$~',"arquivo_size",$conditions);
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
            $aRet["F"][] = BibliotecaObraArteAction::transformaColunas($attr);
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
	$aFields['nomeArtista'] = "str";
	$aFields['estiloArte'] = "str";
	$aFields['ano'] = "str";
	$aFields['fonte'] = "str";
	$aFields['palavraChaveMusica'] = "str";
	$aFields['arquivo'] = "str";
	$aFields['arquivoName'] = "str";
	$aFields['arquivoType'] = "str";
	$aFields['arquivoSize'] = "int";
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
        
        if($request->get('titulo')) {
            $conditions[] = "{$alias}.titulo LIKE '%" . ($request->get('titulo') ) . "%'";
            $orderPageConditions .= "&titulo={$request->get('titulo')}";
            $response->set('titulo',  $request->get("titulo"));
        }
        if($request->get('nomeArtista')) {
            $conditions[] = "{$alias}.nomeArtista LIKE '%" . ($request->get('nomeArtista') ) . "%'";
            $orderPageConditions .= "&nomeArtista={$request->get('nomeArtista')}";
            $response->set('nomeArtista',  $request->get("nomeArtista"));
        }
        if($request->get('estiloArte')) {
            $conditions[] = "{$alias}.estiloArte LIKE '%" . ($request->get('estiloArte') ) . "%'";
            $orderPageConditions .= "&estiloArte={$request->get('estiloArte')}";
            $response->set('estiloArte',  $request->get("estiloArte"));
        }
        if($request->get('ano')) {
            $conditions[] = "{$alias}.ano LIKE '%" . ($request->get('ano') ) . "%'";
            $orderPageConditions .= "&ano={$request->get('ano')}";
            $response->set('ano',  $request->get("ano"));
        }
        if($request->get('fonte')) {
            $conditions[] = "{$alias}.fonte LIKE '%" . ($request->get('fonte') ) . "%'";
            $orderPageConditions .= "&fonte={$request->get('fonte')}";
            $response->set('fonte',  $request->get("fonte"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new BibliotecaObraArteAction();
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
        $aFields = BibliotecaObraArteAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>