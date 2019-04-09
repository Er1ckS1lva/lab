<?php
class Config {
    // Variavel que define se está em produção ou teste
    var $isProducao = false; 
    
    // codificacao e lingua
    private $enc;
    private $lang;
    // nome da sessão e da aplicação
    private $session_name;
    private $app_name;
    
    public function __construct() {
        $this->session_name = "ufu";
        $this->app_name = "Laboratorio Virtual UFU";
        $oConstantsConfig = new ConstantsConfig();
        $oConstants = new Constants();
        
        $this->enc = 'pt_BR.UTF-8';
        $this->lang = 'pt_br';

        session_name($this->session_name);
        session_start();
        
        $this->defineConstants();
        $this->defineLang();
    }

    public function defineLang($enc = null, $lang = null) {
        // codificacao e language - depois do session_start
        setlocale(LC_ALL, ($enc) ? $enc : $this->enc);
        Language::setLanguage(($lang) ? $lang : $this->lang);
    }

    public function defineConstants() {
        date_default_timezone_set('America/Belem');

        define("SESSION_NAME", $this->session_name); 
        define("APPLICATION_NAME", $this->app_name); 

        
    }

}

?>