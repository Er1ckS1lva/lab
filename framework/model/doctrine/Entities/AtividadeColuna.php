<?php

/**
 * @Entity 
 * @Table(name="atividade_coluna")
 */
class AtividadeColuna {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Idioma")
    * @JoinColumn(name="id_idioma", referencedColumnName="id", columnDefinition="Idioma")
    **/
    protected $Idioma;
    /** 
    * 
    * @manyToOne (targetEntity="Atividade")
    * @JoinColumn(name="id_atividade", referencedColumnName="id", columnDefinition="Atividade")
    **/
    protected $Atividade;
    /** 
    * @Column(name="coluna1", type="integer", length=11, nullable=FALSE ,unique=FALSE, columnDefinition="Coluna1")
    **/
    protected $coluna1;
    /** 
    * @Column(name="coluna2", type="integer", length=11, nullable=FALSE ,unique=FALSE, columnDefinition="Coluna2")
    **/
    protected $coluna2;
    /** 
    * @Column(name="tipo1", type="string", length=3, nullable=FALSE ,unique=FALSE, columnDefinition="Tipo1")
    **/
    protected $tipo1;
    /** 
    * @Column(name="tipo2", type="string", length=3, nullable=FALSE ,unique=FALSE, columnDefinition="Tipo2")
    **/
    protected $tipo2;
    /** 
    * @Column(name="coluna1Text", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Texto 1")
    **/
    protected $coluna1Text;
    /** 
    * @Column(name="coluna2Text", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Texto 2")
    **/
    protected $coluna2Text;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getIdioma() {
        return $this->Idioma;
    }
    public function setIdioma($Idioma) {
        if($Idioma) {
        $this->Idioma = $Idioma;
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

    public function getColuna1() {
        return $this->coluna1;
    }
    public function setColuna1($coluna1) {
        if($coluna1) {
        $this->coluna1 = $coluna1;
        }
    }

    public function getColuna2() {
        return $this->coluna2;
    }
    public function setColuna2($coluna2) {
        if($coluna2) {
        $this->coluna2 = $coluna2;
        }
    }

    public function getTipo1() {
        return $this->tipo1;
    }
    public function setTipo1($tipo1) {
        if($tipo1) {
        $this->tipo1 = $tipo1;
        }
    }

    public function getTipo2() {
        return $this->tipo2;
    }
    public function setTipo2($tipo2) {
        if($tipo2) {
        $this->tipo2 = $tipo2;
        }
    }

    public function getColuna1Text() {
        return $this->coluna1Text;
    }
    public function setColuna1Text($coluna1Text) {
        $this->coluna1Text = $coluna1Text;
    }

    public function getColuna2Text() {
        return $this->coluna2Text;
    }
    public function setColuna2Text($coluna2Text) {
        $this->coluna2Text = $coluna2Text;
    }



    public function toArray() {
        return AtividadeColunaAction::toArray($this);
    }
}

?>