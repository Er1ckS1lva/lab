<?php
class PdfUtilParent {

    // essa função tem que retornar uma view, ainda não sei como....
    public static function geraPdfDocumento($html, $nomeArquivo) {
        
        require_once(URANO_ROOT_DIR . "/bib/classes/dompdf/dompdf_config.inc.php");
        #prepara os valores do documento
        $cabecalho = $oDocumento->getCabecalho() ? "<div id='header'>{$oDocumento->getCabecalho()}</div>" : null;
        $rodape = $oDocumento->getRodape() ? "<div id='footer'>{$oDocumento->getRodape()}</div>" : null;
        $corpo = $oDocumento->getDescricao() ? $oDocumento->getDescricao() : null;


        $html = file_get_contents(URANO_ROOT_DIR . "/framework/view/cadastros/documento/Documento.modelo.php");
        $html = str_replace("%%CABECALHO%%", $cabecalho, $html);
        $html = str_replace("%%RODAPE%%", $rodape, $html);
        $html = str_replace("%%CORPO%%", $corpo, $html);

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $base_path = URANO_ROOT_DIR . "/bib/classes/dompdf/";
        if (isset($base_path)) {
            $dompdf->set_base_path($base_path);
        }
        $dompdf->set_paper("A4", "portrait");
        $dompdf->render();
        $_dompdf_show_warnings = false; #use em caso de debug
        if ($_dompdf_show_warnings) {
            global $_dompdf_warnings;
            foreach ($_dompdf_warnings as $msg)
                echo $msg . "\n";
            echo $dompdf->get_canvas()->get_cpdf()->messages;
            flush();
        }
        if (!headers_sent()) {
            $dompdf->stream($outfile, $options);
        }
    }

}

?>