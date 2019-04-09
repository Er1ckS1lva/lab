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
        <?php include dirname(__FILE__) . "/inc/config_js.php"; ?>

        <title>Atividade - Laboratório Virtual</title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include dirname(__FILE__) . "/inc/config_css.php"; ?>
    </head>

    <body>
        <div class="geral">

            <?php include dirname(__FILE__) . "/inc/header.php"; ?>

            <div class="conteudo">
                <div class="container-fluid">
                    <?php
                    $oPagina = $response->get('oPagina');
                    if ($oPagina) {
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <h1 class="titulo-atividade"><?php echo $oPagina->getTitulo(); ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col pagina-interna">
                                    <section>
                                        <?php
                                        echo $oPagina->getConteudo();
                                        ?>
                                    </section>
                                </div>
                            </div>
                        </div>
                    <?php } else {
                        ?>
                        <br><h3><?php echo "Página não econtrada!" ?></h3><br>
                    <?php } ?>
                </div>
            </div>

        </div>
        <?php include dirname(__FILE__) . "/inc/footer.php"; ?>
    </body>
</html>
