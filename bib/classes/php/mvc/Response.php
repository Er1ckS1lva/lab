<?php

class Response {

    private $parameters;

    public function __construct() {
        $this->parameters = array();
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

    public function add_parameters($params) {
        foreach ($params as $i => $v)
            $this->parameters[$i] = $v;
    }

}

?>