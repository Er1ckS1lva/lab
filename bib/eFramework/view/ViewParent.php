<?php

class ViewParent {

    private $name;
    private $dir;
    private $response;
    private $method;
    private $module;
    private $classe;
    private $metodo;

    public function __construct($name, $response, $method = 'include') {
        $this->dir = dirname(__FILE__) . '/../../../framework/view';
        $this->name = $name;
        $this->response = $response;
        $this->method = $method;
        $this->module = isset($_REQUEST['module']) ? $_REQUEST['module'] : "";
        $action = $_REQUEST['action'];
        list($classe, $metodo) = explode(".", $action);
        $this->classe = $classe;
        $this->metodo = $metodo;
    }

    public function renderView() {
        if ($this->method == 'include') {
            header("Content-Type: text/html; charset=utf-8", true);
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            $this->includeView();
        } elseif ($this->method == 'module') {
            $this->includeModuleView();
        } elseif ($this->method == 'redirect') {
            $this->redirectView();
        } elseif ($this->method == 'redirectFriendly') {
            $this->redirectFriendlyView();
        } elseif ($this->method == 'specificHeader') {
            echo $this->name;
        } elseif ($this->method == 'print') {
            header("Content-Type: text/html; charset=utf-8", true);
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            echo $this->name;
        } elseif ($this->method == 'relPdf') {
            ob_start();
            $this->includeView();
            $html = ob_get_clean();
            $r = new Response();
            $r->set('html', $html);
            $r->set('cabecalho', $this->response->get("cabecalho"));
            $r->set('rodape', $this->response->get("rodape"));
            $view = new View("app/template-relPdf.php", $r, 'include');
            ob_start();
            $view->renderView();
            $defaultOptions = array(
                'showHtml' => 0,
                'attachment' => 0,
                'filename' => ($this->response->get("filenameRel") ? $this->response->get("filenameRel") : 'relatorio.pdf'), # para o nome do arquvio
            );
            $options = array_intersect_key(
                            $this->response->getParameters(), $defaultOptions
                    ) + $defaultOptions;
            $orientacao = $this->response->get("orientacao") ? $this->response->get("orientacao") : null;
            $this->printPDF(ob_get_clean(), $options, $orientacao);
        } else {
            die('Erro ao renderizar visão...');
        }
    }

    public function includeModuleView() {
        # Inicialização de variáveis da página (visão) vem aqui.
        $tabindex = 0;

        $response = (!is_object($this->response)) ? new Response() : $this->response;
        if (file_exists("{$this->dir}/{$this->module}")) {
            include_once("{$this->dir}/{$this->module}/index.php");
        } else {
            include_once("404.php");
        }
    }

    public function includeView() {
        # Inicialização de variáveis da página (visão) vem aqui.
        $tabindex = 0;

        $response = (!is_object($this->response)) ? new Response() : $this->response;
        if (file_exists($this->dir . "/" . $this->name)) {
            include_once($this->dir . "/" . $this->name);
        } else {
            include_once("404.php");
        }
    }

    public function redirectView() {
        if (!is_object($this->response))
            $this->response = new Response();
        $vURL = array();
        foreach ($this->response->getParameters() as $var => $valor)
            $vURL[] = "$var=" . urlencode($valor);
        $url = (count($vURL) > 0) ? "&" . join("&", $vURL) : '';
        header("Location: ?action={$this->name}$url");
        exit;
    }

    public function redirectFriendlyView() {
        if (!is_object($this->response))
            $this->response = new Response();
        $vURL = array();
        foreach ($this->response->getParameters() as $var => $valor)
            $vURL[] = "$var=" . urlencode($valor);
        $url = (count($vURL) > 0) ? ("?" . join("&", $vURL)) : '';
        header("Location: {$this->name}$url");
        exit;
    }

    public function printView() {
        echo $this->name;
    }

    public function printPDF($output, $opts, $orientacao = 'portrait') {
        if ($opts['showHtml']) {
            echo $output;
        } else {
            define('DOMPDF_ENABLE_REMOTE', true);
            require_once( IGENIAL_ROOT_DIR . "/ext/dompdf/dompdf_config.inc.php");
            $dompdf = new DOMPDF();
            $dompdf->load_html($output);
            $dompdf->set_paper('A4', $orientacao);
            $dompdf->render();
            $dompdf->stream($opts['filename'], array('Attachment' => $opts['attachment']));
        }
    }

}
