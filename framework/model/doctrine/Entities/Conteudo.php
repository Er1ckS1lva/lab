<?php

/**
 * @Entity 
 * @Table(name="conteudo")
 */
class Conteudo {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="titulo", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * 
    * @manyToOne (targetEntity="Atividade")
    * @JoinColumn(name="id_atividade", referencedColumnName="id", columnDefinition="Atividade")
    **/
    protected $Atividade;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        if($titulo) {
        $this->titulo = $titulo;
        }
    }

    public function getAtividade() {
        return $this->Atividade;
    }
    public function setAtividade($Atividade) {
        if($Atividade) {
        $this->Atividade = $Atividade;
        }
    }



    public function toArray() {
        return ConteudoAction::toArray($this);
    }
}

?>