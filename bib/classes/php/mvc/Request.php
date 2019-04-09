<?php

class Request {

    private $parameters;

    public function __construct($retrieveEverything = true) {
        $parameters = array();
        if ($retrieveEverything === true) {
            foreach ($_REQUEST as $key => $value) {
                if (!is_array($value)) {
                    $parameters[$key] = (get_magic_quotes_gpc()) ? ($value) : ($value);
                } else {
                    $vetor = array();
                    foreach ($value as $i => $v) {
                        $vetor[$i] = (get_magic_quotes_gpc()) ? stripslashes($v) : ($v);
                    }
                    $parameters[$key] = $vetor;
                }
            }
            foreach ($_FILES as $key => $value) {
                if (!is_array($value)) {
                    $parameters[$key] = (get_magic_quotes_gpc()) ? $value : ($value);
                } else {
                    $vetor = array();
                    foreach ($value as $i => $v) {
                        $vetor[$i] = (get_magic_quotes_gpc()) ? $v : ($v);
                    }
                    $parameters[$key] = $vetor;
                }
            }
        }
        $this->parameters = $parameters;
    }

    public function get($parameter) {
        if (isset($this->parameters[$parameter])) {
            return $this->parameters[$parameter];
        } else
            return false;
    }

    public function set($parameter, $value) {
        $this->parameters[$parameter] = $value;
    }

    public function destroy($parameter) {
        unset($this->parameters[$parameter]);
    }

    public function getParameters() {
        return $this->parameters;
    }

    public function setParameters($params) {
        $this->parameters = $params;
    }

}

?>
