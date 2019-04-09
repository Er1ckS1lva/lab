<?php

require dirname(__FILE__) . '/../doctrine/Entities/Aluno.php';

class AlunoActionParent {

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

    public function validateParent(&$request, $edicao = false) {
        $aFieldsStructure = AlunoAction::getFieldsStructure(); # estrutura da tabela

        if ($request->get("nome") == '') {
            throw new Exception("Por favor, informe o campo Nome!");
        }


        if (isset($aFieldsStructure["nome"]) && !isset($aFieldsStructure["nome"]["isFk"]) && $aFieldsStructure["nome"]["length"]) {
            if (strlen($request->get("nome")) > $aFieldsStructure["nome"]["length"]) {
                $this->setMsg("Por favor, informe o campo Nome corretamente, o tamanho do campo é {$aFieldsStructure["nome"]["length"]}!");
                return false;
            }
        }
        if ($request->get("email") == '') {
            throw new Exception("Por favor, informe o campo Email!");
        }


        if (isset($aFieldsStructure["email"]) && !isset($aFieldsStructure["email"]["isFk"]) && $aFieldsStructure["email"]["length"]) {
            if (strlen($request->get("email")) > $aFieldsStructure["email"]["length"]) {
                $this->setMsg("Por favor, informe o campo Email corretamente, o tamanho do campo é {$aFieldsStructure["email"]["length"]}!");
                return false;
            }
        }
        if ($request->get("ativo") == '') {
            throw new Exception("Por favor, informe o campo Ativo!");
        }


        if (isset($aFieldsStructure["ativo"]) && !isset($aFieldsStructure["ativo"]["isFk"]) && $aFieldsStructure["ativo"]["length"]) {
            if (strlen($request->get("ativo")) > $aFieldsStructure["ativo"]["length"]) {
                $this->setMsg("Por favor, informe o campo Ativo corretamente, o tamanho do campo é {$aFieldsStructure["ativo"]["length"]}!");
                return false;
            }
        }
        if ($request->get("dataNascimento") == '') {
            throw new Exception("Por favor, informe o campo Data de Nascimento!");
        }


        if (isset($aFieldsStructure["dataNascimento"]) && !isset($aFieldsStructure["dataNascimento"]["isFk"]) && $aFieldsStructure["dataNascimento"]["length"]) {
            if (strlen($request->get("dataNascimento")) > $aFieldsStructure["dataNascimento"]["length"]) {
                $this->setMsg("Por favor, informe o campo Data de Nascimento corretamente, o tamanho do campo é {$aFieldsStructure["dataNascimento"]["length"]}!");
                return false;
            }
        }
        if ($request->get("dataNascimento")) {
            if (!Validate::validateDate($request->get("dataNascimento"))) {
                throw new Exception("Formato inválido do campo Data de Nascimento!");
            } else {
                $request->set('dataNascimento', Util::transformaData($request->get('dataNascimento'), 'normal2mysql'));
            }
        }


        if ($request->get("sexo") == '') {
            throw new Exception("Por favor, informe o campo Sexo!");
        }


        if (isset($aFieldsStructure["sexo"]) && !isset($aFieldsStructure["sexo"]["isFk"]) && $aFieldsStructure["sexo"]["length"]) {
            if (strlen($request->get("sexo")) > $aFieldsStructure["sexo"]["length"]) {
                $this->setMsg("Por favor, informe o campo Sexo corretamente, o tamanho do campo é {$aFieldsStructure["sexo"]["length"]}!");
                return false;
            }
        }
        if ($request->get("cpf") == '') {
            throw new Exception("Por favor, informe o campo CPF!");
        }


        if (isset($aFieldsStructure["cpf"]) && !isset($aFieldsStructure["cpf"]["isFk"]) && $aFieldsStructure["cpf"]["length"]) {
            if (strlen($request->get("cpf")) > $aFieldsStructure["cpf"]["length"]) {
                $this->setMsg("Por favor, informe o campo CPF corretamente, o tamanho do campo é {$aFieldsStructure["cpf"]["length"]}!");
                return false;
            }
        }
        if ($request->get("cidade") == '') {
            throw new Exception("Por favor, informe o campo Cidade!");
        }


        if (isset($aFieldsStructure["cidade"]) && !isset($aFieldsStructure["cidade"]["isFk"]) && $aFieldsStructure["cidade"]["length"]) {
            if (strlen($request->get("cidade")) > $aFieldsStructure["cidade"]["length"]) {
                $this->setMsg("Por favor, informe o campo Cidade corretamente, o tamanho do campo é {$aFieldsStructure["cidade"]["length"]}!");
                return false;
            }
        }
        if ($request->get("estado") == '') {
            throw new Exception("Por favor, informe o campo Estado!");
        }


        if (isset($aFieldsStructure["estado"]) && !isset($aFieldsStructure["estado"]["isFk"]) && $aFieldsStructure["estado"]["length"]) {
            if (strlen($request->get("estado")) > $aFieldsStructure["estado"]["length"]) {
                $this->setMsg("Por favor, informe o campo Estado corretamente, o tamanho do campo é {$aFieldsStructure["estado"]["length"]}!");
                return false;
            }
        }
        if ($request->get("nacionalidade") == '') {
            throw new Exception("Por favor, informe o campo Nacionalidade!");
        }


        if (isset($aFieldsStructure["nacionalidade"]) && !isset($aFieldsStructure["nacionalidade"]["isFk"]) && $aFieldsStructure["nacionalidade"]["length"]) {
            if (strlen($request->get("nacionalidade")) > $aFieldsStructure["nacionalidade"]["length"]) {
                $this->setMsg("Por favor, informe o campo Nacionalidade corretamente, o tamanho do campo é {$aFieldsStructure["nacionalidade"]["length"]}!");
                return false;
            }
        }
        if ($request->get("instituicaoEnsino") == '') {
            throw new Exception("Por favor, informe o campo Instituição de Ensino!");
        }


        if (isset($aFieldsStructure["instituicaoEnsino"]) && !isset($aFieldsStructure["instituicaoEnsino"]["isFk"]) && $aFieldsStructure["instituicaoEnsino"]["length"]) {
            if (strlen($request->get("instituicaoEnsino")) > $aFieldsStructure["instituicaoEnsino"]["length"]) {
                $this->setMsg("Por favor, informe o campo Instituição de Ensino corretamente, o tamanho do campo é {$aFieldsStructure["instituicaoEnsino"]["length"]}!");
                return false;
            }
        }
        if ($request->get("curso") == '') {
            throw new Exception("Por favor, informe o campo Curso!");
        }


        if (isset($aFieldsStructure["curso"]) && !isset($aFieldsStructure["curso"]["isFk"]) && $aFieldsStructure["curso"]["length"]) {
            if (strlen($request->get("curso")) > $aFieldsStructure["curso"]["length"]) {
                $this->setMsg("Por favor, informe o campo Curso corretamente, o tamanho do campo é {$aFieldsStructure["curso"]["length"]}!");
                return false;
            }
        }
        if (!Validate::validateCampoUnico("Aluno", array('o.login' => "'{$request->get('login')}'"), array('o.id' => $request->get('id')), $this->em, $edicao)) {
            throw new Exception("Já existe um registro cadastrado com o valor: [Login: {$request->get('login')}]");
        }
        if (!Validate::validateCampoUnico("Aluno", array('o.email' => "'{$request->get('email')}'"), array('o.id' => $request->get('id')), $this->em, $edicao)) {
            throw new Exception("Já existe um registro cadastrado com o valor: [E-mail: {$request->get('email')}]");
        }

        return true;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;

        $oAluno = new Aluno();
        $oAluno->setNome($nome);
        $oAluno->setEmail($email);
        $oAluno->setSenha($senha);
        $oAluno->setDtCadastro(isset($dtCadastro) ? new DateTime($dtCadastro) : NULL);
        $oAluno->setRecuperaSenhaData(isset($recuperaSenhaData) ? new DateTime($recuperaSenhaData) : NULL);
        $oAluno->setRecuperaSenhaHash($recuperaSenhaHash);
        $oAluno->setCriarContaHash($criarContaHash);
        $oAluno->setAtivo($ativo);
        $oAluno->setLogin($login);
        $oAluno->setAceiteTermo($aceiteTermo);
        $oAluno->setDataNascimento(isset($dataNascimento) ? new DateTime($dataNascimento) : NULL);
        $oAluno->setSexo($sexo);
        $oAluno->setModerado($moderado);
        $oAluno->setCpf($cpf);
        $oAluno->setCidade($cidade);
        $oAluno->setEstado($estado);
        $oAluno->setNacionalidade($nacionalidade);
        $oAluno->setInstituicaoEnsino($instituicaoEnsino);
        $oAluno->setCurso($curso);
        $oAluno->setLoginFacial($loginFacial);

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAluno);
            $this->em->flush($oAluno);
            $this->addTransaction($oAluno, $request);


