<?php

/**
 * @Entity 
 * @Table(name="pagina")
 */
class Pagina {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="titulo", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * @Column(name="conteudo", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Conteúdo")
    **/
    protected $conteudo;
    /** 
    * @Column(name="target", type="string", length=1, nullable=FALSE ,unique=FALSE, columnDefinition="Outra página")
    **/
    protected $target;
    /** 
    * @Column(name="ordem", type="integer", length=11, nullable=TRUE ,unique=FALSE, columnDefinition="Ordem")
    **/
    protected $ordem;


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

    public function getConteudo() {
        return $this->conteudo;
    }
    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function getTarget() {
        return $this->target;
    }
    public function setTarget($target) {
        if($target) {
        $this->target = $target;
        }
    }

    public function getOrdem() {
        return $this->ordem;
    }
    public function setOrdem($ordem) {
        $this->ordem = $ordem;
    }



    public function toArray() {
        return PaginaAction::toArray($this);
    }
}

?>