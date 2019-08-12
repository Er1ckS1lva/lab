<?php
require dirname(__FILE__) . '/../doctrine/Entities/Configuracao.php';
class ConfiguracaoActionParent {

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
		$aFieldsStructure = ConfiguracaoAction::getFieldsStructure(); # estrutura da tabela
	
        if ($request->get("sistema") == '') {
            throw new Exception("Por favor, informe o campo Sistema!");
        }


if(isset($aFieldsStructure["sistema"]) && !isset($aFieldsStructure["sistema"]["isFk"]) && $aFieldsStructure["sistema"]["length"]){
    if (strlen($request->get("sistema")) > $aFieldsStructure["sistema"]["length"]) {
        $this->setMsg("Por favor, informe o campo Sistema corretamente, o tamanho do campo é {$aFieldsStructure["sistema"]["length"]}!");
        return false;
    }
}
	if ($request->get("empresa") == '') {
            throw new Exception("Por favor, informe o campo Empresa!");
        }


if(isset($aFieldsStructure["empresa"]) && !isset($aFieldsStructure["empresa"]["isFk"]) && $aFieldsStructure["empresa"]["length"]){
    if (strlen($request->get("empresa")) > $aFieldsStructure["empresa"]["length"]) {
        $this->setMsg("Por favor, informe o campo Empresa corretamente, o tamanho do campo é {$aFieldsStructure["empresa"]["length"]}!");
        return false;
    }
}
	$relatorioLogo = $request->get("relatorioLogo");
        if(isset($relatorioLogo['error']) && $relatorioLogo['error'] != 4){
            if ($relatorioLogo['error'] != 0 && $relatorioLogo['size'] <= 0 && !$edicao){
                throw new Exception("Por favor, informe a Logo do relatório!");
            }elseif($relatorioLogo['error'] === 0 && $relatorioLogo['size'] > 0){
                $filename = basename($relatorioLogo['name']);
                $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $extensions = Util::recuperaExtensaoImagem();
                $mimes = Util::recuperaTipoImagem();
                $fileMaxSize = Util::recuperaTamanhoImagem();
                if ($relatorioLogo["size"] > $fileMaxSize) {
                }
                if (!in_array($ext, $extensions) || !in_array($relatorioLogo['type'], $mimes)) {
                    throw new Exception("Atenção: Somente arquivos com a extensão " . join(', ', $extensions) . " são aceitos para upload!");
                }
            }
        }
        

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oConfiguracao = new Configuracao();
        $oConfiguracao->setSistema($sistema);
	$oConfiguracao->setEmpresa($empresa);
	$oConfiguracao->setEndereco($endereco);
	$oConfiguracao->setLink($link);
	$oConfiguracao->setTwitter($twitter);
	$oConfiguracao->setFacebook($facebook);
	$oConfiguracao->setEmail($email);
	$oConfiguracao->setTelefone($telefone);
	$oConfiguracao->setEmailContato($emailContato);
	$oConfiguracao->setTituloContato($tituloContato);
	if (isset($relatorioLogo['error']) && $relatorioLogo['error'] == 0)$oConfiguracao->setRelatorioLogo($relatorioLogo['name']);
	$oConfiguracao->setRelatorioCabecalho($relatorioCabecalho);
	$oConfiguracao->setLogUsuario(UtilAuth::recuperaLoginUsuario($this->em));
	$oConfiguracao->setLogData(new DateTime('now'));
	
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oConfiguracao);
            $this->em->flush($oConfiguracao);
            $this->addTransaction($oConfiguracao, $request);
            FileUtil::makeFileUpload('Configuracao/relatorioLogo', $oConfiguracao->getId(), 'relatorioLogo', false);
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Configuração com o índice '{$oConfiguracao->getId()}'", FALSE);
            ## LOG END ##
			}
			
            if ($commitable) {
                $this->em->commit();
            }
        } catch(Exception $e) {
            FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Configuracao/relatorioLogo', $oConfiguracao->getId());

            if ($commitable) {
                $this->em->rollback();
            }
            throw $e;
        }
        if($returnObject === true){
            return $oConfiguracao;
        }
        return true;
    }

    protected function addTransaction($oConfiguracao, $request){
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v) 
            $$i = $v;
        
        $oConfiguracao = $this->em->find('Configuracao',array('id' => $id));
        $oConfiguracao->setSistema($sistema);
	$oConfiguracao->setEmpresa($empresa);
	$oConfiguracao->setEndereco($endereco);
	$oConfiguracao->setLink($link);
	$oConfiguracao->setTwitter($twitter);
	$oConfiguracao->setFacebook($facebook);
	$oConfiguracao->setEmail($email);
	$oConfiguracao->setTelefone($telefone);
	$oConfiguracao->setEmailContato($emailContato);
	$oConfiguracao->setTituloContato($tituloContato);
	if (isset($relatorioLogo['error']) && $relatorioLogo['error'] == 0) $oConfiguracao->setRelatorioLogo($relatorioLogo['name']);
	$oConfiguracao->setRelatorioCabecalho($relatorioCabecalho);
	$oConfiguracao->setLogUsuario(UtilAuth::recuperaLoginUsuario($this->em));
	$oConfiguracao->setLogData(new DateTime('now'));
	

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oConfiguracao);
            $this->em->flush($oConfiguracao);
            $this->editTransaction($oConfiguracao, $request);
            FileUtil::makeFileUpload('Configuracao/relatorioLogo', $id, 'relatorioLogo', true);
			
			if($doLog){
				
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editado Configuração com o índice {$id}", FALSE);
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
            return $oConfiguracao;
        }
        return true;
    }

    protected function editTransaction($oConfiguracao, $request){
    }

    

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
            ->from('Configuracao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ConfiguracaoAction::manualOrder($query, $order) === FALSE){
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
            ->from('Configuracao', 'o');
		$query->distinct($distinct);

        if ($conditions) {
			$aConditions = is_array($conditions)?$conditions:array($conditions);			
			foreach ($aConditions as $condition) {
				$query->andWhere($condition);
            }
        }
		
        
        if(ConfiguracaoAction::manualOrder($query, $order) === FALSE){
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
            ->from('Configuracao', 'o');
        
        
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
            ->from('Configuracao', 'o')
            ->where( $where );
        
        $oConfiguracao = $query->getQuery()->getOneOrNullResult();
        return $oConfiguracao;
    }
	
	public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
            ->from('Configuracao', 'o')
            ->where( $where );
        $oConfiguracao = $query->getQuery()->getOneOrNullResult();
        return $oConfiguracao;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Configuracao o")
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
            $oLog->register("O", "Excluído Configuração com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("Configuracao", "o")
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
            $oLog->register("O", "Excluído Configuração com o índice {$id}", FALSE);
            ## LOG END ##
			}

            FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Configuracao/relatorioLogo', $id);

            
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
                FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Configuracao/relatorioLogo', $id);

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
                FileUtil::removeFile(dirname(__FILE__).'/../../../upload/Configuracao/relatorioLogo', $id);

            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public static function getEntityName(){
        return 'Configuração';
    }

    public static function getTableName(){
        return 'configuracao';
    }

    public static function getModuleName() {
        return 'seguranca';
    }
    
    public static function getClassName() {
        return 'Configuracao';
    }
    
    public static function getBaseUrl() {
        return URL . ConfiguracaoAction::getModuleName(). "/Configuracao/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }
	
    public static function suggestDesc($o){
        return $o->getSistema();
    }
	
    public static function suggestDescHtml($o){
        return NULL;
    }

    public static function validateFields(){
        $aValidateFields = array('sistema' => 'sistema', 'empresa' => 'empresa');
        return (join(",", $aValidateFields));
    }

    public function toObject($v){
        $o = new Configuracao();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setSistema((isset($v['sistema']) ? $v['sistema'] : NULL));
        $o->setEmpresa((isset($v['empresa']) ? $v['empresa'] : NULL));
        $o->setEndereco((isset($v['endereco']) ? $v['endereco'] : NULL));
        $o->setLink((isset($v['link']) ? $v['link'] : NULL));
        $o->setTwitter((isset($v['twitter']) ? $v['twitter'] : NULL));
        $o->setFacebook((isset($v['facebook']) ? $v['facebook'] : NULL));
        $o->setEmail((isset($v['email']) ? $v['email'] : NULL));
        $o->setTelefone((isset($v['telefone']) ? $v['telefone'] : NULL));
        $o->setEmailContato((isset($v['emailContato']) ? $v['emailContato'] : NULL));
        $o->setTituloContato((isset($v['tituloContato']) ? $v['tituloContato'] : NULL));
        $o->setRelatorioLogo((isset($v['relatorioLogo']) ? $v['relatorioLogo'] : NULL));
        $o->setRelatorioCabecalho((isset($v['relatorioCabecalho']) ? $v['relatorioCabecalho'] : NULL));
        $o->setLogUsuario((isset($v['logUsuario']) ? $v['logUsuario'] : NULL));
        $o->setLogData((isset($v['logData']) ? $v['logData'] : NULL));
        return $o;
    }

    public static function toArray($o){
        $v = array();
        $v['id'] = $o->getId();
        $v['sistema'] = $o->getSistema();
        $v['empresa'] = $o->getEmpresa();
        $v['endereco'] = $o->getEndereco();
        $v['link'] = $o->getLink();
        $v['twitter'] = $o->getTwitter();
        $v['facebook'] = $o->getFacebook();
        $v['email'] = $o->getEmail();
        $v['telefone'] = $o->getTelefone();
        $v['emailContato'] = $o->getEmailContato();
        $v['tituloContato'] = $o->getTituloContato();
        $v['relatorioLogo'] = $o->getRelatorioLogo();
        $v['relatorioCabecalho'] = $o->getRelatorioCabecalho();
        $v['logUsuario'] = $o->getLogUsuario();
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
	$aFields['sistema'] = "sistema";
	$conditions = preg_replace('~^sistema$~',"sistema",$conditions);
	$aFields['empresa'] = "empresa";
	$conditions = preg_replace('~^empresa$~',"empresa",$conditions);
	$aFields['endereco'] = "endereco";
	$conditions = preg_replace('~^endereco$~',"endereco",$conditions);
	$aFields['link'] = "link";
	$conditions = preg_replace('~^link$~',"link",$conditions);
	$aFields['twitter'] = "twitter";
	$conditions = preg_replace('~^twitter$~',"twitter",$conditions);
	$aFields['facebook'] = "facebook";
	$conditions = preg_replace('~^facebook$~',"facebook",$conditions);
	$aFields['email'] = "email";
	$conditions = preg_replace('~^email$~',"email",$conditions);
	$aFields['telefone'] = "telefone";
	$conditions = preg_replace('~^telefone$~',"telefone",$conditions);
	$aFields['emailContato'] = "email_contato";
	$conditions = preg_replace('~^emailContato$~',"email_contato",$conditions);
	$aFields['tituloContato'] = "titulo_contato";
	$conditions = preg_replace('~^tituloContato$~',"titulo_contato",$conditions);
	$aFields['relatorioLogo'] = "relatorio_logo";
	$conditions = preg_replace('~^relatorioLogo$~',"relatorio_logo",$conditions);
	$aFields['relatorioCabecalho'] = "relatorio_cabecalho";
	$conditions = preg_replace('~^relatorioCabecalho$~',"relatorio_cabecalho",$conditions);
	$aFields['logUsuario'] = "log_usuario";
	$conditions = preg_replace('~^logUsuario$~',"log_usuario",$conditions);
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
            $aRet["F"][] = ConfiguracaoAction::transformaColunas($attr);
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
	$aFields['sistema'] = "str";
	$aFields['empresa'] = "str";
	$aFields['endereco'] = "str";
	$aFields['link'] = "str";
	$aFields['twitter'] = "str";
	$aFields['facebook'] = "str";
	$aFields['email'] = "str";
	$aFields['telefone'] = "str";
	$aFields['emailContato'] = "str";
	$aFields['tituloContato'] = "str";
	$aFields['relatorioLogo'] = "file";
	$aFields['relatorioCabecalho'] = "editor";
	$aFields['logUsuario'] = "log_usuario";
	$aFields['logData'] = "log_data";
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
        
        return $conditions;
    }
	
	public static function getFieldsStructure($field = null){
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new ConfiguracaoAction();
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
        $aFields = ConfiguracaoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }
	
}
?>