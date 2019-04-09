<?php

class UtilParent {

    protected $msg;

    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($e) {
        $this->msg = ExceptionHandler::getMessage($e);
    }

    /**
     * Função para detecção automatica da constante URL através do IGENIAL_ROOT_DIR e das variaveis do 
     * $_SERVER  SERVER_PORT,DOCUMENT_ROOT e SERVER_NAME, seu uso é opcional
     * @author Marcelo Silva <mwssilva@gmail.com>
     * @param boolean $full retornar a url completa ou relativa
     * @return string a url completa ou relativa.
     */
    public static function urlAutomatica($full = false) {
        $port = $_SERVER['SERVER_PORT'];
        $context = str_replace(
                array(realpath($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR, "\\"), array('', '/')
                , IGENIAL_ROOT_DIR
        );
        $path = "/" . ($context != str_replace('\\', '/', IGENIAL_ROOT_DIR) ? $context . '/' : '');

        $server_name = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['SERVER_NAME'];
        $isHttps = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) );
        $isForwardedHttps = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
        $protocol = ( $isHttps || $isForwardedHttps ) ? 'https://' : 'http://';
        $defaultPorts = array('http://' => '80', 'https://' => '443');

        if ($full)
            return $protocol . $server_name . ($port != $defaultPorts[$protocol] ? ":$port" : '') . $path;
        else
            return $path;
    }

    public static function validaLogin($x) {
        return ereg("^([a-z])([a-z_0-9]){1,23}([a-z0-9])$", $x);
    }

    public static function alternaAtivo($ativo) {
        switch ($ativo) {
            case "S":
                return "N";
                break;
            case "N":
                return "S";
                break;
            default:
                return "S";
                break;
        }
    }

    public static function recuperaNomeEntidade($entidade) {
        $oEntities = new Entities();
        $entidades = $oEntities->getEntities();
        foreach ($entidades as $index => $e) {
            if (strcasecmp($entidade, $e) == 0) {
                return $entidades[$index];
            }
        }
        return $entidade;
    }

    public static function recuperaNomeMetodo($controller, $metodo) {
        $metodos = get_class_methods($controller);
        foreach ($metodos as $index => $m) {
            if (strcasecmp($metodo, $m) == 0) {
                return $metodos[$index];
            }
        }
        return false;
    }

    //TODO: avaliar esta função
    public static function getAdmPageDelHandlerCurrPage($resultsInPage, $currentPage) {
        $delHandlerCurrPage = 0;
        if ((int) $resultsInPage < 2) {
            if ((int) $currentPage == 1)
                $delHandlerCurrPage = $currentPage;
            else
                $delHandlerCurrPage = ((int) $currentPage - 1);
        }
        else {
            $delHandlerCurrPage = ((int) $currentPage);
        }
        return $delHandlerCurrPage;
    }

    public static function latin2utf($text) {
        $text = htmlentities($text, ENT_COMPAT, 'ISO-8859-1');
        return html_entity_decode($text, ENT_COMPAT, 'UTF-8');
    }

    public static function utf2latin($text) {
        $text = htmlentities($text, ENT_COMPAT, 'UTF-8');
        return html_entity_decode($text, ENT_COMPAT, 'ISO-8859-1');
    }

    //TODO: avaliar esta função
    public static function retornaEstados() {
        return array("AC", "AL", "AP", "AM", "BA", "CE", "DF",
            "ES", "GO", "MA", "MT", "MS", "MG", "PA",
            "PB", "PR", "PE", "PI", "RJ", "RN", "RS",
            "RO", "RR", "SC", "SP", "SE", "TO");
    }

    public static function eliminarAcentos($var) {
        $var = preg_replace('/[ÁÀÂÃ]/u', "A", $var);
        $var = preg_replace('/[áàâã]/u', "a", $var);
        $var = preg_replace('/[ÉÈÊ]/u', "E", $var);
        $var = preg_replace('/[éèê]/u', "e", $var);
        $var = preg_replace('/[ÍÌÎ]/u', "I", $var);
        $var = preg_replace('/[íìî]/u', "i", $var);
        $var = preg_replace('/[ÓÒÔÕ]/u', "O", $var);
        $var = preg_replace('/[óòôõ]/u', "o", $var);
        $var = preg_replace('/[ÚÙÛÜ]/u', "U", $var);
        $var = preg_replace('/[úùûü]/u', "u", $var);
        $var = str_replace("Ç", "C", $var);
        $var = str_replace("ç", "c", $var);
        return $var;
    }

    public static function diferencaMeses($mesInicio, $mesFim) {
        $vetInicio = explode("/", $mesInicio);
        $vetFim = explode("/", $mesFim);

        $dataInicio = mktime(0, 0, 0, (int) $vetInicio[1], 0, (int) $vetInicio[2]);
        $dataFim = mktime(0, 0, 0, (int) $vetFim[1], 0, (int) $vetFim[2]);
        $meses = ($dataFim - $dataInicio) / 2592000;
        $meses = round($meses);
        return $meses;
    }

    public static function retornarDataPhp($data) {
        $vetInicio = explode("/", $data);
        $dataInicio = mktime(0, 0, 0, (int) $vetInicio[1], (int) $vetInicio[0], (int) $vetInicio[2]);
        return $dataInicio;
    }

    public static function diferencaDataEmDias($data1, $data2) {
        $hora1 = $minuto1 = $segundo1 = $hora2 = $minuto2 = $segundo2 = 0;
        if (strpos(" ", $data1) === FALSE && strpos("T", $data1) === FALSE) {
            $vetInicio = explode("/", $data1);
        } else {
            $indexHourStart = strpos($data1, ' ') === FALSE ? strpos($data1, 'T') : strpos($data1, ' ');
            $vetInicio = explode("/", $data1);
            list($hora1, $minuto1, $segundo1) = explode(":", substr($data1, $indexHourStart + 1, 8));
        }

        if (strpos(" ", $data2) === FALSE && strpos("T", $data2) === FALSE) {
            $vetFim = explode("/", $data2);
        } else {
            $indexHourStart = strpos($data2, ' ') === FALSE ? strpos($data2, 'T') : strpos($data2, ' ');
            $vetInicio = explode("/", $data2);
            list($hora2, $minuto2, $segundo2) = explode(":", substr($data2, $indexHourStart + 1, 8));
        }

        $dataInicio = mktime($hora1, $minuto1, $segundo1, (int) $vetInicio[1], (int) $vetInicio[0], (int) $vetInicio[2]);
        $dataFim = mktime($hora2, $minuto2, $segundo2, (int) $vetFim[1], (int) $vetFim[0], (int) $vetFim[2]);
        $dias = ($dataFim - $dataInicio) / 86400;
        $dias = round($dias) + 1;
        return $dias;
    }

    public static function recuperarUltimoDiaMes($ano, $mes) {
        if ($mes == "2") {
            $dia = "28";
            $resto = $ano % 4;
            if ((int) $resto == 0)
                $dia = "29";
        }
        else if (($mes == "1") or ($mes == "3") or ($mes == "5") or ($mes == "7") or ($mes == "8") or ($mes == "10") or ($mes == "12")) {
            $dia = "31";
        } else if (($mes == "4") or ($mes == "6") or ($mes == "9") or ($mes == "11")) {
            $dia = "30";
        }

        $data = $dia . "/" . $mes . "/" . $ano;
        return $data;
    }

    public static function retornaMesExtenso($mes) {
        $regMes = Util::retornaMesesExtenso();
        return $regMes[$mes - 1];
    }

    public static function retornaMesesExtenso() {
        return array("Janeiro", "Fevereiro", "Março", "Abril",
            "Maio", "Junho", "Julho", "Agosto", "Setembro",
            "Outubro", "Novembro", "Dezembro");
    }

    public static function transformaData($data, $formato = 'mysql2normal', $hour = null) {
        if ($hour) {
            $indexHourStart = strpos($data, ' ') === FALSE ? strpos($data, 'T') : strpos($data, ' ');
            if ($indexHourStart !== false) {
                $hour = substr($data, $indexHourStart + 1, 8);
                $data = substr($data, 0, $indexHourStart);
            }
        } else {
            $data = substr($data, 0, 10);
        }
        switch ($formato) {
            case 'mysql2normal':
                $returnDate = join("/", array_reverse(explode("-", $data)));
                break;
            case 'normal2mysql':
                $returnDate = join("-", array_reverse(explode("/", $data)));
                break;
            default:
                return false;
        }
        return $returnDate . ($hour != null ? ' ' . $hour : '');
    }

    /**
     * Função melhorada de comparação de datas onde você decide qual a comparação utilizar
     * @param string $primeiraData uma data no formato dd/mm/aaaa ou aaaa-mm-dd
     * @param string $operador o operador de comparação, podendo este ser >, >=, <, <=, == ou !=
     * @param string $segundaData uma data no formato dd/mm/aaaa ou aaaa-mm-dd, caso não seja informado a função utiliza a data atual
     * @return boolean true caso a comparação seja verdadeira, false caso contrário.
     */
    public static function comparaData($primeiraData, $operador = ">", $segundaData = NULL) {
        if (strpos($primeiraData, "-") !== false) {
            $primeiraData = Util::transformaData($primeiraData);
        }
        $vetPrimeiraData = explode("/", $primeiraData);
        $auxPrimeiraData = mktime(0, 0, 0, $vetPrimeiraData[1], $vetPrimeiraData[0], $vetPrimeiraData[2]);

        if (strpos($segundaData, "-") !== false) {
            $segundaData = Util::transformaData($segundaData);
        }
        if ($segundaData === NULL) {
            $segundaData = date("d/m/Y");
        }
        $vetSegundaData = explode("/", $segundaData);
        $auxSegundaData = mktime(0, 0, 0, $vetSegundaData[1], $vetSegundaData[0], $vetSegundaData[2]);

        eval("\$resultado = (\$auxPrimeiraData {$operador} \$auxSegundaData);");
        return $resultado;
    }

    public static function verificarDataEntreIntervalo($dataInicio, $dataTermino, $dataConsultaInicio, $dataConsultaTermino) {
        $vetDataInicio = explode("/", $dataInicio);
        $auxDataInicio = mktime(0, 0, 0, $vetDataInicio[1], $vetDataInicio[0], $vetDataInicio[2]);

        $vetDataTermino = explode("/", $dataTermino);
        $auxDataTermino = mktime(0, 0, 0, $vetDataTermino[1], $vetDataTermino[0], $vetDataTermino[2]);

        $vetDataConsultaInicio = explode("/", $dataConsultaInicio);
        $auxDataConsultaInicio = mktime(0, 0, 0, $vetDataConsultaInicio[1], $vetDataConsultaInicio[0], $vetDataConsultaInicio[2]);

        if ($dataConsultaTermino != "") {
            $vetDataConsultaTermino = explode("/", $dataConsultaTermino);
            $auxDataConsultaTermino = mktime(0, 0, 0, $vetDataConsultaTermino[1], $vetDataConsultaTermino[0], $vetDataConsultaTermino[2]);
        }

        //1
        if (($auxDataConsultaInicio >= $auxDataInicio) and ($auxDataConsultaInicio <= $auxDataTermino)) {
            return true;
        }

        if ($dataConsultaTermino != "") {
            //2
            if (($auxDataConsultaTermino >= $auxDataInicio) and ($auxDataConsultaTermino <= $auxDataTermino)) {
                return true;
            }
        } else
            return false;
    }

    public static function diferencaEntreDias($date_ini, $date_end, $round = 0) {
        $array_temp = explode("/", $date_ini);
        $date_inir = $array_temp[2] . "/" . $array_temp[1] . "/" . $array_temp[0];

        $array_temp = explode("/", $date_end);
        $date_endr = $array_temp[2] . "/" . $array_temp[1] . "/" . $array_temp[0];

        $date_inir = strtotime($date_inir);
        $date_endr = strtotime($date_endr);

        $date_diff = ($date_endr - $date_inir) / 86400;

        if ($round != 0)
            return floor($date_diff);
        else
            return $date_diff;
    }

    public static function formatarDataOracle($data) {
        $vetInicio = explode(" ", $data);
        switch ($vetInicio[0]) {
            case 'Jan': $mes = "01";
                break;
            case 'Feb': $mes = "02";
                break;
            case 'Fev': $mes = "02";
                break;
            case 'Mar': $mes = "03";
                break;
            case 'Apr': $mes = "04";
                break;
            case 'Abr': $mes = "04";
                break;
            case 'Mai': $mes = "05";
                break;
            case 'May': $mes = "05";
                break;
            case 'Jun': $mes = "06";
                break;
            case 'Jul': $mes = "07";
                break;
            case 'Ago': $mes = "08";
                break;
            case 'Sep': $mes = "09";
                break;
            case 'Set': $mes = "09";
                break;
            case 'Oct': $mes = "10";
                break;
            case 'Out': $mes = "10";
                break;
            case 'Nov': $mes = "11";
                break;
            case 'Dec': $mes = "12";
                break;
            case 'Dez': $mes = "12";
                break;


            default: $mes = $vetInicio[0];
        }

        $ret = $vetInicio[1] . "/" . $mes . "/" . $vetInicio[2] . " ás " . $vetInicio[count($vetInicio) - 1];
        return $ret;
    }

    public static function removeCaractere($str) {
        $str = str_split($str);
        $str_aux = "";

        for ($i = 0; $i < sizeof($str); $i++) {
            if (!ctype_cntrl($str[$i])) {
                $str_aux .= $str[$i];
            }
        }
        return $str_aux;
    }

    //TODO: avaliar esta função
    public static function convertDataSaida($data) {
        $a1 = explode(" ", $data);
        $a2 = explode("-", $a1[0]);
        return $a2[2] . "/" . $a2[1] . "/" . $a2[0];
    }

