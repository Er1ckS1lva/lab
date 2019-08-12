<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <!--CONFIGURAÇÃO HEAD-->
        <?php include dirname(__FILE__) . "/inc/head.php"; ?>
        <title><?php echo Lang::GERAL_conta ?> - <?php echo Lang::GERAL_tituloUfu ?></title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include dirname(__FILE__) . "/inc/config_css.php"; ?>


    </head>

    <body>
        <div class="geral">

            <div class="cabecalho">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <header class="d-flex flex-column flex-md-row justify-content-between align-items-center my-3">
                                <div class="logo d-flex flex-column flex-md-row align-items-center">
                                    <a href="<?php echo URL ?>"><img src="<?= URL_PORTAL ?>img/logo-small.png" alt="logo" class="" /></a>
                                </div>
                                <?php if (isset($_SESSION['serAlunoSessao'])) {
                                    ?><div class="usuario-logado">Bem vindo(a): <?php echo $_SESSION['alunoNome'] ?> | <a href="<?= URL ?>logout"><?php echo Lang::GERAL_logout ?></a></div>
                                <?php } ?>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <div class="conteudo">
                <div class="container-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col pagina-interna">

                                <?php
                                if ($response->get('error_message') != "") {
                                    echo $response->get('error_message');
                                } else {
                                    ?>

                                    <?php echo Lang::confirmaConta ?>
                                    <div>
                                        <a href="<?php echo URL . "login/" ?>" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><?php echo Lang::CONTA_login ?></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php include dirname(__FILE__) . "/inc/footer.php"; ?>


        <!--CONDIGURAÇÃO SCRIPS-->
        <?php include dirname(__FILE__) . "/inc/config_js.php"; ?>
    </body>
</html>
