<?php

/**
 * @Entity 
 * @Table(name="formulario_opcao")
 */
class FormularioOpcao {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="ConteudoFormulario")
    * @JoinColumn(name="id_conteudo_formulario", referencedColumnName="id", columnDefinition="ConteudoFormulario")
    **/
    protected $ConteudoFormulario;
    /** 
    * @Column(name="valor", type="string", length=50, nullable=TRUE ,unique=FALSE, columnDefinition="Valor")
    **/
    protected $valor;
    /** 
    * @Column(name="correta", type="string", length=1, nullable=FALSE ,unique=FALSE, columnDefinition="Correta")
    **/
    protected $correta;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getConteudoFormulario() {
        return $this->ConteudoFormulario;
    }
    public function setConteudoFormulario($ConteudoFormulario) {
        if($ConteudoFormulario) {
        $this->ConteudoFormulario = $ConteudoFormulario;
        }
    }

    public function getValor() {
        return $this->valor;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getCorreta() {
        return $this->correta;
    }
    public function setCorreta($correta) {
        if($correta) {
        $this->correta = $correta;
        }
    }



    public function toArray() {
        return FormularioOpcaoAction::toArray($this);
    }
}

?>