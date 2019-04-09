<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Versão para impressão</title>
        <link rel="stylesheet" href="<?php echo URL_WEBROOT ?>css/relPdf/bootstrap_relPdf.css" />
        <style>
            tr {
                page-break-inside: avoid;
            }
        </style>
    </head>
    <body>
        <?php echo $response->get('html') ?>
    </body>
</html>