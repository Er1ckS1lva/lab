<?php

/**
 * @Entity 
 * @Table(name="atividade_idioma")
 */
class AtividadeIdioma {
    /** 
    * @Id 
    * @manyToOne (targetEntity="Atividade")
    * @JoinColumn(name="id_atividade", referencedColumnName="id", columnDefinition="Atividade")
    **/
    protected $Atividade;
    /** 
    * @Id 
    * @manyToOne (targetEntity="Idioma")
    * @JoinColumn(name="id_idioma", referencedColumnName="id", columnDefinition="Idioma")
    **/
    protected $Idioma;
    /** 
    * @Column(name="titulo", type="string", length=90, nullable=TRUE ,unique=FALSE, columnDefinition="Titulo")
    **/
    protected $titulo;
    /** 
    * @Column(name="descricao", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Descricao")
    **/
    protected $descricao;


    public function getAtividade() {
        return $this->Atividade;
    }
    public function setAtividade($Atividade) {
        if($Atividade) {
        $this->Atividade = $Atividade;
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

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }



    public function toArray() {
        return AtividadeIdiomaAction::toArray($this);
    }
}

?>