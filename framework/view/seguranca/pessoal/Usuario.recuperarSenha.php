<!DOCTYPE html>
<html lang="en-us">
    <head>
        <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/header.php'; ?>
    </head>
    <body id="login" class="animated fadeInDown">
        <!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
        <header id="header">
                <!--<span id="logo"></span>-->
            <div id="logo-group">
                <span id="logo"> <img src="<?php echo URL_WEBROOT; ?>img/logo.png" alt="SmartAdmin"> </span>
                <!-- END AJAX-DROPDOWN -->
            </div>
            <!--<span id="login-header-space"> <span class="hidden-mobile">Não possui conta?</span> <a href="register.html" class="btn btn-danger">Criar conta</a> </span>-->
        </header>
        <div id="main" role="main">
            <!-- MAIN CONTENT -->
            <div id="content" class="container">
                <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/modals.php'; ?>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="well no-padding">

                            <?
                            $o = $response->get("oUsuario");
                            ?>
                            <form action="<?= URL ?>index.php?action=Usuario.recuperarSenhaSubmit" id="login-form" class="smart-form client-form" onsubmit="return false;">
                                <header>
                                    Recuperar senha
                                </header>
                                <fieldset>
                                    <input type="hidden" name="hash" value="<?= $o->getRecuperaSenhaHash() ?>"/>

                                    <section>
                                        <label class="input">
                                            <i class="icon-append fa fa-user"></i>
                                            <input class="form-control" type="text" value="<?= $o->getEmail() ?>" name="email" readonly="" style="background-color: #F4F4F4;"/>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="input">
                                            <i class="icon-append fa fa-lock"></i>
                                            <input class="form-control" type="password" name="novaSenha" placeholder="Nova senha" />
                                        </label>
                                    </section>
                                    <section>
                                        <label class="input">
                                            <i class="icon-append fa fa-lock"></i>
                                            <input class="form-control" type="password" name="novaSenhaConf" placeholder="Nova senha conf." />
                                        </label>
                                    </section>
                                </fieldset>

                                <footer>
                                    <input type="submit" class="btn btn-default" value="Alterar" onclick="eqRecuperarSenhaSubmitHandler(this)" />
                                </footer>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include IGENIAL_ROOT_DIR . '/bib/eFramework/view/inc/footer.js.php'; ?>

        <script type="text/javascript" src="<?= URL ?>framework/view/seguranca/visita/ProdutorVisitante.visita.js"></script>

    </body>
</html>