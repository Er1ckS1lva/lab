<?php

/**
 * @Entity 
 * @Table(name="pagina_idioma")
 */
class PaginaIdioma {
    /** 
    * @Id 
    * @manyToOne (targetEntity="Pagina")
    * @JoinColumn(name="id_pagina", referencedColumnName="id", columnDefinition="Página")
    **/
    protected $Pagina;
    /** 
    * @Id 
    * @manyToOne (targetEntity="Idioma")
    * @JoinColumn(name="id_idioma", referencedColumnName="id", columnDefinition="Idioma")
    **/
    protected $Idioma;
    /** 
    * @Column(name="titulo", type="string", length=45, nullable=TRUE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * @Column(name="conteudo", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Conteúdo")
    **/
    protected $conteudo;


    public function getPagina() {
        return $this->Pagina;
    }
    public function setPagina($Pagina) {
        if($Pagina) {
        $this->Pagina = $Pagina;
        }
    }

    public function getIdioma() {
        return $this->Idioma;
    }
    public function setIdioma($Idioma) {
        if($Idioma) {
        $this->Idioma = $Idioma;
        }
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getConteudo() {
        return $this->conteudo;
    }
    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }



    public function toArray() {
        return PaginaIdiomaAction::toArray($this);
    }
}

?>