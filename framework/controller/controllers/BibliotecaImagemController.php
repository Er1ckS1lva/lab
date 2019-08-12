<?php
include_once(dirname(__FILE__).'/../../model/action/BibliotecaImagemAction.php');
require_once(dirname(__FILE__).'/../parent/BibliotecaImagemControllerParent.php');

class BibliotecaImagemController extends BibliotecaImagemControllerParent {

    public function __construct($request,$response) {
        $this->request = $request;
        $this->response = $response;
    }
    
    public function edit() {
        if ($this->request->get("isDownload")) {
            return $this->download();
        }
        return parent::edit();
    }

    protected function download() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);
        
        $oBibliotecaImagemAction = new BibliotecaImagemAction();
        $id = (int) $this->request->get("id");
        $o = $oBibliotecaImagemAction->select($id);
        if ($o === null) {
            return new View('O arquivo não foi encontrado ou é inválido.', $this->response, "print");
        }
        header('Pragma: public');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Content-type: "' . $o->getArquivoType(). '"');
        header('Content-Disposition: attachment; filename="' . $o->getArquivoName(). '"');
        $arquivo = base64_decode($o->getArquivo());
        
        return new View($arquivo, $this->response, "specificHeader");
    }


}
?>