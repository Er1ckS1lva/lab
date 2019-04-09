<?php

/**
 * @Entity 
 * @Table(name="atividade_opcao")
 */
class AtividadeOpcao {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="valor", type="string", length=50, nullable=TRUE ,unique=FALSE, columnDefinition="Valor")
    **/
    protected $valor;
    /** 
    * @Column(name="valor_fonetico", type="string", length=100, nullable=TRUE ,unique=FALSE, columnDefinition="Valor Fonético")
    **/
    protected $valorFonetico;
    /** 
    * 
    * @manyToOne (targetEntity="Atividade")
    * @JoinColumn(name="id_atividade", referencedColumnName="id", columnDefinition="Atividade")
    **/
    protected $Atividade;
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

    public function getValor() {
        return $this->valor;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getValorFonetico() {
        return $this->valorFonetico;
    }
    public function setValorFonetico($valorFonetico) {
        $this->valorFonetico = $valorFonetico;
    }

    public function getAtividade() {
        return $this->Atividade;
    }
    public function setAtividade($Atividade) {
        if($Atividade) {
        $this->Atividade = $Atividade;
        }
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
        return AtividadeOpcaoAction::toArray($this);
    }
}

?>