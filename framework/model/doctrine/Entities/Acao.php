<?php

/**
 * @Entity 
 * @Table(name="acao")
 */
class Acao {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Modulo")
    * @JoinColumn(name="id_modulo", referencedColumnName="id", columnDefinition="Módulo")
    **/
    protected $Modulo;
    /** 
    * @Column(name="nome", type="string", length=45, nullable=TRUE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;
    /** 
    * @Column(name="descricao", type="string", length=500, nullable=TRUE ,unique=FALSE, columnDefinition="Descrição")
    **/
    protected $descricao;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getModulo() {
        return $this->Modulo;
    }
    public function setModulo($Modulo) {
        if($Modulo) {
        $this->Modulo = $Modulo;
        }
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }



    public function toArray() {
        return AcaoAction::toArray($this);
    }
}

?>