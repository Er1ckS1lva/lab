<?php

/**
 * @Entity 
 * @Table(name="atividade_coluna_arquivo")
 */
class AtividadeColunaArquivo {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="AtividadeColuna")
    * @JoinColumn(name="id_atividade_coluna", referencedColumnName="id", columnDefinition="Atividade de Coluna")
    **/
    protected $AtividadeColuna;
    /** 
    * @Column(name="coluna", type="integer", length=11, nullable=FALSE ,unique=FALSE, columnDefinition="Coluna")
    **/
    protected $coluna;
    /** 
    * @Column(name="arquivo", type="string", length=null, nullable=FALSE ,unique=FALSE, columnDefinition="Arquivo")
    **/
    protected $arquivo;
    /** 
    * @Column(name="nome", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Nome")
    **/
    protected $nome;
    /** 
    * @Column(name="tipo", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Tipo")
    **/
    protected $tipo;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getAtividadeColuna() {
        return $this->AtividadeColuna;
    }
    public function setAtividadeColuna($AtividadeColuna) {
        if($AtividadeColuna) {
        $this->AtividadeColuna = $AtividadeColuna;
        }
    }

    public function getColuna() {
        return $this->coluna;
    }
    public function setColuna($coluna) {
        if($coluna) {
        $this->coluna = $coluna;
        }
    }

    public function getArquivo() {
        return $this->arquivo;
    }
    public function setArquivo($arquivo) {
        if($arquivo) {
        $this->arquivo = $arquivo;
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

    public function getTipo() {
        return $this->tipo;
    }
    public function setTipo($tipo) {
        if($tipo) {
        $this->tipo = $tipo;
        }
    }



    public function toArray() {
        return AtividadeColunaArquivoAction::toArray($this);
    }
}

?>