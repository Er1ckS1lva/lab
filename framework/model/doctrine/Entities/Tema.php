<?php

/**
 * @Entity 
 * @Table(name="tema")
 */
class Tema {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Laboratorio")
    * @JoinColumn(name="id_laboratorio", referencedColumnName="id", columnDefinition="Laboratório")
    **/
    protected $Laboratorio;
    /** 
    * @Column(name="titulo", type="string", length=45, nullable=FALSE ,unique=FALSE, columnDefinition="Título")
    **/
    protected $titulo;
    /** 
    * @Column(name="descricao", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Descrição")
    **/
    protected $descricao;
    /** 
    * @Column(name="imagem_capa", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Imagem de Capa")
    **/
    protected $imagemCapa;
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

    public function getLaboratorio() {
        return $this->Laboratorio;
    }
    public function setLaboratorio($Laboratorio) {
        if($Laboratorio) {
        $this->Laboratorio = $Laboratorio;
        }
    }

    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        if($titulo) {
        $this->titulo = $titulo;
        }
    }

    public function getDescricao() {
        return $this->descricao;
    }
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getImagemCapa() {
        return $this->imagemCapa;
    }
    public function setImagemCapa($imagemCapa) {
        $this->imagemCapa = $imagemCapa;
    }

    public function getOrdem() {
        return $this->ordem;
    }
    public function setOrdem($ordem) {
        $this->ordem = $ordem;
    }



    public function toArray() {
        return TemaAction::toArray($this);
    }
}

?>