            if ($doLog) {

                ## LOG BEGIN ##
                $oLog = new LogAction($this->em);
                $oLog->register("O", "Adicionado Aluno com o índice '{$oAluno->getId()}'", FALSE);
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
        if ($returnObject === true) {
            return $oAluno;
        }
        return true;
    }

    protected function addTransaction($oAluno, $request) {
        
    }

    public function edit($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;

        $oAluno = $this->em->find('Aluno', array('id' => $id));
        $oAluno->setNome($nome);
        $oAluno->setEmail($email);
        $oAluno->setAtivo($ativo);
        $oAluno->setDataNascimento(isset($dataNascimento) ? new DateTime($dataNascimento) : NULL);
        $oAluno->setSexo($sexo);
        $oAluno->setCpf($cpf);
        $oAluno->setCidade($cidade);
        $oAluno->setEstado($estado);
        $oAluno->setNacionalidade($nacionalidade);
        $oAluno->setInstituicaoEnsino($instituicaoEnsino);
        $oAluno->setCurso($curso);

        if (isset($loginFacial))
            $oAluno->setLoginFacial($loginFacial);


        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oAluno);
            $this->em->flush($oAluno);
            $this->editTransaction($oAluno, $request);


            if ($doLog) {

                ## LOG BEGIN ##
                $oLog = new LogAction($this->em);
                $oLog->register("O", "Editado Aluno com o índice {$id}", FALSE);
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
        if ($returnObject === true) {
            return $oAluno;
        }
        return true;
    }

