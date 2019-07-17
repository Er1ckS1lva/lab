<?php

/**
 * @Entity 
 * @Table(name="log_admin")
 */
class Log {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Usuario")
    * @JoinColumn(name="id_usuario", referencedColumnName="id", columnDefinition="Usuário")
    **/
    protected $Usuario;
    /** 
    * @Column(name="login", type="string", length=20, nullable=FALSE ,unique=FALSE, columnDefinition="Login")
    **/
    protected $login;
    /** 
    * @Column(name="data_hora", type="datetime", length=20, nullable=FALSE ,unique=FALSE, columnDefinition="Data e hora")
    **/
    protected $dataHora;
    /** 
    * @Column(name="acao", type="string", length=200, nullable=FALSE ,unique=FALSE, columnDefinition="Ação")
    **/
    protected $acao;
    /** 
    * @Column(name="tipo_operacao", type="string", length=1, nullable=FALSE ,unique=FALSE, columnDefinition="Operação")
    **/
    protected $operacao;
    /** 
    * @Column(name="descricao", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Descrição")
    **/
    protected $descricao;
    /** 
    * @Column(name="ip", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="IP")
    **/
    protected $ip;
    /** 
    * @Column(name="nome_host", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="HOSTNAME")
    **/
    protected $nomeHost;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getUsuario() {
        return $this->Usuario;
    }
    public function setUsuario($Usuario) {
        if($Usuario) {
        $this->Usuario = $Usuario;
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

    public function getDataHora() {
        return $this->dataHora;
    }
    public function setDataHora($dataHora) {
        if($dataHora) {
        $this->dataHora = $dataHora;
        }
    }

    public function getAcao() {
        return $this->acao;
    }
    public function setAcao($acao) {
        if($acao) {
        $this->acao = $acao;
        }
    }

    public function getOperacao() {
        return $this->operacao;
    }
    public function setOperacao($operacao) {
        if($operacao) {
        $this->operacao = $operacao;
        }
    }

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        if($descricao) {
        $this->descricao = $descricao;
        }
    }

    public function getIp() {
        return $this->ip;
    }
    public function setIp($ip) {
        if($ip) {
        $this->ip = $ip;
        }
    }

    public function getNomeHost() {
        return $this->nomeHost;
    }
    public function setNomeHost($nomeHost) {
        if($nomeHost) {
        $this->nomeHost = $nomeHost;
        }
    }



    public function toArray() {
        return LogAction::toArray($this);
    }
}

?>