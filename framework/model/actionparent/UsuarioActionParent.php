<?php
require dirname(__FILE__) . '/../doctrine/Entities/Usuario.php';
class UsuarioActionParent {

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
		$aFieldsStructure = UsuarioAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("Perfil") == '') {
            throw new Exception("Por favor, informe o campo Perfil!");
        }


if(isset($aFieldsStructure["Perfil"]) && !isset($aFieldsStructure["Perfil"]["isFk"]) && $aFieldsStructure["Perfil"]["length"]){
    if (strlen($request->get("Perfil")) > $aFieldsStructure["Perfil"]["length"]) {
        $this->setMsg("Por favor, informe o campo Perfil corretamente, o tamanho do campo é {$aFieldsStructure["Perfil"]["length"]}!");
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
	if ($request->get("login") == '') {
            throw new Exception("Por favor, informe o campo Login!");
        }


if(isset($aFieldsStructure["login"]) && !isset($aFieldsStructure["login"]["isFk"]) && $aFieldsStructure["login"]["length"]){
    if (strlen($request->get("login")) > $aFieldsStructure["login"]["length"]) {
        $this->setMsg("Por favor, informe o campo Login corretamente, o tamanho do campo é {$aFieldsStructure["login"]["length"]}!");
        return false;
    }
}
	if ($request->get("email") == '') {
            throw new Exception("Por favor, informe o campo E-mail!");
        }


if(isset($aFieldsStructure["email"]) && !isset($aFieldsStructure["email"]["isFk"]) && $aFieldsStructure["email"]["length"]){
    if (strlen($request->get("email")) > $aFieldsStructure["email"]["length"]) {
        $this->setMsg("Por favor, informe o campo E-mail corretamente, o tamanho do campo é {$aFieldsStructure["email"]["length"]}!");
        return false;
    }
}
	$foto = $request->get("foto");
        if(isset($foto['error']) && $foto['error'] != 4){
            if ($foto['error'] != 0 && $foto['size'] <= 0 && !$edicao){
                throw new Exception("Por favor, informe a Foto!");
            }elseif($foto['error'] === 0 && $foto['size'] > 0){
                $filename = basename($foto['name']);
                $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $extensions = Util::recuperaExtensaoImagem();
                $mimes = Util::recuperaTipoImagem();
                $fileMaxSize = 2097152;
                if ($foto["size"] > $fileMaxSize) {
                }
                if (!in_array($ext, $extensions) || !in_array($foto['type'], $mimes)) {
                    throw new Exception("Atenção: Somente arquivos com a extensão " . join(', ', $extensions) . " são aceitos para upload!");
                }
            }
        }
	if ($request->get("ativo") == '') {
            throw new Exception("Por favor, informe o campo Ativo!");
        }


if(isset($aFieldsStructure["ativo"]) && !isset($aFieldsStructure["ativo"]["isFk"]) && $aFieldsStructure["ativo"]["length"]){
    if (strlen($request->get("ativo")) > $aFieldsStructure["ativo"]["length"]) {
        $this->setMsg("Por favor, informe o campo Ativo corretamente, o tamanho do campo é {$aFieldsStructure["ativo"]["length"]}!");
        return false;
    }
}
	if ($request->get("dataInicio") == '') {
            throw new Exception("Por favor, informe o campo Data de Início!");
        }


if(isset($aFieldsStructure["dataInicio"]) && !isset($aFieldsStructure["dataInicio"]["isFk"]) && $aFieldsStructure["dataInicio"]["length"]){
    if (strlen($request->get("dataInicio")) > $aFieldsStructure["dataInicio"]["length"]) {
        $this->setMsg("Por favor, informe o campo Data de Início corretamente, o tamanho do campo é {$aFieldsStructure["dataInicio"]["length"]}!");
        return false;
    }
}
	if ($request->get("dataInicio")){
            if (!Validate::validateDate($request->get("dataInicio"))){
                throw new Exception("Formato inválido do campo Data de Início!");
            }else{ 
		$request->set('dataInicio', Util::transformaData($request->get('dataInicio'), 'normal2mysql'));
	    }
        }


        if (!Validate::validateCampoUnico("Usuario", array('o.login' => "'{$request->get('login')}'"), array('o.id' => $request->get('id')), $this->em,$edicao)){
            throw new Exception("Já existe um registro cadastrado com o valor: [Login: {$request->get('login')}]");
        }
		if (!Validate::validateCampoUnico("Usuario", array('o.email' => "'{$request->get('email')}'"), array('o.id' => $request->get('id')), $this->em,$edicao)){
            throw new Exception("Já existe um registro cadastrado com o valor: [E-mail: {$request->get('email')}]");
        }
	if($request->get('dataFinal')) {
		$request->set('dataFinal', Util::transformaData($request->get('dataFinal'), 'normal2mysql'));
	}
        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oUsuario = new Usuario();
        $oUsuario->setPerfil(QueryHelper::verifyObject($Perfil, 'Perfil', $this->em));
	$oUsuario->setNome($nome);
	$oUsuario->setLogin($login);
	$oUsuario->setSenha($senha);
	$oUsuario->setEmail($email);
	$oUsuario->setSuperuser($superuser);
	if (isset($foto['error']) && $foto['error'] == 0)$oUsuario->setFoto($foto['name']);
	$oUsuario->setAtivo($ativo);
	$oUsuario->setRecuperaSenhaData(isset($recuperaSenhaData) ? new DateTime($recuperaSenhaData) : NULL);
	$oUsuario->setRecuperaSenhaHash($recuperaSenhaHash);
	$oUsuario->setDataInicio(isset($dataInicio) ? new DateTime($dataInicio) : NULL);
	$oUsuario->setDataFinal(isset($dataFinal) ? new DateTime($dataFinal) : NULL);
	$oUsuario->setLogUsuario(UtilAuth::recuperaLoginUsuario($this->em));
	$oUsuario->setLogDel("N");
	$oUsuario->setLogData(new DateTime('now'));
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oUsuario);
            $this->em->flush($oUsuario);
            $this->addTransaction($oUsuario, $request);
            FileUtil::makeFileUpload('Usuario/foto', $oUsuario->getId(), 'foto', false);
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Usuário com o índice '{$oUsuario->getId()}'", FALSE);
            ## LOG END ##
			}
			
            if ($commitable) {
                $this->em->commit();
            }
        } catch(Exception $e) {
            FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Usuario/foto', $oUsuario->getId());

            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        if($returnObject === true){
            return $oUsuario;
        }
        return true;
    }

    protected function addTransaction($oUsuario, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oUsuario = $this->em->find('Usuario',array('id' => $id));
        $oUsuario->setPerfil(QueryHelper::verifyObject($Perfil, 'Perfil', $this->em));
	$oUsuario->setNome($nome);
	$oUsuario->setLogin($login);
	$oUsuario->setEmail($email);
	if (isset($foto['error']) && $foto['error'] == 0) $oUsuario->setFoto($foto['name']);
	$oUsuario->setAtivo($ativo);
	$oUsuario->setDataInicio(isset($dataInicio) ? new DateTime($dataInicio) : NULL);
	$oUsuario->setDataFinal(isset($dataFinal) ? new DateTime($dataFinal) : NULL);
	$oUsuario->setLogUsuario(UtilAuth::recuperaLoginUsuario($this->em));
	$oUsuario->setLogData(new DateTime('now'));
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oUsuario);
            $this->em->flush($oUsuario);
            $this->editTransaction($oUsuario, $request);
            FileUtil::makeFileUpload('Usuario/foto', $id, 'foto', true);
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Usuário com o índice {$id}", FALSE);
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
            return $oUsuario;
        }
        return true;
    }

    protected function editTransaction($oUsuario, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Usuario', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $query->andWhere("o.logDel = 'N'");
        if(UsuarioAction::manualOrder($query, $order) === FALSE){
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
            ->from('Usuario', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        $query->andWhere("o.logDel = 'N'");
        if(UsuarioAction::manualOrder($query, $order) === FALSE){
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
            ->from('Usuario', 'o');
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
            ->from('Usuario', 'o')
            ->where( $where );
        $query->andWhere("o.logDel = 'N'");
        $oUsuario = $query->getQuery()->getOneOrNullResult();
        return $oUsuario;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Usuario', 'o')
            ->where( $where );
        $oUsuario = $query->getQuery()->getOneOrNullResult();
        return $oUsuario;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Usuario o")
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
            $oLog->register("O", "Excluído Usuário com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("Usuario", "o")
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
            $oLog->register("O", "Excluído Usuário com o índice {$id}", FALSE);
            ## LOG END ##
			}

            FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Usuario/foto', $id);

            
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
                FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Usuario/foto', $id);

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
                FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Usuario/foto', $id);

            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public static function getEntityName(){
        return 'Usuário';
    }

    public static function getTableName(){
        return 'usuario';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'Usuario';
    }
    
    public static function getBaseUrl() {
        return URL . UsuarioAction::getModuleName(). "/Usuario/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return $o->getLogin();
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('id_perfil' => 'Perfil', 'nome' => 'nome', 'login' => 'login', 'email' => 'email', 'ativo' => 'ativo', 'data_inicio' => 'dataInicio', 'log_del' => 'logDel');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Usuario();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setPerfil((isset($v['Perfil']) ? $this->em->find("Perfil",array( 'id' => $v['Perfil'])) : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setLogin((isset($v['login']) ? $v['login'] : NULL));
        $o->setSenha((isset($v['senha']) ? $v['senha'] : NULL));
        $o->setEmail((isset($v['email']) ? $v['email'] : NULL));
        $o->setSuperuser((isset($v['superuser']) ? $v['superuser'] : NULL));
        $o->setFoto((isset($v['foto']) ? $v['foto'] : NULL));
        $o->setAtivo((isset($v['ativo']) ? $v['ativo'] : NULL));
        $o->setRecuperaSenhaData((isset($v['recuperaSenhaData']) ? $v['recuperaSenhaData'] : NULL));
        $o->setRecuperaSenhaHash((isset($v['recuperaSenhaHash']) ? $v['recuperaSenhaHash'] : NULL));
        $o->setDataInicio((isset($v['dataInicio']) ? $v['dataInicio'] : NULL));
        $o->setDataFinal((isset($v['dataFinal']) ? $v['dataFinal'] : NULL));
        $o->setLogUsuario((isset($v['logUsuario']) ? $v['logUsuario'] : NULL));
        $o->setLogDel((isset($v['logDel']) ? $v['logDel'] : NULL));
        $o->setLogData((isset($v['logData']) ? $v['logData'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['Perfil'] = (($o->getPerfil()) ? PerfilAction::toArray($o->getPerfil()) : NULL);
        $v['nome'] = $o->getNome();
        $v['login'] = $o->getLogin();
        $v['senha'] = $o->getSenha();
        $v['email'] = $o->getEmail();
        $v['superuser'] = $o->getSuperuser();
        $v['foto'] = $o->getFoto();
        $v['ativo'] = $o->getAtivo();
        $v['recuperaSenhaData'] = $o->getRecuperaSenhaData();
        $v['recuperaSenhaHash'] = $o->getRecuperaSenhaHash();
        $v['dataInicio'] = $o->getDataInicio();
        $v['dataFinal'] = $o->getDataFinal();
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
	$aFields['Perfil'] = "id_perfil";
	$conditions = preg_replace('~^Perfil$~',"id_perfil",$conditions);
	$aFields['nome'] = "nome";
	$conditions = preg_replace('~^nome$~',"nome",$conditions);
	$aFields['login'] = "login";
	$conditions = preg_replace('~^login$~',"login",$conditions);
	$aFields['senha'] = "senha";
	$conditions = preg_replace('~^senha$~',"senha",$conditions);
	$aFields['email'] = "email";
	$conditions = preg_replace('~^email$~',"email",$conditions);
	$aFields['superuser'] = "superuser";
	$conditions = preg_replace('~^superuser$~',"superuser",$conditions);
	$aFields['foto'] = "foto";
	$conditions = preg_replace('~^foto$~',"foto",$conditions);
	$aFields['ativo'] = "ativo";
	$conditions = preg_replace('~^ativo$~',"ativo",$conditions);
	$aFields['recuperaSenhaData'] = "recupera_senha_data";
	$conditions = preg_replace('~^recuperaSenhaData$~',"recupera_senha_data",$conditions);
	$aFields['recuperaSenhaHash'] = "recuperar_senha_hash";
	$conditions = preg_replace('~^recuperaSenhaHash$~',"recuperar_senha_hash",$conditions);
	$aFields['dataInicio'] = "data_inicio";
	$conditions = preg_replace('~^dataInicio$~',"data_inicio",$conditions);
	$aFields['dataFinal'] = "data_final";
	$conditions = preg_replace('~^dataFinal$~',"data_final",$conditions);
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
            $aRet["F"][] = UsuarioAction::transformaColunas($attr);
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
	$aFields['Perfil'] = array("suggest","nome");
	$aFields['nome'] = "str";
	$aFields['login'] = "str";
	$aFields['senha'] = "str";
	$aFields['email'] = "str";
	$aFields['superuser'] = "sim/nao";
	$aFields['foto'] = "file";
	$aFields['ativo'] = "sim/nao";
	$aFields['recuperaSenhaData'] = "datetime";
	$aFields['recuperaSenhaHash'] = "str";
	$aFields['dataInicio'] = "date";
	$aFields['dataFinal'] = "date";
	$aFields['logUsuario'] = "log_usuario";
	$aFields['logDel'] = "log_del";
	$aFields['logData'] = "log_data";
        if($field){
            return $aFields[$field];
        }
        return $aFields;
    }
	
        public function selectByLogin($login, $fieldsToSelect = null) {
		/* @var $query \Doctrine\ORM\QueryBuilder */
		
        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.login' => "'$login'"), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('Usuario', 'o')
            ->where( $where );
        $query->andWhere("o.logDel = 'N'");
        $oUsuario = $query->getQuery()->getOneOrNullResult();
        return $oUsuario;
    }
    public function selectByEmail($email, $fieldsToSelect = null) {
		/* @var $query \Doctrine\ORM\QueryBuilder */
		
        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.email' => "'$email'"), $qb);
        $query = $qb->select($fieldsToSelect)
            ->from('Usuario', 'o')
            ->where( $where );
        $query->andWhere("o.logDel = 'N'");
        $oUsuario = $query->getQuery()->getOneOrNullResult();
        return $oUsuario;
    }

    
        public static function getValueForSuperuser($v) {
        switch($v){
	case 'S': 
		$value = 'Sim';
	break;
	case 'N': 
		$value = 'Não';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForSuperuser() {
        return array('S' => 'Sim', 'N' => 'Não');
    }

    public static function getComboBoxForSuperuser($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'superuser') {
        $valores = self::getValuesForSuperuser();
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

    public static function getRadioButtonForSuperuser($v = NULL, $tabindex = "", $event = "", $name = 'superuser') {
        $valores = self::getValuesForSuperuser();
        $radio = "";
        foreach($valores as $key => $value){
            $checked = '';
            if( ($v) == ($key) ) $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='".$name."' name='".$name."' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }

    public static function getValueForAtivo($v) {
        switch($v){
	case 'S': 
		$value = 'Ativo';
	break;
	case 'N': 
		$value = 'Inativo';
	break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }
    
    public static function getValuesForAtivo() {
        return array('S' => 'Ativo', 'N' => 'Inativo');
    }

    public static function getComboBoxForAtivo($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'ativo') {
        $valores = self::getValuesForAtivo();
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

    public static function getRadioButtonForAtivo($v = NULL, $tabindex = "", $event = "", $name = 'ativo') {
        $valores = self::getValuesForAtivo();
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
        if($request->get('nome')) {
            $conditions[] = "{$alias}.nome LIKE '%" . ($request->get('nome') ) . "%'";
            $orderPageConditions .= "&nome={$request->get('nome')}";
            $response->set('nome',  $request->get("nome"));
        }
        if($request->get('login')) {
            $conditions[] = "{$alias}.login LIKE '%" . ($request->get('login') ) . "%'";
            $orderPageConditions .= "&login={$request->get('login')}";
            $response->set('login',  $request->get("login"));
        }
        if($request->get('email')) {
            $conditions[] = "{$alias}.email LIKE '%" . ($request->get('email') ) . "%'";
            $orderPageConditions .= "&email={$request->get('email')}";
            $response->set('email',  $request->get("email"));
        }
        if($request->get('superuser')) {
            $conditions[] = "{$alias}.superuser = '" . $request->get('superuser')  . "'";
            $orderPageConditions .= "&superuser={$request->get('superuser')}";
            $response->set('superuser',  $request->get("superuser"));
        }
        if($request->get('ativo')) {
            $conditions[] = "{$alias}.ativo = '" . $request->get('ativo')  . "'";
            $orderPageConditions .= "&ativo={$request->get('ativo')}";
            $response->set('ativo',  $request->get("ativo"));
        }

        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new UsuarioAction();
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
        $aFields = UsuarioAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>