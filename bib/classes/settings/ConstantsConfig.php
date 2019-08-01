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

        define("CONFIG_HOST", '192.168.1.4');
        define("CONFIG_PORTA", '3306');
        define("CONFIG_DBNAME", 'laboratoriovirtual_ufu');
//        define("CONFIG_DBNAME", 'laboratoriovirtual_ufu_cliente');
        define("CONFIG_USER", 'root');
        define("CONFIG_PASSWORD", '321321');
        define("CONFIG_CHARSET", 'utf8');

        # email
        define("EMAIL_USERNAME", "labvirtual@ileel.ufu.br");
        define("EMAIL_PASSWORD", "lab2018virtual");
        define("EMAIL_CHARSET", "UTF-8");
        define("EMAIL_PORTA", "587");
        define("EMAIL_CRIPTOGRAFIA", "tls");
        define("SMTP_HOST", "smtp.ufu.br"); # se tiver

        define("LOCAL_CAMERA", IGENIAL_ROOT_DIR . "/upload");
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
        define("EMAIL_USERNAME", "");
        define("EMAIL_PASSWORD", "");
        define("EMAIL_CHARSET", "UTF-8");
        define("EMAIL_PORTA", "587");
        define("EMAIL_CRIPTOGRAFIA", "");
        define("SMTP_HOST", ""); # se tiver

        define("LOCAL_CAMERA", "/home/html/facialRecognitionLogin");
    }

}

?>