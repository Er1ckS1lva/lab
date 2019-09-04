<?php

/**
 * @Entity 
 * @Table(name="aluno_opcao_envios")
 */
class AlunoOpcaoEnvios {
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
    * @manyToOne (targetEntity="ConteudoFormulario")
    * @JoinColumn(name="id_conteudo_formulario", referencedColumnName="id", columnDefinition="Conteudo Formulario")
    **/
    protected $ConteudoFormulario;
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

    public function getAluno() {
        return $this->Aluno;
    }
    public function setAluno($Aluno) {
        if($Aluno) {
        $this->Aluno = $Aluno;
        }
    }

    public function getConteudoFormulario() {
        return $this->ConteudoFormulario;
    }
    public function setConteudoFormulario($ConteudoFormulario) {
        if($ConteudoFormulario) {
        $this->ConteudoFormulario = $ConteudoFormulario;
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
        return AlunoOpcaoEnviosAction::toArray($this);
    }
}

?>