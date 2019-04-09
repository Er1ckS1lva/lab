<?php

/**
 * @Entity 
 * @Table(name="configuracao")
 */
class Configuracao {
    /** 
    * @Id @GeneratedValue @Column(name="id", type="integer", length=8, nullable=true ,unique=FALSE, columnDefinition="")
    **/
    protected $id;
    /** 
    * @Column(name="sistema", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Sistema")
    **/
    protected $sistema;
    /** 
    * @Column(name="empresa", type="string", length=255, nullable=FALSE ,unique=FALSE, columnDefinition="Empresa")
    **/
    protected $empresa;
    /** 
    * @Column(name="endereco", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Endereço")
    **/
    protected $endereco;
    /** 
    * @Column(name="link", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Site")
    **/
    protected $link;
    /** 
    * @Column(name="twitter", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Twitter")
    **/
    protected $twitter;
    /** 
    * @Column(name="facebook", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Facebook")
    **/
    protected $facebook;
    /** 
    * @Column(name="email", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="E-mail (s)")
    **/
    protected $email;
    /** 
    * @Column(name="telefone", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Telefone (s)")
    **/
    protected $telefone;
    /** 
    * @Column(name="email_contato", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="E-mail (s) de contato")
    **/
    protected $emailContato;
    /** 
    * @Column(name="titulo_contato", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Titulo do texto de contato")
    **/
    protected $tituloContato;
    /** 
    * @Column(name="relatorio_logo", type="string", length=255, nullable=TRUE ,unique=FALSE, columnDefinition="Logo do relatório")
    **/
    protected $relatorioLogo;
    /** 
    * @Column(name="relatorio_cabecalho", type="string", length=null, nullable=TRUE ,unique=FALSE, columnDefinition="Cabeçalho do relatório")
    **/
    protected $relatorioCabecalho;
    /** 
    * @Column(name="log_usuario", type="string", length=45, nullable=TRUE ,unique=FALSE, columnDefinition="Log usuário")
    **/
    protected $logUsuario;
    /** 
    * @Column(name="log_data", type="datetime", length=20, nullable=TRUE ,unique=FALSE, columnDefinition="Log data")
    **/
    protected $logData;


    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function getSistema() {
        return $this->sistema;
    }
    public function setSistema($sistema) {
        if($sistema) {
        $this->sistema = $sistema;
        }
    }

    public function getEmpresa() {
        return $this->empresa;
    }
    public function setEmpresa($empresa) {
        if($empresa) {
        $this->empresa = $empresa;
        }
    }

    public function getEndereco() {
        return $this->endereco;
    }
    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function getLink() {
        return $this->link;
    }
    public function setLink($link) {
        $this->link = $link;
    }

    public function getTwitter() {
        return $this->twitter;
    }
    public function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    public function getFacebook() {
        return $this->facebook;
    }
    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTelefone() {
        return $this->telefone;
    }
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getEmailContato() {
        return $this->emailContato;
    }
    public function setEmailContato($emailContato) {
        $this->emailContato = $emailContato;
    }

    public function getTituloContato() {
        return $this->tituloContato;
    }
    public function setTituloContato($tituloContato) {
        $this->tituloContato = $tituloContato;
    }

    public function getRelatorioLogo() {
        return $this->relatorioLogo;
    }
    public function setRelatorioLogo($relatorioLogo) {
        $this->relatorioLogo = $relatorioLogo;
    }

    public function getRelatorioCabecalho() {
        return $this->relatorioCabecalho;
    }
    public function setRelatorioCabecalho($relatorioCabecalho) {
        $this->relatorioCabecalho = $relatorioCabecalho;
    }

    public function getLogUsuario() {
        return $this->logUsuario;
    }
    public function setLogUsuario($logUsuario) {
        $this->logUsuario = $logUsuario;
    }

    public function getLogData() {
        return $this->logData;
    }
    public function setLogData($logData) {
        $this->logData = $logData;
    }



    public function toArray() {
        return ConfiguracaoAction::toArray($this);
    }
}

?>