<?php

/**
 * @Entity 
 * @Table(name="conteudo_formulario")
 */
class ConteudoFormulario {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Conteudo")
    * @JoinColumn(name="id_conteudo", referencedColumnName="id", columnDefinition="Conteudo")
    **/
    protected $Conteudo;
    /** 
    * @Column(name="tipo", type="string", length=3, nullable=FALSE ,unique=FALSE, columnDefinition="Tipo")
    **/
    protected $tipo;
    /** 
    * @Column(name="enunciado", type="string", length=500, nullable=TRUE ,unique=FALSE, columnDefinition="Enunciado")
    **/
    protected $enunciado;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getConteudo() {
        return $this->Conteudo;
    }
    public function setConteudo($Conteudo) {
        if($Conteudo) {
        $this->Conteudo = $Conteudo;
        }
    }

    public function getTipo() {
        return $this->tipo;
    }
    public function setTipo($tipo) {
        if($tipo) {
        $this->tipo = $tipo;
        }
    }

    public function getEnunciado() {
        return $this->enunciado;
    }
    public function setEnunciado($enunciado) {
        $this->enunciado = $enunciado;
    }



    public function toArray() {
        return ConteudoFormularioAction::toArray($this);
    }
}

?>