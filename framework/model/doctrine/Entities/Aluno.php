<?php

/**
 * @Entity 
 * @Table(name="aluno")
 */
class Aluno {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="nome", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;
    /** 
    * @Column(name="email", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Email")
    **/
    protected $email;
    /** 
    * @Column(name="senha", type="string", length=256, nullable=TRUE ,unique=FALSE, columnDefinition="Senha")
    **/
    protected $senha;
    /** 
    * @Column(name="dt_cadastro", type="datetime", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Data de Cadastro")
    **/
    protected $dtCadastro;
    /** 
    * @Column(name="recuperar_senha_data", type="datetime", length=20, nullable=TRUE ,unique=FALSE, columnDefinition="Data de recuperação de senha")
    **/
    protected $recuperaSenhaData;
    /** 
    * @Column(name="recuperar_senha_hash", type="string", length=20, nullable=TRUE ,unique=FALSE, columnDefinition="Hash de recuperaração senha")
    **/
    protected $recuperaSenhaHash;
    /** 
    * @Column(name="criar_conta_hash", type="string", length=256, nullable=TRUE ,unique=FALSE, columnDefinition="Hash de criação de conta")
    **/
    protected $criarContaHash;
    /** 
    * @Column(name="ativo", type="string", length=8, nullable=FALSE ,unique=FALSE, columnDefinition="Ativo")
    **/
    protected $ativo;
    /** 
    * @Column(name="login", type="string", length=20, nullable=TRUE ,unique=FALSE, columnDefinition="Login")
    **/
    protected $login;
    /** 
    * @Column(name="aceite_termo", type="string", length=1, nullable=TRUE ,unique=FALSE, columnDefinition="Aceite Termo")
    **/
    protected $aceiteTermo;
    /** 
    * @Column(name="dt_nascimento", type="date", length=null, nullable=FALSE ,unique=FALSE, columnDefinition="Data de Nascimento")
    **/
    protected $dataNascimento;
    /** 
    * @Column(name="sexo", type="string", length=1, nullable=FALSE ,unique=FALSE, columnDefinition="Sexo")
    **/
    protected $sexo;
    /** 
    * @Column(name="moderado", type="string", length=1, nullable=TRUE ,unique=FALSE, columnDefinition="Moderado")
    **/
    protected $moderado;
    /** 
    * @Column(name="cpf", type="string", length=11, nullable=FALSE ,unique=FALSE, columnDefinition="CPF")
    **/
    protected $cpf;
    /** 
    * @Column(name="cidade", type="string", length=100, nullable=FALSE ,unique=FALSE, columnDefinition="Cidade")
    **/
    protected $cidade;
    /** 
    * @Column(name="estado", type="string", length=100, nullable=FALSE ,unique=FALSE, columnDefinition="Estado")
    **/
    protected $estado;
    /** 
    * @Column(name="nacionalidade", type="string", length=100, nullable=FALSE ,unique=FALSE, columnDefinition="Nacionalidade")
    **/
    protected $nacionalidade;
    /** 
    * @Column(name="instituicao_ensino", type="string", length=150, nullable=FALSE ,unique=FALSE, columnDefinition="Instituição de Ensino")
    **/
    protected $instituicaoEnsino;
    /** 
    * @Column(name="curso", type="string", length=150, nullable=FALSE ,unique=FALSE, columnDefinition="Curso")
    **/
    protected $curso;
    /** 
    * @Column(name="login_facial", type="string", length=1, nullable=TRUE ,unique=FALSE, columnDefinition="Login com Reconhecimento Facial")
    **/
    protected $loginFacial;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        if($nome) {
        $this->nome = $nome;
        }
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        if($email) {
        $this->email = $email;
        }
    }

    public function getSenha() {
        return $this->senha;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }
    public function setDtCadastro($dtCadastro) {
        $this->dtCadastro = $dtCadastro;
    }

    public function getRecuperaSenhaData() {
        return $this->recuperaSenhaData;
    }
    public function setRecuperaSenhaData($recuperaSenhaData) {
        $this->recuperaSenhaData = $recuperaSenhaData;
    }

    public function getRecuperaSenhaHash() {
        return $this->recuperaSenhaHash;
    }
    public function setRecuperaSenhaHash($recuperaSenhaHash) {
        $this->recuperaSenhaHash = $recuperaSenhaHash;
    }

    public function getCriarContaHash() {
        return $this->criarContaHash;
    }
    public function setCriarContaHash($criarContaHash) {
        $this->criarContaHash = $criarContaHash;
    }

    public function getAtivo() {
        return $this->ativo;
    }
    public function setAtivo($ativo) {
        if($ativo) {
        $this->ativo = $ativo;
        }
    }

    public function getLogin() {
        return $this->login;
    }
    public function setLogin($login) {
        $this->login = $login;
    }

    public function getAceiteTermo() {
        return $this->aceiteTermo;
    }
    public function setAceiteTermo($aceiteTermo) {
        $this->aceiteTermo = $aceiteTermo;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }
    public function setDataNascimento($dataNascimento) {
        if($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
        }
    }

    public function getSexo() {
        return $this->sexo;
    }
    public function setSexo($sexo) {
        if($sexo) {
        $this->sexo = $sexo;
        }
    }

    public function getModerado() {
        return $this->moderado;
    }
    public function setModerado($moderado) {
        $this->moderado = $moderado;
    }

    public function getCpf() {
        return $this->cpf;
    }
    public function setCpf($cpf) {
        if($cpf) {
        $this->cpf = $cpf;
        }
    }

    public function getCidade() {
        return $this->cidade;
    }
    public function setCidade($cidade) {
        if($cidade) {
        $this->cidade = $cidade;
        }
    }

    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        if($estado) {
        $this->estado = $estado;
        }
    }

    public function getNacionalidade() {
        return $this->nacionalidade;
    }
    public function setNacionalidade($nacionalidade) {
        if($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
        }
    }

    public function getInstituicaoEnsino() {
        return $this->instituicaoEnsino;
    }
    public function setInstituicaoEnsino($instituicaoEnsino) {
        if($instituicaoEnsino) {
        $this->instituicaoEnsino = $instituicaoEnsino;
        }
    }

    public function getCurso() {
        return $this->curso;
    }
    public function setCurso($curso) {
        if($curso) {
        $this->curso = $curso;
        }
    }

    public function getLoginFacial() {
        return $this->loginFacial;
    }
    public function setLoginFacial($loginFacial) {
        $this->loginFacial = $loginFacial;
    }



    public function toArray() {
        return AlunoAction::toArray($this);
    }
}

?>