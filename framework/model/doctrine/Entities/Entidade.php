<?php

/**
 * @Entity 
 * @Table(name="entidade")
 */
class Entidade {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="nome", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;
    /** 
    * @Column(name="descricao", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Descrição")
    **/
    protected $descricao;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        if($nome) {
        $this->nome = $nome;
        }
    }

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }



    public function toArray() {
        return EntidadeAction::toArray($this);
    }
}

?>