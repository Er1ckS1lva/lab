<?php

/**
 * @Entity 
 * @Table(name="perfil")
 */
class Perfil {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="nome", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;
    /** 
    * @Column(name="ativo", type="string", length=8, nullable=FALSE ,unique=FALSE, columnDefinition="Ativo")
    **/
    protected $ativo;
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

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        if($nome) {
        $this->nome = $nome;
        }
    }

    public function getAtivo() {
        return $this->ativo;
    }
    public function setAtivo($ativo) {
        if($ativo) {
        $this->ativo = $ativo;
        }
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
        return PerfilAction::toArray($this);
    }
}

?>