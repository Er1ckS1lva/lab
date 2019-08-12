<?php
require dirname(__FILE__) . '/../doctrine/Entities/BibliotecaImagem.php';
class BibliotecaImagemActionParent {

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
		$aFieldsStructure = BibliotecaImagemAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("tipo") == '') {
            throw new Exception("Por favor, informe o campo Tipo!");
        }


if(isset($aFieldsStructure["tipo"]) && !isset($aFieldsStructure["tipo"]["isFk"]) && $aFieldsStructure["tipo"]["length"]){
    if (strlen($request->get("tipo")) > $aFieldsStructure["tipo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Tipo corretamente, o tamanho do campo é {$aFieldsStructure["tipo"]["length"]}!");
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
        
        $oBibliotecaImagem = new BibliotecaImagem();
        $oBibliotecaImagem->setTipo($tipo);
	$oBibliotecaImagem->setTitulo($titulo);
	$oBibliotecaImagem->setNome($nome);
	$oBibliotecaImagem->setEstilo($estilo);
	$oBibliotecaImagem->setAno($ano);
	$oBibliotecaImagem->setFonte($fonte);
	$oBibliotecaImagem->setPalavraChaveMusica($palavraChaveMusica);
	$oBibliotecaImagem->setArquivo($arquivo);
	$oBibliotecaImagem->setArquivoName($arquivoName);
	$oBibliotecaImagem->setArquivoType($arquivoType);
	$oBibliotecaImagem->setArquivoSize($arquivoSize);
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oBibliotecaImagem);
            $this->em->flush($oBibliotecaImagem);
            $this->addTransaction($oBibliotecaImagem, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Imagem com o índice '{$oBibliotecaImagem->getId()}'", FALSE);
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
            return $oBibliotecaImagem;
        }
        return true;
    }

    protected function addTransaction($oBibliotecaImagem, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oBibliotecaImagem = $this->em->find('BibliotecaImagem',array('id' => $id));
        $oBibliotecaImagem->setTitulo($titulo);
	$oBibliotecaImagem->setNome($nome);
	$oBibliotecaImagem->setEstilo($estilo);
	$oBibliotecaImagem->setAno($ano);
	$oBibliotecaImagem->setFonte($fonte);
	$oBibliotecaImagem->setPalavraChaveMusica($palavraChaveMusica);
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oBibliotecaImagem);
            $this->em->flush($oBibliotecaImagem);
            $this->editTransaction($oBibliotecaImagem, $request);
            
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Imagem com o índice {$id}", FALSE);
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
            return $oBibliotecaImagem;
        }
        return true;
    }

    protected function editTransaction($oBibliotecaImagem, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('BibliotecaImagem', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(BibliotecaImagemAction::manualOrder($query, $order) === FALSE){
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
            ->from('BibliotecaImagem', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(BibliotecaImagemAction::manualOrder($query, $order) === FALSE){
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
            ->from('BibliotecaImagem', 'o');
        
        
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
            ->from('BibliotecaImagem', 'o')
            ->where( $where );
        
        $oBibliotecaImagem = $query->getQuery()->getOneOrNullResult();
        return $oBibliotecaImagem;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('BibliotecaImagem', 'o')
            ->where( $where );
        $oBibliotecaImagem = $query->getQuery()->getOneOrNullResult();
        return $oBibliotecaImagem;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("BibliotecaImagem o")
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
            $oLog->register("O", "Excluído Imagem com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("BibliotecaImagem", "o")
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
            $oLog->register("O", "Excluído Imagem com o índice {$id}", FALSE);
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
        return 'Imagem';
    }

    public static function getTableName(){
        return 'biblioteca_imagem';
    }

    public static function getModuleName() {
        return 'biblioteca';
    }
    
    public static function getClassName() {
        return 'BibliotecaImagem';
    }
    
    public static function getBaseUrl() {
        return URL . BibliotecaImagemAction::getModuleName(). "/BibliotecaImagem/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return $o->getTipo();
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('tipo' => 'tipo', 'titulo' => 'titulo', 'palavra_chave' => 'palavraChaveMusica');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new BibliotecaImagem();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setTipo((isset($v['tipo']) ? $v['tipo'] : NULL));
        $o->setTitulo((isset($v['titulo']) ? $v['titulo'] : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setEstilo((isset($v['estilo']) ? $v['estilo'] : NULL));
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
        $v['tipo'] = $o->getTipo();
        $v['titulo'] = $o->getTitulo();
        $v['nome'] = $o->getNome();
        $v['estilo'] = $o->getEstilo();
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
	$aFields['tipo'] = "tipo";
	$conditions = preg_replace('~^tipo$~',"tipo",$conditions);
	$aFields['titulo'] = "titulo";
	$conditions = preg_replace('~^titulo$~',"titulo",$conditions);
	$aFields['nome'] = "nome";
	$conditions = preg_replace('~^nome$~',"nome",$conditions);
	$aFields['estilo'] = "estilo";
	$conditions = preg_replace('~^estilo$~',"estilo",$conditions);
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
            $aRet["F"][] = BibliotecaImagemAction::transformaColunas($attr);
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
	$aFields['tipo'] = "sim/nao";
	$aFields['titulo'] = "str";
	$aFields['nome'] = "str";
	$aFields['estilo'] = "str";
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
	
    

    
        public static function getValueForTipo($v) {
        switch($v){
	case 'FOT': 
		$value = 'Fotografia';
	break;
	case 'GRA': 
		$value = 'Gravura';
	break;
	case 'DES': 
		$value = 'Desenho';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForTipo() {
        return array('FOT' => 'Fotografia', 'GRA' => 'Gravura', 'DES' => 'Desenho');
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
        
        if($request->get('titulo')) {
            $conditions[] = "{$alias}.titulo LIKE '%" . ($request->get('titulo') ) . "%'";
            $orderPageConditions .= "&titulo={$request->get('titulo')}";
            $response->set('titulo',  $request->get("titulo"));
        }
        if($request->get('nome')) {
            $conditions[] = "{$alias}.nome LIKE '%" . ($request->get('nome') ) . "%'";
            $orderPageConditions .= "&nome={$request->get('nome')}";
            $response->set('nome',  $request->get("nome"));
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
        $oAction = new BibliotecaImagemAction();
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
        $aFields = BibliotecaImagemAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>