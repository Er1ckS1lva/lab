<?php

/**
 * @Entity 
 * @Table(name="conteudo_arquivo")
 */
class ConteudoArquivo {
    /** 
    * @Id 
    * @manyToOne (targetEntity="Conteudo")
    * @JoinColumn(name="id_conteudo", referencedColumnName="id", columnDefinition="Conteudo")
    **/
    protected $Conteudo;
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


    public function getConteudo() {
        return $this->Conteudo;
    }
    public function setConteudo($Conteudo) {
        if($Conteudo) {
        $this->Conteudo = $Conteudo;
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
        return ConteudoArquivoAction::toArray($this);
    }
}

?>