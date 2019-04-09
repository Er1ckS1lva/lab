<?php

/**
 * @Entity 
 * @Table(name="atividade")
 */
class Atividade {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Tema")
    * @JoinColumn(name="id_tema", referencedColumnName="id", columnDefinition="Tema")
    **/
    protected $Tema;
    /** 
    * @Column(name="titulo", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * @Column(name="descricao", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Descrição")
    **/
    protected $descricao;
    /** 
    * @Column(name="tipo", type="string", length=3, nullable=TRUE ,unique=FALSE, columnDefinition="Tipo")
    **/
    protected $tipo;
    /** 
    * @Column(name="log_del", type="string", length=1, nullable=FALSE ,unique=FALSE, columnDefinition="Log deleção")
    **/
    protected $logDel;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getTema() {
        return $this->Tema;
    }
    public function setTema($Tema) {
        if($Tema) {
        $this->Tema = $Tema;
        }
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        if($titulo) {
        $this->titulo = $titulo;
        }
    }

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getTipo() {
        return $this->tipo;
    }
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getLogDel() {
        return $this->logDel;
    }
    public function setLogDel($logDel) {
        if($logDel) {
        $this->logDel = $logDel;
        }
    }



    public function toArray() {
        return AtividadeAction::toArray($this);
    }
}

?>