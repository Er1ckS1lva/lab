<?php

include_once(dirname(__FILE__) . '/../../model/action/AtividadeAction.php');
require_once(dirname(__FILE__) . '/../parent/AtividadeControllerParent.php');

class AtividadeController extends AtividadeControllerParent {

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function processaGravacao() {
        if ($this->request->get('tipo') == "EMO" || $this->request->get('tipo') == "EMI") {
            $arquivo = $this->request->get("data");
            #aqui a gravação será processada pela IA
            $output = shell_exec("java -cp \"weka.jar:gson-2.6.2.jar:/srv/www/htdocs/VoiceEmotionAnalyzer/VoiceEmotionAnalyzer.jar\" lab.VoiceEmotionAnalyzer {$arquivo['tmp_name']}");
            $aRetorno = json_decode($output, true);
//            $aRetorno = json_decode('{"emotionDetection":"angry","emotionsProbabilities":[{"Name":"angry","Valor":0.0},{"Name":"happiness","Valor":0.5},{"Name":"sadness","Valor":0.3333333333333333},{"Name":"surprised","Valor":0.16666666666666666}]}', true);

            $score = 0;

            $oAtividadeAction = new AtividadeAction();
            $msg = $oAtividadeAction->saveGravacao($this->request, $score);
        } else {
            #aqui a gravação será processada pela IA
            #shell_exec($arquivo);
            # aqui estarão os resultados de acordo com a IA
            $transcri = 'aqui estará a transcrição do audio para texto';
            $score = 90;
            $status = 'ok';

            #aqui salvamos o arquivo no banco


            $aRetorno = array(
                'transcricao' => $transcri,
                'score' => $score,
                'status' => $status,
                'mensagem' => 'msg'
            );
        }


        // salva o áudio no banco
        $oAtividadeAction = new AtividadeAction();
        $msg = $oAtividadeAction->saveGravacao($this->request, $score);
        header('Content-type: application/json');
        return new View(json_encode($aRetorno), null, 'specificHeader');
    }

    public function alteraTipo() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $id = (int) $this->request->get("pk");
        $tipo = $this->request->get("value");

        $oAtividadeAction = new AtividadeAction();
        if (!$oAtividadeAction->alteraTipo($id, $tipo)) {
            return new View($oAtividadeAction->getMsg(), $this->response, 'print');
        }
        return new View('OK', $this->response, 'print');
    }

    public function edit() {
        $id = (int) $this->request->get("id");
        $oConteudoAction = new ConteudoAction();
        $aConteudo = $oConteudoAction->collection(null, "o.Atividade={$id}");
        $this->response->set("aConteudo", $aConteudo);

        $aConteudoArquivo = array();
        $oConteudoArquivoAction = new ConteudoArquivoAction();
        $oConteudoFormularioAction = new ConteudoFormularioAction();
        $aConteudoFormulario = array();
        if ($aConteudo) {
            foreach ($aConteudo as $key => $oConteudo) {
                $aConteudoArquivo[$oConteudo->getId()] = $oConteudoArquivoAction->select($oConteudo->getId());
                $aConteudoFormulario[$oConteudo->getId()] = $oConteudoFormularioAction->selectByConteudo($oConteudo->getId());
            }
        }

        $oAtividadeOpcaoAction = new AtividadeOpcaoAction();
        $aOpcao = $oAtividadeOpcaoAction->collection(null, "o.Atividade={$id}", 'id ASC');

        $this->response->set("aOpcao", $aOpcao);
        $this->response->set("aConteudoArquivo", $aConteudoArquivo);
        $this->response->set("aConteudoFormulario", $aConteudoFormulario);
        return parent::edit();
    }

    public function conteudoDownload() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);
        $oConteudoArquivoAction = new ConteudoArquivoAction();
        $id = (int) $this->request->get("id");
        $o = $oConteudoArquivoAction->select($id);
        if ($o === null) {
            return new View('O arquivo não foi encontrado ou é inválido.', $this->response, "print");
        }
        header('Pragma: public');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header("Content-type: " . $o->getTipo());
        header('Content-Disposition: attachment; filename=' . $o->getNome());
        $arquivo = $o->getArquivo();
        return new View($arquivo, $this->response, "specificHeader");
    }

    public function gravacaoDownload() {
        $oAlunoAtividadeAction = new AlunoAtividadeAction();
//        $id_aluno = (int) $this->request->get("id_aluno");
        $id_atividade = (int) $this->request->get("id");
        $oAlunoAtividade = $oAlunoAtividadeAction->select(1, $id_atividade);
        if ($oAlunoAtividade === null) {
            return new View('O arquivo não foi encontrado ou é inválido.', $this->response, "print");
        }
        header('Pragma: public');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header("Content-type: " . $oAlunoAtividade->getTipo());
        header('Content-Disposition: attachment; filename=' . $oAlunoAtividade->getNome());
        $arquivo = $oAlunoAtividade->getArquivo();
        return new View($arquivo, $this->response, "specificHeader");
    }

}

?>