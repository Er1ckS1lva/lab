<?php
include_once(dirname(__FILE__).'/../actionparent/BibliotecaImagemActionParent.php');

class BibliotecaImagemAction extends BibliotecaImagemActionParent {

    public function validate(&$request,$edicao = false){
        # validação parent
        if(!$edicao){
            $validation = $this->validateParent($request,$edicao);
            if(!$validation){
               return $validation;
            }
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

    public function editTransaction($oBibliotecaImagem, $request){
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;
        
        if ($arquivoName) {
            $oBibliotecaImagem->setArquivo($arquivo);
            $oBibliotecaImagem->setArquivoName($arquivoName);
            $oBibliotecaImagem->setArquivoType($arquivoType);

            $this->em->persist($oBibliotecaImagem);
            $this->em->flush($oBibliotecaImagem);
        }
    }

    public static function getValuesForFotografia (){
        return array('Retrato', 'Documental', 'Publicitária', 'Moda', 'Viagem', 'Fotojornalismo',
        'Infantil', 'Artística', 'Esportiva', 'Social', 'Científica', 'Culinária', 'Arquitetônica', 'Astronômica');
    }

    public static function getValuesForGravura (){
        return array('Gravura em Metal', 'Litografia', 'Xilogravura', 'Linoleogravura',
        'Serigrafia', 'Monotipia', 'Aquagravura', 'Infografia');
    }

    public static function getValuesForDesenho (){
        return array('Realista', 'Mangá', '3D', 'Digital', 'Livre', 'Caricatura', 'Cartoon', 'Traço',
        'Memorização', 'Obervação');
    }
}
?>