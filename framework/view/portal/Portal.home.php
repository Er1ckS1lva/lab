<!DOCTYPE html>
<html>
    <head>
        <!--CONFIGURAÇÃO HEAD-->
        <?php include dirname(__FILE__) . "/inc/head.php"; ?>
        <title><?php echo Lang::GERAL_tituloUfu ?></title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include dirname(__FILE__) . "/inc/config_css.php"; ?>
    </head>

    <body>
        <div class="geral">

            <!--modal apresentação-->

            <?php
            $oLaboratorio = $response->get('oLaboratorio');
            $oAluno = $response->get('oAluno');
            ?>
            <?php
            #se o aluno ja aceitou o termo não é necessário a modal para aceite.
            if ($oAluno->getAceiteTermo() != 'S') {
                include dirname(__FILE__) . "/inc/modal-aceite.php";
            } else {
                # exibe modal de apresentção apenas se o aluno ja aceitou o termo.
                if (isset($_SESSION['alunoWelcome'])) {
                    //include dirname(__FILE__) . "/inc/modal-apresentacao.php";
                    # exibiu uma vez para a exibição
                    unset($_SESSION['alunoWelcome']);
                }
            }
            ?>

            <?php include dirname(__FILE__) . "/inc/header.php"; ?>

            <div class="conteudo my-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 mb-3">
                            <div class="owl-carousel owl-theme">
                                <?php
                                $aTema = $response->get('aTema');
                                foreach ($aTema as $key => $oTema) {
                                    ?>
                                    <a href="<?php echo URL . "atividade/" . $oTema->getId() ?>" onmouseover="reproduzir(this)">
                                        <div class="item d-flex flex-column <?php echo 'color-' . rand(1, 20) ?>">
                                            <img src="<?= MediaUtil::getLinkForFileNameById("Tema/imagemCapa", $oTema->getId()) ?>" class="" alt="<?php echo $oTema->getTitulo(); ?>" />
                                            <h3 class="text-center"><?php echo $oTema->getTitulo(); ?></h3>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 mb-3 btns-right text-center">
                            <?php include dirname(__FILE__) . "/inc/buttons.php"; ?>
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
