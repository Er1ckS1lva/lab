<?php

/**
 * @Entity 
 * @Table(name="idioma")
 */
class Idioma {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="titulo", type="string", length=45, nullable=TRUE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * @Column(name="sigla", type="string", length=10, nullable=TRUE ,unique=FALSE, columnDefinition="Sigla")
    **/
    protected $sigla;
    /** 
    * @Column(name="padrao", type="string", length=1, nullable=TRUE ,unique=FALSE, columnDefinition="Idioma Padrão")
    **/
    protected $padrao;


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
        $this->titulo = $titulo;
    }

    public function getSigla() {
        return $this->sigla;
    }
    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    public function getPadrao() {
        return $this->padrao;
    }
    public function setPadrao($padrao) {
        $this->padrao = $padrao;
    }



    public function toArray() {
        return IdiomaAction::toArray($this);
    }
}

?>