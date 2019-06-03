<?php

/**
 * @Entity 
 * @Table(name="biblioteca_musica")
 */
class BibliotecaMusica {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="titulo", type="string", length=150, nullable=FALSE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * @Column(name="compositor", type="string", length=150, nullable=TRUE ,unique=FALSE, columnDefinition="Compositor")
    **/
    protected $compositor;
    /** 
    * @Column(name="estilo", type="string", length=150, nullable=TRUE ,unique=FALSE, columnDefinition="Estilo")
    **/
    protected $estilo;
    /** 
    * @Column(name="interprete", type="string", length=150, nullable=TRUE ,unique=FALSE, columnDefinition="Interprete")
    **/
    protected $interprete;
    /** 
    * @Column(name="ano", type="integer", length=4, nullable=TRUE ,unique=FALSE, columnDefinition="Ano")
    **/
    protected $ano;
    /** 
    * @Column(name="fonte", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Fonte")
    **/
    protected $fonte;
    /** 
    * @Column(name="palavra_chave", type="string", length=null, nullable=FALSE ,unique=FALSE, columnDefinition="Palavra chave")
    **/
    protected $palavraChaveMusica;
    /** 
    * @Column(name="arquivo", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Arquivo")
    **/
    protected $arquivo;
    /** 
    * @Column(name="arquivo_name", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Nome do arquivo")
    **/
    protected $arquivoName;
    /** 
    * @Column(name="arquivo_type", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Tipo do arquivo")
    **/
    protected $arquivoType;
    /** 
    * @Column(name="arquivo_size", type="integer", length=11, nullable=TRUE ,unique=FALSE, columnDefinition="Tamanho do arquivo")
    **/
    protected $arquivoSize;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        if($titulo) {
        $this->titulo = $titulo;
        }
    }

    public function getCompositor() {
        return $this->compositor;
    }
    public function setCompositor($compositor) {
        $this->compositor = $compositor;
    }

    public function getEstilo() {
        return $this->estilo;
    }
    public function setEstilo($estilo) {
        $this->estilo = $estilo;
    }

    public function getInterprete() {
        return $this->interprete;
    }
    public function setInterprete($interprete) {
        $this->interprete = $interprete;
    }

    public function getAno() {
        return $this->ano;
    }
    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function getFonte() {
        return $this->fonte;
    }
    public function setFonte($fonte) {
        $this->fonte = $fonte;
    }

    public function getPalavraChaveMusica() {
        return $this->palavraChaveMusica;
    }
    public function setPalavraChaveMusica($palavraChaveMusica) {
        if($palavraChaveMusica) {
        $this->palavraChaveMusica = $palavraChaveMusica;
        }
    }

    public function getArquivo() {
        return $this->arquivo;
    }
    public function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    public function getArquivoName() {
        return $this->arquivoName;
    }
    public function setArquivoName($arquivoName) {
        $this->arquivoName = $arquivoName;
    }

    public function getArquivoType() {
        return $this->arquivoType;
    }
    public function setArquivoType($arquivoType) {
        $this->arquivoType = $arquivoType;
    }

    public function getArquivoSize() {
        return $this->arquivoSize;
    }
    public function setArquivoSize($arquivoSize) {
        $this->arquivoSize = $arquivoSize;
    }



    public function toArray() {
        return BibliotecaMusicaAction::toArray($this);
    }
}

?>