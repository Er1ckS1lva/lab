<?php

/**
 * @Entity 
 * @Table(name="modulo")
 */
class Modulo {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Entidade")
    * @JoinColumn(name="id_entidade", referencedColumnName="id", columnDefinition="Entidade")
    **/
    protected $Entidade;
    /** 
    * @Column(name="nome", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getEntidade() {
        return $this->Entidade;
    }
    public function setEntidade($Entidade) {
        if($Entidade) {
        $this->Entidade = $Entidade;
        }
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        if($nome) {
        $this->nome = $nome;
        }
    }



    public function toArray() {
        return ModuloAction::toArray($this);
    }
}

?>