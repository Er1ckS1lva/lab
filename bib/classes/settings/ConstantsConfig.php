<?php

class ConstantsConfig {

    public function __construct($isProducao = false) {
        if ($isProducao) {
            $this->defineConstantesProducao();
        } else {
            $this->defineConstantesLocal();
        }
    }

    private function defineConstantesLocal() {
        define("URL", Util::urlAutomatica(true));

        define("CONFIG_HOST", 'localhost');
		define("CONFIG_PORTA", '3306');
        define("CONFIG_DBNAME", 'lab2');
        define("CONFIG_USER", 'root');
        define("CONFIG_PASSWORD", 'espectograma');
		define("CONFIG_CHARSET", 'utf8');
		
	# email
	define("EMAIL_USERNAME", "labvirtual@ileel.ufu.br");
	define("EMAIL_PASSWORD", "lab2018virtual");
	define("EMAIL_CHARSET", "UTF-8");
	define("EMAIL_PORTA", "587");
	define("EMAIL_CRIPTOGRAFIA", "tls");
	define("SMTP_HOST", "smtp.ufu.br"); # se tiver
    }

    private function defineConstantesProducao() {
        define("URL", "http://" . $_SERVER['SERVER_NAME'] . "/");

        define("CONFIG_HOST", 'localhost');
		define("CONFIG_PORTA", '3306');
        define("CONFIG_DBNAME", '');
        define("CONFIG_USER", '');
        define("CONFIG_PASSWORD", '');
		define("CONFIG_CHARSET", 'utf8');
		
	# email
	define("EMAIL_USERNAME", "labvirtual@ileel.ufu.br");
	define("EMAIL_PASSWORD", "lab2018virtual");
	define("EMAIL_CHARSET", "UTF-8");
	define("EMAIL_PORTA", "587");
	define("EMAIL_CRIPTOGRAFIA", "tls");
	define("SMTP_HOST", "smtp.ufu.br"); # se tiver
    }

}

?>