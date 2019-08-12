<?php

/**
 * @Entity 
 * @Table(name="usuario")
 */
class Usuario {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Perfil")
    * @JoinColumn(name="id_perfil", referencedColumnName="id", columnDefinition="Perfil")
    **/
    protected $Perfil;
    /** 
    * @Column(name="nome", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;
    /** 
    * @Column(name="login", type="string", length=20, nullable=FALSE ,unique=FALSE, columnDefinition="Login")
    **/
    protected $login;
    /** 
    * @Column(name="senha", type="string", length=256, nullable=TRUE ,unique=FALSE, columnDefinition="Senha")
    **/
    protected $senha;
    /** 
    * @Column(name="email", type="string", length=200, nullable=FALSE ,unique=FALSE, columnDefinition="E-mail")
    **/
    protected $email;
    /** 
    * @Column(name="superuser", type="string", length=8, nullable=TRUE ,unique=FALSE, columnDefinition="Super Usuário")
    **/
    protected $superuser;
    /** 
    * @Column(name="foto", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Foto")
    **/
    protected $foto;
    /** 
    * @Column(name="ativo", type="string", length=8, nullable=FALSE ,unique=FALSE, columnDefinition="Ativo")
    **/
    protected $ativo;
    /** 
    * @Column(name="recupera_senha_data", type="datetime", length=20, nullable=TRUE ,unique=FALSE, columnDefinition="Data de recuperação de senha")
    **/
    protected $recuperaSenhaData;
    /** 
    * @Column(name="recuperar_senha_hash", type="string", length=20, nullable=TRUE ,unique=FALSE, columnDefinition="Hash de recuperaração senha")
    **/
    protected $recuperaSenhaHash;
    /** 
    * @Column(name="data_inicio", type="date", length=null, nullable=FALSE ,unique=FALSE, columnDefinition="Data de Início")
    **/
    protected $dataInicio;
    /** 
    * @Column(name="data_final", type="date", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Data Final")
    **/
    protected $dataFinal;
    /** 
    * @Column(name="log_usuario", type="string", length=45, nullable=TRUE ,unique=FALSE, columnDefinition="Log usuário")
    **/
    protected $logUsuario;
    /** 
    * @Column(name="log_del", type="string", length=1, nullable=FALSE ,unique=FALSE, columnDefinition="Log deleção")
    **/
    protected $logDel;
    /** 
    * @Column(name="log_data", type="datetime", length=20, nullable=TRUE ,unique=FALSE, columnDefinition="Log data")
    **/
    protected $logData;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getPerfil() {
        return $this->Perfil;
    }
    public function setPerfil($Perfil) {
        if($Perfil) {
        $this->Perfil = $Perfil;
        }
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        if($nome) {
        $this->nome = $nome;
        }
    }

    public function getLogin() {
        return $this->login;
    }
    public function setLogin($login) {
        if($login) {
        $this->login = $login;
        }
    }

    public function getSenha() {
        return $this->senha;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        if($email) {
        $this->email = $email;
        }
    }

    public function getSuperuser() {
        return $this->superuser;
    }
    public function setSuperuser($superuser) {
        $this->superuser = $superuser;
    }

    public function getFoto() {
        return $this->foto;
    }
    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getAtivo() {
        return $this->ativo;
    }
    public function setAtivo($ativo) {
        if($ativo) {
        $this->ativo = $ativo;
        }
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

    public function getDataInicio() {
        return $this->dataInicio;
    }
    public function setDataInicio($dataInicio) {
        if($dataInicio) {
        $this->dataInicio = $dataInicio;
        }
    }

    public function getDataFinal() {
        return $this->dataFinal;
    }
    public function setDataFinal($dataFinal) {
        $this->dataFinal = $dataFinal;
    }

    public function getLogUsuario() {
        return $this->logUsuario;
    }
    public function setLogUsuario($logUsuario) {
        $this->logUsuario = $logUsuario;
    }

    public function getLogDel() {
        return $this->logDel;
    }
    public function setLogDel($logDel) {
        if($logDel) {
        $this->logDel = $logDel;
        }
    }

    public function getLogData() {
        return $this->logData;
    }
    public function setLogData($logData) {
        $this->logData = $logData;
    }



    public function toArray() {
        return UsuarioAction::toArray($this);
    }
}

?>