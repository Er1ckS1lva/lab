<?php

/**
 * @Entity 
 * @Table(name="tema_idioma")
 */
class TemaIdioma {
    /** 
    * @Id 
    * @manyToOne (targetEntity="Tema")
    * @JoinColumn(name="id_tema", referencedColumnName="id", columnDefinition="Tema")
    **/
    protected $Tema;
    /** 
    * @Id 
    * @manyToOne (targetEntity="Idioma")
    * @JoinColumn(name="id_idioma", referencedColumnName="id", columnDefinition="Idioma")
    **/
    protected $Idioma;
    /** 
    * @Column(name="titulo", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Titulo")
    **/
    protected $titulo;
    /** 
    * @Column(name="descricao", type="string", length=null, nullable=FALSE ,unique=FALSE, columnDefinition="Descricao")
    **/
    protected $descricao;


    public function getTema() {
        return $this->Tema;
    }
    public function setTema($Tema) {
        if($Tema) {
        $this->Tema = $Tema;
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
        if($titulo) {
        $this->titulo = $titulo;
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



    public function toArray() {
        return TemaIdiomaAction::toArray($this);
    }
}

?>