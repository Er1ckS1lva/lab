<?php

/**
 * @Entity 
 * @Table(name="aluno_acesso")
 */
class AlunoAcesso {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Aluno")
    * @JoinColumn(name="id_aluno", referencedColumnName="id", columnDefinition="Aluno")
    **/
    protected $Aluno;
    /** 
    * @Column(name="dt_registro", type="datetime", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Data de Registro")
    **/
    protected $dataRegistro;
    /** 
    * @Column(name="recurso", type="string", length=3, nullable=TRUE ,unique=FALSE, columnDefinition="Recurso")
    **/
    protected $recurso;
    /** 
    * 
    * @manyToOne (targetEntity="Atividade")
    * @JoinColumn(name="id_atividade", referencedColumnName="id", columnDefinition="Atividade")
    **/
    protected $Atividade;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getAluno() {
        return $this->Aluno;
    }
    public function setAluno($Aluno) {
        if($Aluno) {
        $this->Aluno = $Aluno;
        }
    }

    public function getDataRegistro() {
        return $this->dataRegistro;
    }
    public function setDataRegistro($dataRegistro) {
        $this->dataRegistro = $dataRegistro;
    }

    public function getRecurso() {
        return $this->recurso;
    }
    public function setRecurso($recurso) {
        $this->recurso = $recurso;
    }

    public function getAtividade() {
        return $this->Atividade;
    }
    public function setAtividade($Atividade) {
        $this->Atividade = $Atividade;
    }



    public function toArray() {
        return AlunoAcessoAction::toArray($this);
    }
}

?>