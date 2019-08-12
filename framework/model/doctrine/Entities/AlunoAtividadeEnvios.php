<?php

/**
 * @Entity 
 * @Table(name="aluno_atividade_envios")
 */
class AlunoAtividadeEnvios {
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
    * 
    * @manyToOne (targetEntity="Atividade")
    * @JoinColumn(name="id_atividade", referencedColumnName="id", columnDefinition="Atividade")
    **/
    protected $Atividade;
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
    /** 
    * @Column(name="score", type="string", length=3, nullable=FALSE ,unique=FALSE, columnDefinition="Score")
    **/
    protected $score;


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

    public function getAtividade() {
        return $this->Atividade;
    }
    public function setAtividade($Atividade) {
        if($Atividade) {
        $this->Atividade = $Atividade;
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

    public function getScore() {
        return $this->score;
    }
    public function setScore($score) {
        if($score) {
        $this->score = $score;
        }
    }



    public function toArray() {
        return AlunoAtividadeEnviosAction::toArray($this);
    }
}

?>