//TODO: avaliar esta função (aparentemente ja tem no validate???? se sim, e for igual, remover)
    public static function validaData($data, $formato = 'normal') {
        switch ($formato) {
            case 'normal':
                $vet = explode("/", $data);
                return checkdate((int) $vet[1], (int) $vet[0], (int) $vet[2]);
                break;
            case 'mysql':
                $vet = explode("-", $data);
                return checkdate((int) $vet[1], (int) $vet[2], (int) $vet[0]);
                break;
            default: return false;
        }
    }

//TODO: avaliar esta função (pode ir pro validate? não muda nunca afinal, verificar se o metodo preg match esta depreciando ou há um melhor)
    public static function validaEmail($email) {
        // Presume that the email is invalid
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        // Run the preg_match() function on regex against the email address
        if (preg_match($regex, $email)) {
            return true;
        } else {
            return false;
        }
    }

//TODO: avaliar esta função (pode ser passada condicionalmente na funcao acima) (além de a funcao eregi estar depreciada)
    public static function validaEmailInstitucional($email) {
        // Create  the syntactical validation regular expression
        $regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@(sufiixo.com.br)$";
        // Presume that the email is invalid
        $valid = 0;
        // Validate the syntax
        if (eregi($regexp, $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validaNumeros($numero) {
        $validar_numeros = "^([0-9])$";
        if (is_numeric($numero)) {
            return true;
        } else {
            return false;
        }
    }

    // testa cic/cpf se realmente é valido
    public static function validaCpf($cpf) {
        if ($cpf == "11111111111" or $cpf == "22222222222" or $cpf == "33333333333" or $cpf == "44444444444" or $cpf == "55555555555" or $cpf ==
                "66666666666" or $cpf == "77777777777" or $cpf == "88888888888" or $cpf == "99999999999" or $cpf == "00000000000") {
            return false;
        }

        for ($digpos = 10; $digpos < 12; $digpos++) {
            $dig = 0;
            $pos = 0;
            for ($fator = $digpos; $fator > 1; $fator--) {
                $dig = $dig + substr($cpf, $pos, 1) * $fator;
                $pos++;
            }
            if (11 - ($dig % 11) < 10) {
                $dig = 11 - ($dig % 11);
            } else {
                $dig = 0;
            }
            if ($dig != substr($cpf, $digpos - 1, 1)) {
                return false;
            }
        }
        return true;
    }

//TODO: avaliar esta função (esta função é inútil, quem diabos fez isso...?)
    public static function envia_email($confirmar_email) {
        if ($confirmar_email == true) {
            return true;
            exit;
        } else {
            return false;
            exit;
        }
    }

    public static function validaHora($hora) {
        return ereg("^([0-9]){2}:([0-9]){2}$", $hora);
    }

    public static function preencherCaracteres($texto, $car, $tamanho) {
        $ret = $texto;
        for ($i = strlen($texto); $i < $tamanho; $i++) {
            $ret .=$car;
        }
        return $ret;
    }

//TODO: avaliar esta função (mellhorar o nome, note que ela é usada no gerador, mudar lá também)
    public static function convertDecimalIn($decimal) {
        $decimal = str_replace('.', '', $decimal);
        $decimal = str_replace(',', '.', $decimal);
        return $decimal;
    }

//TODO: avaliar esta função (mellhorar o nome, note que ela é usada no gerador, mudar lá também)
    public static function convertDecimalOut($decimal) {
        $decimal = str_replace('.', ',', $decimal);
//        $decimal = str_replace(',', '.', $decimal);
        return $decimal;
    }

    public static function formatDecimalOut($decimal, $casas = 2) {
        return number_format($decimal, $casas, ',', '.');
    }

    public static function debug($var, $is_exitable = true) {
        echo"<pre>";
        print_r($var);
        echo"</pre>";
        if ($is_exitable) {
            exit();
        }
    }

    public static function maskCpf($cpf) {
        $cpfPt1 = substr($cpf, 0, 3);
        $cpfPt2 = substr($cpf, 3, 3);
        $cpfPt3 = substr($cpf, 6, 3);
        $cpfPt4 = substr($cpf, 9, 3);
        $cpfMasked = $cpfPt1 . "." . $cpfPt2 . "." . $cpfPt3 . "-" . $cpfPt4;
        return $cpfMasked;
    }

    public static function maskCnpj($cnpj) {
        $cnpjPt1 = substr($cnpj, 0, 2);
        $cnpjPt2 = substr($cnpj, 2, 3);
        $cnpjPt3 = substr($cnpj, 5, 3);
        $cnpjPt4 = substr($cnpj, 8, 4);
        $cnpjPt5 = substr($cnpj, 12, 2);
        $cnpjMasked = $cnpjPt1 . "." . $cnpjPt2 . "." . $cnpjPt3 . "/" . $cnpjPt4 . "-" . $cnpjPt5;
        return $cnpjMasked;
    }

    public static function unMaskCpf($cpf) {
        $cpfUnMasked = str_replace(array(".", "-"), array("", ""), $cpf);
        return $cpfUnMasked;
    }

    public static function unMaskCnpj($cnpj) {
        $cnpjUnMasked = str_replace(array(".", "/", "-"), array("", "", ""), $cnpj);
        return $cnpjUnMasked;
    }

    public static function maskCep($cep) {
        $cep1 = substr($cep, 0, 5);
        $cep2 = substr($cep, 0, 3);
        $cepMasked = $cep1 . "-" . $cep2;
        return $cepMasked;
    }

    public static function unMaskCep($cep) {
        $cepUnMasked = str_replace(array("-"), array(""), $cep);
        return $cepUnMasked;
    }

    public static function maskPhone($phone) {
        $phone1 = substr($phone, 0, 2); // codigo da operadora
        $phone2 = substr($phone, 2, 4); // tel parte 1
        $phone3 = substr($phone, 5, 4); // tel parte 1
        $phoneMasked = "(" . $phone1 . ") " . $phone2 . "-" . $phone3;
        return $phoneMasked;
    }

    public static function unMaskPhone($phone) {        
        $phoneUnMasked = str_replace(array("(", ")", " ", "-"), array("", "", "", ""), $phone);
        return $phoneUnMasked;
    }

    public static function validaCnpj($cnpj) {

        $RecebeCNPJ = $cnpj;
        $s = "";
        for ($x = 1; $x <= strlen($RecebeCNPJ); $x = $x + 1) {
            $ch = substr($RecebeCNPJ, $x - 1, 1);
            if (ord($ch) >= 48 && ord($ch) <= 57) {
                $s = $s . $ch;
            }
        }

        $RecebeCNPJ = $s;
        if ($RecebeCNPJ == "00000000000000") {
            return false;
        } else {
            $Numero[1] = intval(substr($RecebeCNPJ, 1 - 1, 1));
            $Numero[2] = intval(substr($RecebeCNPJ, 2 - 1, 1));
            $Numero[3] = intval(substr($RecebeCNPJ, 3 - 1, 1));
            $Numero[4] = intval(substr($RecebeCNPJ, 4 - 1, 1));
            $Numero[5] = intval(substr($RecebeCNPJ, 5 - 1, 1));
            $Numero[6] = intval(substr($RecebeCNPJ, 6 - 1, 1));
            $Numero[7] = intval(substr($RecebeCNPJ, 7 - 1, 1));
            $Numero[8] = intval(substr($RecebeCNPJ, 8 - 1, 1));
            $Numero[9] = intval(substr($RecebeCNPJ, 9 - 1, 1));
            $Numero[10] = intval(substr($RecebeCNPJ, 10 - 1, 1));
            $Numero[11] = intval(substr($RecebeCNPJ, 11 - 1, 1));
            $Numero[12] = intval(substr($RecebeCNPJ, 12 - 1, 1));
            $Numero[13] = intval(substr($RecebeCNPJ, 13 - 1, 1));
            $Numero[14] = intval(substr($RecebeCNPJ, 14 - 1, 1));

            $soma = $Numero[1] * 5 + $Numero[2] * 4 + $Numero[3] * 3 + $Numero[4] * 2 + $Numero[5] * 9 + $Numero[6] * 8 + $Numero[7] * 7 +
                    $Numero[8] * 6 + $Numero[9] * 5 + $Numero[10] * 4 + $Numero[11] * 3 + $Numero[12] * 2;

            $soma = $soma - (11 * (intval($soma / 11)));

            if ($soma == 0 || $soma == 1) {
                $resultado1 = 0;
            } else {
                $resultado1 = 11 - $soma;
            }

            if ($resultado1 == $Numero[13]) {
                $soma = $Numero[1] * 6 + $Numero[2] * 5 + $Numero[3] * 4 + $Numero[4] * 3 + $Numero[5] * 2 + $Numero[6] * 9 +
                        $Numero[7] * 8 + $Numero[8] * 7 + $Numero[9] * 6 + $Numero[10] * 5 + $Numero[11] * 4 + $Numero[12] * 3 + $Numero[13] * 2;
                $soma = $soma - (11 * (intval($soma / 11)));
                if ($soma == 0 || $soma == 1) {
                    $resultado2 = 0;
                } else {
                    $resultado2 = 11 - $soma;
                }

                if ($resultado2 == $Numero[14]) {
                    return true; // cnpj ok?
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        //Fim do validar CNPJ
        return false;
    }

//TODO: avaliar esta função
    public static function isCpfOrCnpj($valor) {
        if (Util::validaCpf(Util::unMaskCpf($valor)))
            return 'f';
        if (Util::validaCnpj($valor))
            return 'j';
        return '';
    }

    /* para imagens */

    public static function recuperaExtensaoImagem() {
        return array('jpeg', 'jpg', 'gif', 'png');
    }

    public static function recuperaTipoImagem() {
        return array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/pjpeg');
    }

    public static function recuperaTamanhoImagem() {
        return 2097152;
    }

    /* para banner */

    public static function recuperaExtensaoBanner() {
        return array('jpeg', 'jpg', 'gif', 'png', 'swf');
    }

    public static function recuperaTipoBanner() {
        return array('image/jpeg', 'image/gif', 'image/png', 'application/x-shockwave-flash');
    }

    public static function recuperaTamanhoBanner() {
        return 2097152;
    }

    /* para audio */

    public static function recuperaExtensaoAudio() {
        return array('mp3', 'wma', 'aac');
    }

    public static function recuperaTipoAudio() {
        return array('audio/mpeg', 'audio/x-ms-wma', 'audio/aac');
    }

    public static function recuperaTamanhoAudio() {
        return 2097152;
    }

    /* para video */

    public static function recuperaExtensaoVideo() {
        return array('flv', 'mp4', 'h264');
    }

    public static function recuperaTipoVideo() {
        return array('application/octet-stream', 'video/mp4');
    }

    public static function recuperaTamanhoVideo() {
        return 2097152;
    }

    public static function porcentual($valor, $percentual) {
        $percentual = $percentual / 100;
        $valor_final = $valor - ($percentual * $valor);
        return number_format($valor_final, 2, ',', '');
    }

    function percentual($valor, $valores) {
        $total = 0;
        $per = 0;
        foreach ($valores as $v) {
            $total += $v;
        }
        if ($total) {
            $porcentual = 100 / $total;
        }
        for ($i = 0; $i < $valor; $i++) {
            $per += $porcentual;
        }
        return number_format($per, 2, '.', '');
    }

    // validacao url e/ou link
    public static function validarUrl($url) {
        return preg_match('|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }

    public static function retornaTipoArquivo($nome_arquivo) {
        $tp = explode('.', $nome_arquivo);
        $tp = $tp[count($tp) - 1];
        return $tp;
    }

//TODO: avaliar esta função (doctrine ja faz isso, mas se escrevermos um SQL?)
    public static function trataPalavraConsulta($var) {
        $remover = array("SELECT", "FROM", 'WHERE', 'DROP', 'TABLE', '');
        foreach ($remover as $palavra) {
            $var = str_replace($palavra, '', $var);
        }
        return $var;
    }

    public static function acentosCaixaAlta($var) {
        $baixa = array("á", "à", "â", "ã", "é", "è", "ê", "í", "ì", "î", "ó", "ò", "ô", "õ", "ú", "ù", "û", "ü", "ç");
        $alta = array("Á", "À", "Â", "Ã", "É", "È", "Ê", "Í", "Ì", "Î", "Ó", "Ò", "Ô", "Õ", "Ú", "Ù", "Û", "Ü", "Ç");
        foreach ($baixa as $index => $letra) {
            $var = preg_replace("/{$letra}/", $alta[$index], $var);
        }
        return strtoupper($var);
    }

    public static function limitaString($texto, $tamanho = 200) {
        if (strlen($texto) > $tamanho) {
            $string = mb_substr(strip_tags(html_entity_decode($texto, false, "UTF-8")), 0, ($tamanho - 3), 'UTF-8') . "...";
        } else {
            $string = $texto;
        }
        return $string;
    }

    /**
     *
     * @param string $consulta é a string da consulta
     * @param array $colunas é (ou pode não ser) um vetor com as colunas
     * @return string uma clausula com as condições repassadas
     *  exemplo de uso $sql = "SELECT * FROM tabela WHERE condicao1=true AND (".montaCondicaoSqlConsultaSite('poder executivo', array('titulo','chamada')).")";
     */
    public static function montaCondicaoSqlConsultaSite($consulta, $colunas) {
        $array_consulta = split(" ", $consulta);
        $where = array();
        if (!is_array($colunas)) {
            $colunas = array($colunas);
        }
        foreach ($array_consulta as $busca) {
            if (strlen(trim($busca)) > 0) {
                $linha_sql = array();
                foreach ($colunas as $c) {
                    $linha_sql[] = "( $c like '%$busca %' OR $c like '% $busca %' OR $c like '% $busca%' OR $c like '$busca' ) \n";
                }
                $where[] = join(" OR ", $linha_sql);
            }
        }
        $linha_sql = array();
        foreach ($colunas as $c) {
            $linha_sql[] = "( $c like '%$consulta %' OR $c like '% $consulta %' OR $c like '% $consulta%' OR $c like '$consulta' ) \n";
        }
        $where[] = join(" OR ", $linha_sql);
        return join(" OR ", $where);
    }

    public static function diaSemana($data) {
        $ano = substr("$data", 0, 4);
        $mes = substr("$data", 5, -3);
        $dia = substr("$data", 8, 9);

        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

        switch ($diasemana) {
            case"0": $diasemana = "DOM";
                break;
            case"1": $diasemana = "SEG";
                break;
            case"2": $diasemana = "TER";
                break;
            case"3": $diasemana = "QUA";
                break;
            case"4": $diasemana = "QUI";
                break;
            case"5": $diasemana = "SEX";
                break;
            case"6": $diasemana = "SÁB";
                break;
        }

        return "$diasemana";
    }

    public static function diaSemanaExtenso($data) {
        $ano = substr("$data", 0, 4);
        $mes = substr("$data", 5, -3);
        $dia = substr("$data", 8, 9);

        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

        switch ($diasemana) {
            case"0": $diasemana = "DOMINGO";
                break;
            case"1": $diasemana = "SEGUNDA";
                break;
            case"2": $diasemana = "TERÇA";
                break;
            case"3": $diasemana = "QUARTA";
                break;
            case"4": $diasemana = "QUINTA";
                break;
            case"5": $diasemana = "SEXTA";
                break;
            case"6": $diasemana = "SÁBADO";
                break;
        }

        return "$diasemana";
    }

//TODO: avaliar esta função (não sei onde ela está sendo usada, ou se está)
    function recuperaArrayId() {
        $tmp = explode('&', $o);
        $keys = array();
        $values = array();
        foreach ($tmp as $t) {
            if ($t) {
                $tmp2 = explode('=', str_replace("&", "", $t));
                $keys[] = $tmp2[0];
                $values[] = $tmp2[1];
            }
        }
    }

    public static function verificaCodificacao($string, $convert = false) {
        if ($convert) {
            if (mb_detect_encoding($string, 'UTF-8, ISO-8859-1') == "UTF-8") {
                return $string;
            } else {
                return utf8_encode($string);
            }
        }
        return mb_detect_encoding($string, 'UTF-8, ISO-8859-1');
    }

    static function geraHash($tamanho = 256) {
        $silabas_caixa_baixa = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $silabas_caixa_alta = Util::array_change_value_case($silabas_caixa_baixa, CASE_UPPER);
        $silabas = array_merge($silabas_caixa_baixa, $silabas_caixa_alta);
        $numeros = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $hash = "";
        for ($i = 0; $i < $tamanho; $i++) {
            if (rand(0, 1)) {
                $hash .= $silabas[rand(0, count($silabas) - 1)];
            } else {
                $hash .= $numeros[rand(0, count($numeros) - 1)];
            }
        }
        return $hash;
    }

    static function array_change_value_case($input, $case = CASE_LOWER) {
        $aRet = array();

        if (!is_array($input)) {
            return $aRet;
        }

        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $aRet[$key] = array_change_value_case($value, $case);
                continue;
            }

            $aRet[$key] = ($case == CASE_UPPER ? strtoupper($value) : strtolower($value));
        }

        return $aRet;
    }

    public static function convertDataOut($data, $time = false) {
        $ret = "";
        if ($data)
            if ($time)
                $ret = $data->format('d/m/Y H:i:s');
            else
                $ret = $data->format("d/m/Y");
        return $ret;
    }

    public static function convertTimeOut($time) {
        $ret = "";
        if ($time)
            $ret = $time->format('H:i:s');
        return $ret;
    }

    public static function calculaPorcentual($valor, $percentual) {
        $valor_final = ($valor * $percentual) / 100;
        return number_format($valor_final, 2, ',', '');
    }
	
	public static function mailSystem($mailTitle, $mailContent, $aEmail, $smtp = false, $vArquivo = null) {
        ### $aEmail = array(email => nome); mas pode ser somente: $aEmail = array(email)        
        
        if (in_array(CONFIG_HOST, array("192.168.1.4"))) {
            # se não tiver publicado nao envia e-mail
//            return true;
        }

        try {
            # validando
            if (!$mailTitle) {
                throw new Exception("Sem título do e-mail informado!");
            }
            if (!$mailContent) {
                throw new Exception("Sem conteúdo no e-mail informado!!");
            }
            if (count($aEmail) < 1) {
                throw new Exception("Sem e-mails informado!!!");
            }


            require_once IGENIAL_ROOT_DIR . '/ext/phpmailer/class.phpmailer.php';
            $mail = new PHPMailer(true);

            if ($smtp === true) {
                # SMTP QUANDO NECESSARIO CONFIG -> EMAIL_CRIPTOGRAFIA
                require_once IGENIAL_ROOT_DIR . '/ext/phpmailer/class.smtp.php';
                $mail->IsSMTP();
                $mail->SMTPSecure = EMAIL_CRIPTOGRAFIA;
                $mail->Host = SMTP_HOST;
                $mail->SMTPDebug = 0;
                $mail->SMTPAuth = true;
            }else{
                $mail->IsMail(); // para testar local com fakeSendMail
            }
            $mail->Port = EMAIL_PORTA;
            $mail->Username = EMAIL_USERNAME;
            $mail->Password = EMAIL_PASSWORD;
            $mail->From = EMAIL_USERNAME;
            $mail->FromName = APPLICATION_NAME;
            $mail->IsHTML(true);
            $mail->CharSet = EMAIL_CHARSET;
            $mail->Subject = $mailTitle;
            $mail->Body = $mailContent;
            $mail->AltBody = strip_tags($mailContent);

            if ($vArquivo) {
                foreach ($vArquivo as $arquivo) {
                    $mail->addAttachment($arquivo['tmp_name'], $arquivo['name'], 'base64', $arquivo['type']);
                }
            }
            foreach ($aEmail as $email => $nome) {
                if ($email) {
                    if ($nome) {
                        $mail->AddBCC($email, $nome);
                    } else {
                        $mail->AddBCC($email);
                    }
                }
            }
            $mail->Send();
        } catch (Exception $ex) {
            throw new Exception("Não foi possível enviar o e-mail devido à: " . $ex->getMessage());
        }
    }
	
	public static function str2Upper($str) {
        return strtr(strtoupper($str), 'àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ', 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß');
    }
	
	public static function alfabetoExcel($quantidade = 26, $bAlta = true) {
        $letras = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $letrasRet = $letras;

        if ($bAlta) {
            $letrasRet = Util::array_change_value_case($letras, CASE_UPPER);
        }

        $mod = $quantidade % 26;
        if ($mod) {
            $letras = array();
            $aAlfabetoAgain = Util::alfabetoExcel();
            for ($j = 0; $j < ($mod); $j++) {
                for ($i = 0; $i < count($letrasRet); $i++) {
                    $letras[] = "{$letrasRet[$j]}" . $aAlfabetoAgain[$i];
                }
            }
            $letrasRet = array_merge($letrasRet, $letras);
        }

        return array_slice($letrasRet, 0, $quantidade);
    }

    public static function relXls($objects, $aTableHeader, $title, $class = NULL, $name = APPLICATION_NAME) {
        /* EX table header - cabecalho:
         * type: fk, date, sim/nao, ""
          $aTableHeader = array(
            "campo" => array("type" => null, "title" => "interfacename", "value" => ""),
         * 
            $k = array("type" => "fk", "title" => $aField["columnDefinition"], "value" => "campo_fk"),
            $k = array("type" => "date", "title" => $aField["columnDefinition"], "value" => "date_value"),
            $k = array("type" => "sim/nao", "title" => $aField["columnDefinition"], "value" => Action::getValuesFor()),
          );
         */

        set_time_limit(0);
        if ($class) {
            eval("\$action = new {$class}();");
        }

        include_once(IGENIAL_ROOT_DIR . "/ext/PHPExcel_1.8.0_doc/Classes/PHPExcel.php");
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator($name)
                ->setTitle($name)
                ->setDescription("Documento gerado no sistema " . $name)
                ->setKeywords("office 2007 openxml php xls xlsx csv sgatt");

        // colunas, cabecalho e letra por colua
        $colunas = array_keys($aTableHeader);
        $colunasNames = array_flip($colunas);
        $aAlfabeto = Util::alfabetoExcel(count($colunas));
        $linhaCabecalho = 1;
        $iTitle = 0;
        foreach ($aTableHeader as $aField) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$aAlfabeto[$iTitle]}{$linhaCabecalho}", $aField["title"]);
            $iTitle++;
        }

        # obj
        foreach ($objects as $kInd => $obj) {
            $o = (array) !is_array($obj) && $class ? $action->toArray($obj) : $obj;
            foreach ($colunas as $j => $key) {
                if (isset($o[$key])) {
                    $val = $o[$key];

                    $linha = $kInd + $linhaCabecalho + 1;
                    switch ($aTableHeader[$key]["type"]) {
                        case "fk":
                            $value = $val[$aTableHeader[$key]["value"]];
                            break;
                        case "date":
                            $tmp = (Util::object_to_array($val));
                            $value = Util::transformaData($tmp[$aTableHeader[$key]["value"]]);
                            break;
                        case "sim/nao":
                            if (isset($aTableHeader[$key]["value"][$val])) {
                                $value = $aTableHeader[$key]["value"][$val];
                            } else {
                                $value = NAO_DEFINIDO;
                            }
                            break;
                        default:
                            $value = $val;
                            break;
                    }
                    // Add some data                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$aAlfabeto[$colunasNames[$colunas[$j]]]}{$linha}", $value);
                }
            }
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($title);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        # cabecalho e saida
        header('Content-Type: application/vnd.openxmlformats- officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        $objWriter->save('php://output');
    }

    public static function object_to_array($data) {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = Util::object_to_array($value);                
            }
            return $result;
        }
        return $data;
    }

}

?>