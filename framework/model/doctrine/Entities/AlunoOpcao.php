<?php

/**
 * @Entity 
 * @Table(name="aluno_opcao")
 */
class AlunoOpcao {
    /** 
    * @Id @GeneratedValue @Column(name="id_aluno", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id_aluno;
    /** 
    * @Id @GeneratedValue @Column(name="id_conteudo_formulario", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id_conteudo_formulario;
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

    public function getId_conteudo_formulario() {
        return $this->id_conteudo_formulario;
    }
    public function setId_conteudo_formulario($id_conteudo_formulario) {
        $this->id_conteudo_formulario = $id_conteudo_formulario;
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
        return AlunoOpcaoAction::toArray($this);
    }
}

?>