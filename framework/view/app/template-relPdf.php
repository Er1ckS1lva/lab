<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Versão para impressão</title>
        <link rel="stylesheet" href="<?php echo URL_WEBROOT ?>css/relPdf/bootstrap_relPdf.css" />
        <style type="text/css">
            @page {margin: 0;}
            #header, #footer {
                position: fixed;
                left: 0;right: 0;
            }
            #header {
                top: 0; 
                <?php if ($response->get("orientacao") == "landscape") { ?>
                    text-align: center;
                <?php } ?>
            }
            #footer {bottom: 2.5cm; text-align: center;}
            <?php if ($response->get("orientacao") == "landscape") { ?>
                body {margin: 180px 2cm 0px;}
            <?php } else { ?>
                body {margin: 140px 2cm 100px;}
            <?php } ?>
            .page-number:before {content: counter(page);}
        </style>
    </head>
    <body>

        <div id="header">
            <? if ($response->get("cabecalho")) { ?>
                <?php echo $response->get("cabecalho"); ?>
            <? } else { ?>
                <img src="<?php echo URL_WEBROOT ?>css/relPdf/topo.jpg"/>
            <? } ?>
        </div>

        <div id="footer" >
            <?php if ($response->get("rodape")) { ?>
                <?php echo $response->get('rodape'); ?>
            <? } else { ?>
                <div style="position: absolute; margin-left: 10%"><?= date("d/m/Y H:i:s") ?></div>
                <div style="margin-left: 75%">Pág. <span class="page-number n-paginas"></span></div>
                <!--<img src="<?php echo URL_WEBROOT ?>css/relPdf/rodape.jpg"/>-->
            <? } ?>
        </div>

        <div>
            <?php echo $response->get('html') ?>
        </div>

    </body>
</html>