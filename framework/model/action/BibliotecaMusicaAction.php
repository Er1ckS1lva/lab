<?php
include_once(dirname(__FILE__).'/../actionparent/BibliotecaMusicaActionParent.php');

class BibliotecaMusicaAction extends BibliotecaMusicaActionParent {

    public function validate(&$request,$edicao = false){
        # validação parent
        $validation = $this->validateParent($request,$edicao);
        if(!$validation){
           return $validation;
        }
        if($request->get('palavraChaveMusica')){
            if(count($request->get('palavraChaveMusica')) > 5){
                throw new Exception("Você só pode cadastrar até 5 palavras chaves!");
            }
            $request->set('palavraChaveMusica', implode(", ", $request->get('palavraChaveMusica')));
        }
        
        if($request->get("arquivo")){
            $arquivo = $request->get("arquivo");
            if($arquivo['error'] == 0){
                $request->set('arquivo', base64_encode(file_get_contents($arquivo['tmp_name'])));
                $request->set('arquivoName', $arquivo['name']);
                $request->set('arquivoType', $arquivo['type']);
                $request->set('arquivoSize', $arquivo['size']);
            }
        }
        
        return true;
    }

    public function editTransaction($oBibliotecaMusica, $request){
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;
        
        if ($arquivoName) {
            $oBibliotecaMusica->setArquivo($arquivo);
            $oBibliotecaMusica->setArquivoName($arquivoName);
            $oBibliotecaMusica->setArquivoType($arquivoType);

            $this->em->persist($oBibliotecaMusica);
            $this->em->flush($oBibliotecaMusica);
        }
    }

}
?>