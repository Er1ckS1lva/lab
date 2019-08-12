<?php

/**
 * @Entity 
 * @Table(name="modulo_menu")
 */
class ModuloMenu {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="nome", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;
    /** 
    * @Column(name="descricao", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Descrição")
    **/
    protected $descricao;
    /** 
    * @Column(name="class", type="string", length=100, nullable=TRUE ,unique=FALSE, columnDefinition="Class")
    **/
    protected $class;
    /** 
    * @Column(name="icon", type="string", length=100, nullable=TRUE ,unique=FALSE, columnDefinition="Icon")
    **/
    protected $icon;
    /** 
    * @Column(name="ordem", type="integer", length=11, nullable=TRUE ,unique=FALSE, columnDefinition="Ordem")
    **/
    protected $ordem;
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

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getClass() {
        return $this->class;
    }
    public function setClass($class) {
        $this->class = $class;
    }

    public function getIcon() {
        return $this->icon;
    }
    public function setIcon($icon) {
        $this->icon = $icon;
    }

    public function getOrdem() {
        return $this->ordem;
    }
    public function setOrdem($ordem) {
        $this->ordem = $ordem;
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
        return ModuloMenuAction::toArray($this);
    }
}

?>