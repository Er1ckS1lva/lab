<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="<?php echo URL_WEBROOT ?>css/relPdf/bootstrap_relPdf.css" />
    </head>
    <body style="background-color: transparent;">
            <?php if ($response->get("cabecalho")) { ?>
                <?php echo $response->get("cabecalho"); ?>
            <?php } else { ?>
                <div style="float: left; margin-top: 20px;">
                    <?php echo $response->get("relatorio_titulo") ?><br/>
                    <?php echo $response->get("relatorio_subtitulo") ?>
                </div>
            <?php } ?>
        <div style="clear: both"></div>
    </body>
</html>