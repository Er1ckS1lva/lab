<?php

/**
 * @Entity 
 * @Table(name="aluno_atividade_tipo")
 */
class AlunoAtividadeTipo {
    /** 
    * @Id @GeneratedValue @Column(name="id_aluno", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id_aluno;
    /** 
    * @Id @GeneratedValue @Column(name="id_atividade", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id_atividade;
    /** 
    * @Column(name="tipo", type="string", length=3, nullable=FALSE ,unique=FALSE, columnDefinition="Tipo")
    **/
    protected $tipo;
    /** 
    * @Column(name="valor", type="string", length=null, nullable=FALSE ,unique=FALSE, columnDefinition="Valor")
    **/
    protected $valor;
    /** 
    * @Column(name="log_data", type="datetime", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Log Data")
    **/
    protected $logData;


    public function getId_aluno() {
        return $this->id_aluno;
    }
    public function setId_aluno($id_aluno) {
        $this->id_aluno = $id_aluno;
    }

    public function getId_atividade() {
        return $this->id_atividade;
    }
    public function setId_atividade($id_atividade) {
        $this->id_atividade = $id_atividade;
    }

    public function getTipo() {
        return $this->tipo;
    }
    public function setTipo($tipo) {
        if($tipo) {
        $this->tipo = $tipo;
        }
    }

    public function getValor() {
        return $this->valor;
    }
    public function setValor($valor) {
        if($valor) {
        $this->valor = $valor;
        }
    }

    public function getLogData() {
        return $this->logData;
    }
    public function setLogData($logData) {
        $this->logData = $logData;
    }



    public function toArray() {
        return AlunoAtividadeTipoAction::toArray($this);
    }
}

?>