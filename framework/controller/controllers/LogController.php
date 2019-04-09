<?php
include_once(dirname(__FILE__).'/../../model/action/LogAction.php');
require_once(dirname(__FILE__).'/../parent/LogControllerParent.php');

class LogController extends LogControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }
    
    public function form() {
        return $this->admFilter();
    }
    public function formSubmit() {
        return $this->admFilter();
    }
    public function edit() {
        return $this->admFilter();
    }
    public function editSubmit() {
        return $this->admFilter();
    }
    public function delSelected() {
        return $this->del();
    }
    public function del() {
        return new View("Impossível realizar esta operação!", null, 'print');
    }

}
?>