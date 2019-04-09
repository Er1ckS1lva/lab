<?php

class Language {
    public static $PORTUGUESE = "pt_br";
    public static $ENGLISH = "en";

    private static $container;

    public static function setLanguage($language) {
        if(!isset($_SESSION['LANGUAGE'])) {
            $_SESSION['LANGUAGE'] = self::getLanguageByBrowser();
        }
        if($language) {
            $_SESSION['LANGUAGE'] = $language;
        }

        if($_SESSION['LANGUAGE'] != Language::$PORTUGUESE)
            self::loadProperties($_SESSION['LANGUAGE']);
    }

    public static function changeLanguage($language) {
        $_SESSION['LANGUAGE'] = $language;
        header('Location: .');
    }

    private static function loadProperties($language) {
        self::readFile($language);
    }

    private static function readFile($fileName) {
        $file =  dirname(__FILE__).'/languages/'.$fileName . '.properties';
        if(!file_exists($file)) {
            throw new Exception("File not found Exception");
        }

        self::$container = array();

        $handle = @fopen($file, "r");
        if ($handle) {
            while (!feof($handle)) {
                $propValArr = explode('=', fgets($handle));
                if($propValArr === false) continue;
                $leftVal =  trim(self::filterAccents($propValArr[0]));
                $rightVal = trim(self::filterAccents($propValArr[1]));
                self::$container[$leftVal] = $rightVal;
            }
            fclose($handle);
        }

    }

    private static function filterAccents($text) {
        $text = str_replace("\\u00E1", 'á', $text);
        $text = str_replace("\\u00E9", 'é', $text);
        $text = str_replace("\\u00ED", 'í', $text);
        $text = str_replace("\\u00F3", 'ó', $text);
        $text = str_replace("\\u00FA", 'ú', $text);
        $text = str_replace("\\u00E3", 'ã', $text);
        $text = str_replace("\\u00F5", 'õ', $text);
        $text = str_replace("\\u00EA", 'ê', $text);
        $text = str_replace("\\u00E7", 'ç', $text);
        $text = str_replace("\\u00E2", 'â', $text);

        $text = str_replace("\\u00C1", 'Á', $text);
        $text = str_replace("\\u00C9", 'É', $text);
        $text = str_replace("\\u00CD", 'Í', $text);
        $text = str_replace("\\u00D3", 'Ó', $text);
        $text = str_replace("\\u00DA", 'Ú', $text);
        $text = str_replace("\\u00C3", 'Ã', $text);
        $text = str_replace("\\u00D5", 'Õ', $text);
        $text = str_replace("\\u00CA", 'Ê', $text);
        $text = str_replace("\\u00C2", 'Â', $text);
        $text = str_replace("\\u00C7", 'Ç', $text);
        return $text;
    }

    public static function getText($value) {
        if(!is_string($value)) {
            throw new Exception("It is not a string value. Parameter parsed: $value.");
        }
        if(strpos($value, '#') !== false) {
            $arr = explode('#', $value);
            for($i = 0; $i < count($arr); $i++) {
                if(!is_numeric($arr[$i])) {
                    $aux = $_SESSION['LANGUAGE'] == Language::$PORTUGUESE ? $arr[$i] : self::$container[$arr[$i]];
                }
                if($i == count($arr) - 1) {
                    $val .= $aux;
                } else {
                    $val .= $aux . ' ';
                }
            }
        }
        else {
            if(!self::$container[$value] && $_SESSION['LANGUAGE'] != Language::$PORTUGUESE) {
                $val = '[[' . $value . ']]';
            } else {
                $val = self::$container[$value];
            }
        }
        
        return $val ? $val : $value;
    }

    private static function getLanguageByBrowser() {
        $browserAcceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $commaIndex = strpos($browserAcceptLanguage, ',');
        $language = substr($browserAcceptLanguage, 0, $commaIndex);
        return str_replace('-', '_', $language);
    }
}

?>
