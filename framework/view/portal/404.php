<html>
    <head>
        <!--CONFIGURAÇÃO HEAD-->
        <?php include dirname(__FILE__) . "/inc/head.php"; ?>
        <?php include dirname(__FILE__) . "/inc/config_js.php"; ?>

        <title>404 - <?php echo Lang::GERAL_tituloUfu ?></title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include dirname(__FILE__) . "/inc/config_css.php"; ?>
    </head>


    <body>        
        <div class="geral">
            <?php include dirname(__FILE__) . "/inc/header.php"; ?>
            
            <h1><?php echo Lang::GERAL_pagina404 ?>!</h1>
        </div>

        <hr />

        <?php include dirname(__FILE__) . "/inc/footer.php"; ?>
        
    </body>
</html>