    protected function editTransaction($oAluno, $request) {
        
    }

    public function paginatedCollection($fieldsToSelect = null, $page = 0, $resultsPerPage = 10, $conditions = null, $order = null, $distinct = FALSE, &$paginator = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);

        $qb = $this->em->createQueryBuilder();
        $query = $qb->select($fieldsToSelect)
                ->from('Aluno', 'o');
        $query->distinct($distinct);

        if ($conditions) {
            $aConditions = is_array($conditions) ? $conditions : array($conditions);
            foreach ($aConditions as $condition) {
                $query->andWhere($condition);
            }
        }


        if (AlunoAction::manualOrder($query, $order) === FALSE) {
            if ($order) {
                if (strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE) {
                    list($order, $orderType) = explode(" ", $order, 2);
                } else {
                    $orderType = "ASC";
                }
                $entityPrefix = "o";

                $query->addOrderBy("{$entityPrefix}.{$order}", $orderType);
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
                ->from('Aluno', 'o');
        $query->distinct($distinct);

        if ($conditions) {
            $aConditions = is_array($conditions) ? $conditions : array($conditions);
            foreach ($aConditions as $condition) {
                $query->andWhere($condition);
            }
        }


        if (AlunoAction::manualOrder($query, $order) === FALSE) {
            if ($order) {
                if (strpos($order, " ") >= 0 && strpos($order, " ") !== FALSE) {
                    list($order, $orderType) = explode(" ", $order, 2);
                } else {
                    $orderType = "ASC";
                }
                $entityPrefix = "o";

                $query->addOrderBy("{$entityPrefix}.{$order}", $orderType);
            }
        }
        if ($limit !== NULL) {
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
                ->from('Aluno', 'o');


        if ($conditions) {
            $aConditions = is_array($conditions) ? $conditions : array($conditions);
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
                ->from('Aluno', 'o')
                ->where($where);

        $oAluno = $query->getQuery()->getOneOrNullResult();
        return $oAluno;
    }

    public function selectHistorico($id) {
        ### SELECT SEM LEVAR EM CONTA A DELEÇÃO LÓGICA ###
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select('o')
                ->from('Aluno', 'o')
                ->where($where);
        $oAluno = $query->getQuery()->getOneOrNullResult();
        return $oAluno;
    }

    public function delLogical($id, $commitable = true, $doLog = true) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->update("Aluno o")
                        //->set([nome_atributo], 0)
                        ->where($where)->getQuery();

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id);
            $query->execute();

            if ($doLog) {

                ## LOG BEGIN ##
                $oLog = new LogAction($this->em);
                $oLog->register("O", "Excluído Aluno com o índice {$id}", FALSE);
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
        $query = $qb->delete()->from("Aluno", "o")
                        ->where($where)->getQuery();
        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->delTransaction($id);
            $query->execute();

            if ($doLog) {

                ## LOG BEGIN ##
                $oLog = new LogAction($this->em);
                $oLog->register("O", "Excluído Aluno com o índice {$id}", FALSE);
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

    protected function delTransaction($id) {
        
    }

    public function delLogicalSelected($ids) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        try {
            $this->em->beginTransaction();
            foreach ($ids as $id) {
                $this->delLogical($id, false);
            }
            foreach ($ids as $id) {
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
            foreach ($ids as $id) {
                $this->delPhysical($id, false);
            }
            foreach ($ids as $id) {
                # apaga os arquivos
            }
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw $e;
        }
        return true;
    }

    public static function getEntityName() {
        return 'Aluno';
    }

    public static function getTableName() {
        return 'aluno';
    }

    public static function getModuleName() {
        return 'laboratoriovirtual';
    }

    public static function getClassName() {
        return 'Aluno';
    }

    public static function getBaseUrl() {
        return URL . AlunoAction::getModuleName() . "/Aluno/";
    }

    public static function manualOrder(&$query, $order) {
        return false;
    }

    public static function suggestDesc($o) {
        return $o->getNome();
    }

    public static function suggestDescHtml($o) {
        return NULL;
    }

    public static function validateFields() {
        $aValidateFields = array('nome' => 'nome', 'email' => 'email', 'ativo' => 'ativo', 'dt_nascimento' => 'dataNascimento', 'sexo' => 'sexo', 'cpf' => 'cpf', 'cidade' => 'cidade', 'estado' => 'estado', 'nacionalidade' => 'nacionalidade', 'instituicao_ensino' => 'instituicaoEnsino', 'curso' => 'curso');
        return (join(",", $aValidateFields));
    }

    public function toObject($v) {
        $o = new Aluno();
        $o->setId((isset($v['id']) ? $v['id'] : NULL));
        $o->setNome((isset($v['nome']) ? $v['nome'] : NULL));
        $o->setEmail((isset($v['email']) ? $v['email'] : NULL));
        $o->setSenha((isset($v['senha']) ? $v['senha'] : NULL));
        $o->setDtCadastro((isset($v['dtCadastro']) ? $v['dtCadastro'] : NULL));
        $o->setRecuperaSenhaData((isset($v['recuperaSenhaData']) ? $v['recuperaSenhaData'] : NULL));
        $o->setRecuperaSenhaHash((isset($v['recuperaSenhaHash']) ? $v['recuperaSenhaHash'] : NULL));
        $o->setCriarContaHash((isset($v['criarContaHash']) ? $v['criarContaHash'] : NULL));
        $o->setAtivo((isset($v['ativo']) ? $v['ativo'] : NULL));
        $o->setLogin((isset($v['login']) ? $v['login'] : NULL));
        $o->setAceiteTermo((isset($v['aceiteTermo']) ? $v['aceiteTermo'] : NULL));
        $o->setDataNascimento((isset($v['dataNascimento']) ? $v['dataNascimento'] : NULL));
        $o->setSexo((isset($v['sexo']) ? $v['sexo'] : NULL));
        $o->setModerado((isset($v['moderado']) ? $v['moderado'] : NULL));
        $o->setCpf((isset($v['cpf']) ? $v['cpf'] : NULL));
        $o->setCidade((isset($v['cidade']) ? $v['cidade'] : NULL));
        $o->setEstado((isset($v['estado']) ? $v['estado'] : NULL));
        $o->setNacionalidade((isset($v['nacionalidade']) ? $v['nacionalidade'] : NULL));
        $o->setInstituicaoEnsino((isset($v['instituicaoEnsino']) ? $v['instituicaoEnsino'] : NULL));
        $o->setCurso((isset($v['curso']) ? $v['curso'] : NULL));
        $o->setLoginFacial((isset($v['loginFacial']) ? $v['loginFacial'] : NULL));
        return $o;
    }

    public static function toArray($o) {
        $v = array();
        $v['id'] = $o->getId();
        $v['nome'] = $o->getNome();
        $v['email'] = $o->getEmail();
        $v['senha'] = $o->getSenha();
        $v['dtCadastro'] = $o->getDtCadastro();
        $v['recuperaSenhaData'] = $o->getRecuperaSenhaData();
        $v['recuperaSenhaHash'] = $o->getRecuperaSenhaHash();
        $v['criarContaHash'] = $o->getCriarContaHash();
        $v['ativo'] = $o->getAtivo();
        $v['login'] = $o->getLogin();
        $v['aceiteTermo'] = $o->getAceiteTermo();
        $v['dataNascimento'] = $o->getDataNascimento();
        $v['sexo'] = $o->getSexo();
        $v['moderado'] = $o->getModerado();
        $v['cpf'] = $o->getCpf();
        $v['cidade'] = $o->getCidade();
        $v['estado'] = $o->getEstado();
        $v['nacionalidade'] = $o->getNacionalidade();
        $v['instituicaoEnsino'] = $o->getInstituicaoEnsino();
        $v['curso'] = $o->getCurso();
        $v['loginFacial'] = $o->getLoginFacial();
        return $v;
    }

    public function getAdmFields() {
        return null;
    }

    public static function transformaColunas($conditions = null) {
        # tenta dar o replace nos campos ou retorna os campos senão tiver que substituir
        $aFields['id'] = "id";
        $conditions = preg_replace('~^id$~', "id", $conditions);
        $aFields['nome'] = "nome";
        $conditions = preg_replace('~^nome$~', "nome", $conditions);
        $aFields['email'] = "email";
        $conditions = preg_replace('~^email$~', "email", $conditions);
        $aFields['senha'] = "senha";
        $conditions = preg_replace('~^senha$~', "senha", $conditions);
        $aFields['dtCadastro'] = "dt_cadastro";
        $conditions = preg_replace('~^dtCadastro$~', "dt_cadastro", $conditions);
        $aFields['recuperaSenhaData'] = "recuperar_senha_data";
        $conditions = preg_replace('~^recuperaSenhaData$~', "recuperar_senha_data", $conditions);
        $aFields['recuperaSenhaHash'] = "recuperar_senha_hash";
        $conditions = preg_replace('~^recuperaSenhaHash$~', "recuperar_senha_hash", $conditions);
        $aFields['criarContaHash'] = "criar_conta_hash";
        $conditions = preg_replace('~^criarContaHash$~', "criar_conta_hash", $conditions);
        $aFields['ativo'] = "ativo";
        $conditions = preg_replace('~^ativo$~', "ativo", $conditions);
        $aFields['login'] = "login";
        $conditions = preg_replace('~^login$~', "login", $conditions);
        $aFields['aceiteTermo'] = "aceite_termo";
        $conditions = preg_replace('~^aceiteTermo$~', "aceite_termo", $conditions);
        $aFields['dataNascimento'] = "dt_nascimento";
        $conditions = preg_replace('~^dataNascimento$~', "dt_nascimento", $conditions);
        $aFields['sexo'] = "sexo";
        $conditions = preg_replace('~^sexo$~', "sexo", $conditions);
        $aFields['moderado'] = "moderado";
        $conditions = preg_replace('~^moderado$~', "moderado", $conditions);
        $aFields['cpf'] = "cpf";
        $conditions = preg_replace('~^cpf$~', "cpf", $conditions);
        $aFields['cidade'] = "cidade";
        $conditions = preg_replace('~^cidade$~', "cidade", $conditions);
        $aFields['estado'] = "estado";
        $conditions = preg_replace('~^estado$~', "estado", $conditions);
        $aFields['nacionalidade'] = "nacionalidade";
        $conditions = preg_replace('~^nacionalidade$~', "nacionalidade", $conditions);
        $aFields['instituicaoEnsino'] = "instituicao_ensino";
        $conditions = preg_replace('~^instituicaoEnsino$~', "instituicao_ensino", $conditions);
        $aFields['curso'] = "curso";
        $conditions = preg_replace('~^curso$~', "curso", $conditions);
        $aFields['loginFacial'] = "login_facial";
        $conditions = preg_replace('~^loginFacial$~', "login_facial", $conditions);
        if (!$conditions) {
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
            $aRet["F"][] = AlunoAction::transformaColunas($attr);
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
        $aFields['email'] = "str";
        $aFields['senha'] = "str";
        $aFields['dtCadastro'] = "datetime";
        $aFields['recuperaSenhaData'] = "datetime";
        $aFields['recuperaSenhaHash'] = "str";
        $aFields['criarContaHash'] = "str";
        $aFields['ativo'] = "sim/nao";
        $aFields['login'] = "str";
        $aFields['aceiteTermo'] = "sim/nao";
        $aFields['dataNascimento'] = "date";
        $aFields['sexo'] = "sim/nao";
        $aFields['moderado'] = "sim/nao";
        $aFields['cpf'] = "str";
        $aFields['cidade'] = "str";
        $aFields['estado'] = "str";
        $aFields['nacionalidade'] = "str";
        $aFields['instituicaoEnsino'] = "str";
        $aFields['curso'] = "str";
        $aFields['loginFacial'] = "sim/nao";
        if ($field) {
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
                ->from('Aluno', 'o')
                ->where($where);

        $oAluno = $query->getQuery()->getOneOrNullResult();
        return $oAluno;
    }

    public function selectByEmail($email, $fieldsToSelect = null) {
        /* @var $query \Doctrine\ORM\QueryBuilder */

        $queryHelper = new QueryHelper();
        $fieldsToSelect = $queryHelper->getSelectFields($fieldsToSelect);
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.email' => "'$email'"), $qb);
        $query = $qb->select($fieldsToSelect)
                ->from('Aluno', 'o')
                ->where($where);

        $oAluno = $query->getQuery()->getOneOrNullResult();
        return $oAluno;
    }

    public static function getValueForAtivo($v) {
        switch ($v) {
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
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getRadioButtonForAtivo($v = NULL, $tabindex = "", $event = "", $name = 'ativo') {
        $valores = self::getValuesForAtivo();
        $radio = "";
        foreach ($valores as $key => $value) {
            $checked = '';
            if (($v) == ($key))
                $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='" . $name . "' name='" . $name . "' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }

    public static function getValueForAceiteTermo($v) {
        switch ($v) {
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

    public static function getValuesForAceiteTermo() {
        return array('S' => 'Sim', 'N' => 'Não');
    }

    public static function getComboBoxForAceiteTermo($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'aceiteTermo') {
        $valores = self::getValuesForAceiteTermo();
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getRadioButtonForAceiteTermo($v = NULL, $tabindex = "", $event = "", $name = 'aceiteTermo') {
        $valores = self::getValuesForAceiteTermo();
        $radio = "";
        foreach ($valores as $key => $value) {
            $checked = '';
            if (($v) == ($key))
                $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='" . $name . "' name='" . $name . "' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }

    public static function getValueForSexo($v) {
        switch ($v) {
            case 'F':
                $value = 'Feminino';
                break;
            case 'M':
                $value = 'Masculino';
                break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }

    public static function getValuesForSexo() {
        return array('F' => 'Feminino', 'M' => 'Masculino');
    }

    public static function getComboBoxForSexo($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'sexo') {
        $valores = self::getValuesForSexo();
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getRadioButtonForSexo($v = NULL, $tabindex = "", $event = "", $name = 'sexo') {
        $valores = self::getValuesForSexo();
        $radio = "";
        foreach ($valores as $key => $value) {
            $checked = '';
            if (($v) == ($key))
                $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='" . $name . "' name='" . $name . "' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }

    public static function getValueForModerado($v) {
        switch ($v) {
            case 'N':
                $value = 'Não';
                break;
            case 'S':
                $value = 'Sim';
                break;

            default:
                $value = "N/D";
                break;
        }
        return $value;
    }

    public static function getValuesForModerado() {
        return array('N' => 'Não', 'S' => 'Sim');
    }

    public static function getComboBoxForModerado($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'moderado') {
        $valores = self::getValuesForModerado();
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getRadioButtonForModerado($v = NULL, $tabindex = "", $event = "", $name = 'moderado') {
        $valores = self::getValuesForModerado();
        $radio = "";
        foreach ($valores as $key => $value) {
            $checked = '';
            if (($v) == ($key))
                $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='" . $name . "' name='" . $name . "' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }

    public static function getValueForLoginFacial($v) {
        switch ($v) {
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

    public static function getValuesForLoginFacial() {
        return array('S' => 'Sim', 'N' => 'Não');
    }

    public static function getComboBoxForLoginFacial($v = NULL, $tabindex = "", $emptyDefaultText = false, $events = "", $name = 'loginFacial') {
        $valores = self::getValuesForLoginFacial();
        $select = '<select ' . $events . ' id="' . $name . '" name="' . $name . '" tabindex="' . $tabindex . '" class="form-control input-sm">';
        if ($emptyDefaultText) {
            $select .= "<option value=''>{$emptyDefaultText}</option>";
        }
        foreach ($valores as $key => $value) {
            $selected = '';
            if (($v) == ($key))
                $selected = 'selected';
            $select .= "<option value='{$key}' {$selected}>{$value}</option>";
        }
        $select .= "</select>";
        return $select;
    }

    public static function getRadioButtonForLoginFacial($v = NULL, $tabindex = "", $event = "", $name = 'loginFacial') {
        $valores = self::getValuesForLoginFacial();
        $radio = "";
        foreach ($valores as $key => $value) {
            $checked = '';
            if (($v) == ($key))
                $checked = 'checked="checked"';
            $radio .= "<label class='radio'><input {$event} type='radio' id='" . $name . "' name='" . $name . "' value='{$key}' tabindex='{$tabindex}' {$checked}><i></i>{$value}</label>";
        }
        return $radio;
    }

    public function validateDel($id, $isSingleDel = true) {
        #$ids = is_array($id) ? $id : array($id);
        #foreach ($ids as $id_del) {

        if ($isSingleDel) {
            return true;
        } else {
            return true;
        }
    }

    public function filterConditions(&$request, &$response, &$orderPageConditions, $alias = "o", $conditions = array()) {

        if ($request->get('nome')) {
            $conditions[] = "{$alias}.nome LIKE '%" . ($request->get('nome') ) . "%'";
            $orderPageConditions .= "&nome={$request->get('nome')}";
            $response->set('nome', $request->get("nome"));
        }
        if ($request->get('dtCadastro')) {
            $conditions[] = "{$alias}.dtCadastro = '" . $request->get('dtCadastro') . "'";
            $orderPageConditions .= "&dtCadastro={$request->get('dtCadastro')}";
            $response->set('dtCadastro', $request->get("dtCadastro"));
        }
        if ($request->get('ativo')) {
            $conditions[] = "{$alias}.ativo = '" . $request->get('ativo') . "'";
            $orderPageConditions .= "&ativo={$request->get('ativo')}";
            $response->set('ativo', $request->get("ativo"));
        }
        if ($request->get('aceiteTermo')) {
            $conditions[] = "{$alias}.aceiteTermo = '" . $request->get('aceiteTermo') . "'";
            $orderPageConditions .= "&aceiteTermo={$request->get('aceiteTermo')}";
            $response->set('aceiteTermo', $request->get("aceiteTermo"));
        }
        if ($request->get('sexo')) {
            $conditions[] = "{$alias}.sexo = '" . $request->get('sexo') . "'";
            $orderPageConditions .= "&sexo={$request->get('sexo')}";
            $response->set('sexo', $request->get("sexo"));
        }
        if ($request->get('moderado')) {
            $conditions[] = "{$alias}.moderado = '" . $request->get('moderado') . "'";
            $orderPageConditions .= "&moderado={$request->get('moderado')}";
            $response->set('moderado', $request->get("moderado"));
        }
        if ($request->get('cpf')) {
            $conditions[] = "{$alias}.cpf LIKE '%" . ($request->get('cpf') ) . "%'";
            $orderPageConditions .= "&cpf={$request->get('cpf')}";
            $response->set('cpf', $request->get("cpf"));
        }

        return $conditions;
    }

    public static function getFieldsStructure($field = null) {
        // ex: $aFieldsStructure = (Action::getFieldsStructure());
        $oAction = new AlunoAction();
        $entityManager = $oAction->getConnection();
        $aFields = QueryHelper::getFieldsForClass($oAction->getClassName(), $entityManager);
        if ($field) {
            if (isset($aFields[$field]))
                return $aFields[$field];
            else
                return NAO_DEFINIDO;
        }
        return $aFields;
    }

    public static function maxlengthFields() {
        $aFields = AlunoAction::getFieldsStructure();
        $aMaxlength = array();
        foreach ($aFields as $k => $o) {
            $aMaxlength[$k] = isset($o["length"]) ? $o["length"] : "";
        }
        return $aMaxlength;
    }

}

?>