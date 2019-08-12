<?php

/**
 * @Entity 
 * @Table(name="laboratorio")
 */
class Laboratorio {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="titulo", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * @Column(name="descricao", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Descrição")
    **/
    protected $descricao;
    /** 
    * @Column(name="termo_uso", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Termo de Uso")
    **/
    protected $termoUso;


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

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getTermoUso() {
        return $this->termoUso;
    }
    public function setTermoUso($termoUso) {
        $this->termoUso = $termoUso;
    }



    public function toArray() {
        return LaboratorioAction::toArray($this);
    }
}

?>