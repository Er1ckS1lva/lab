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
            //$cmd = "java -cp \"weka.jar:gson-2.6.2.jar:/home/html/EmotionAnalyzer/EmotionAnalyzer.jar\" lab.EmotionAnalyzer {$arquivo['tmp_name']}";

            //teste estático
            $cmd = "java -cp \"weka.jar:gson-2.6.2.jar:/home/html/EmotionAnalyzer/EmotionAnalyzer.jar\" lab.EmotionAnalyzer 03-01-08-01-02-02-12.wav";

            $output = Util::doLogFile($cmd);

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

    public function form() {
        $oIdiomaAction = new IdiomaAction();
        $aIdioma = $oIdiomaAction->collection(null, null, 'padrao ASC');
        $kIdioma = array();
        if ($aIdioma) {
            foreach ($aIdioma as $oIdioma) {
                $kIdioma[$oIdioma->getId()] = $oIdioma->getSigla();
            }
        }
        $this->response->set("aIdioma", $aIdioma);
        $this->response->set("kIdioma", $kIdioma);

        return parent::form();
    }

    public function edit() {
        $oIdiomaAction = new IdiomaAction();
        $aIdioma = $oIdiomaAction->collection(null, null, 'padrao ASC');
        $kIdioma = array();
        if ($aIdioma) {
            foreach ($aIdioma as $oIdioma) {
                $kIdioma[$oIdioma->getId()] = $oIdioma->getSigla();
            }
        }
        $this->response->set("aIdioma", $aIdioma);
        $this->response->set("kIdioma", $kIdioma);

        $ret = parent::edit();

        $id = (int) $this->request->get("id");
        $object = $this->response->get("object");
        if ($object && $object->getTipo() == "REL") {
            $oAtividadeAction = new AtividadeAction();
            $aColuna = $oAtividadeAction->getColunas($id);
            $this->response->set("aColuna", $aColuna["coluna"]);
            $this->response->set("aColunaCount", $aColuna["count"]);
        }

        $oConteudoAction = new ConteudoAction();
        $aConteudo = $oConteudoAction->collection(null, "o.Atividade='{$id}'");
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

        return $ret;
    }

    public function conteudoDownload() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $classe = "ConteudoArquivo";
        if ($this->request->get("classe")) {
            $classe = $this->request->get("classe");
        }
        eval("\$oAction = new {$classe}Action();");


        $id = (int) $this->request->get("id");
        $o = $oAction->select($id);
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
