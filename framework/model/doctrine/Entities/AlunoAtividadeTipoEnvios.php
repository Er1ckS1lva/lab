<?php

/**
 * @Entity 
 * @Table(name="aluno_atividade_tipo_envios")
 */
class AlunoAtividadeTipoEnvios {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * 
    * @manyToOne (targetEntity="Aluno")
    * @JoinColumn(name="aluno_id", referencedColumnName="id", columnDefinition="Aluno ")
    **/
    protected $aluno_id;
    /** 
    * 
    * @manyToOne (targetEntity="Atividade")
    * @JoinColumn(name="atividade_id", referencedColumnName="id", columnDefinition="Atividade ")
    **/
    protected $adeId;
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


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getAluno_id() {
        return $this->aluno_id;
    }
    public function setAluno_id($aluno_id) {
        if($aluno_id) {
        $this->aluno_id = $aluno_id;
        }
    }

    public function getAdeId() {
        return $this->adeId;
    }
    public function setAdeId($adeId) {
        if($adeId) {
        $this->adeId = $adeId;
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
        return AlunoAtividadeTipoEnviosAction::toArray($this);
    }
}

?>