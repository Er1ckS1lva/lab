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
<!--            <span id="login-header-space"> <span class="hidden-mobile">Need an account?</span> <a href="register.html" class="btn btn-danger">Creat account</a> </span>-->
        </header>
        <div id="main" role="main">
            <!-- MAIN CONTENT -->
            <div id="content" class="container">
                <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/modals.php'; ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">

                        <div class="hero">

                            <div class="pull-left login-desc-box-l">
                                <img src="<?php echo URL_WEBROOT; ?>img/logo-full.png" alt="SmartAdmin">
                                <? if ($response->get("error_message")) { ?>
                                    <h4 class="paragraph-header">Atenção:</h4>
                                    <p class="text-danger"><?= $response->get("error_message") ?></p>
                                <? } ?>
                                <!--                                    <div class="login-app-icons">
                                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
                                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
                                                                    </div>-->
                            </div>
                            <!--<img src="<?php echo URL_WEBROOT; ?>img/demo/iphoneview.png" class="pull-right display-image" alt="" style="width:210px">-->
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h5 class="about-heading">Informações ao Usuário</h5>
                                <p>
                                    - Proteja a sua senha.
                                </p>
                                <p>
                                    - Mantenha atualizado o antí-vírus de sua máquina
                                </p>
                            </div>
                            <!--
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h5 class="about-heading">Bla bla 2</h5>
                                <p>
                                    Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
                                </p>
                            </div>
                            -->
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                        <div class="well no-padding">
                            <form action="<?php echo URL ?>index.php?action=Usuario.loginSubmit" id="login-form" class="smart-form client-form" onsubmit="return false;">
                                <header>
                                    Área restrita
                                </header>

                                <fieldset>

                                    <section>
                                        <label class="label">Usuário</label>
                                        <label class="input"> <i class="icon-append fa fa-user"></i>
                                            <input type="text" name="login" value="<?= isset($_COOKIE["login_digitado" . SESSION_NAME]) ? $_COOKIE["login_digitado" . SESSION_NAME] : "" ?>">
                                            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor digite seu nome de usuário</b></label>
                                    </section>

                                    <section>
                                        <label class="label">Senha</label>
                                        <label class="input"> <i class="icon-append fa fa-lock"></i>
                                            <input type="password" name="senha" value="<?= isset($_COOKIE["senha_digitado" . SESSION_NAME]) ? $_COOKIE["senha_digitado" . SESSION_NAME] : "" ?>">
                                            <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Digite sua senha</b> </label>

                                        <div class="note">
                                            <a href="javascript:void(0)" onclick="$('#recoverModal').modal('show');">Esqueceu sua senha?</a>
                                        </div>

                                    </section>

                                    <section>
                                        <label class="checkbox">
                                            <input type="checkbox" name="remember" checked="">
                                            <i></i>Continuar conectado</label>
                                    </section>

                                </fieldset>
                                <footer>
                                    <button type="submit" class="btn btn-primary" onclick="eqLoginSubmitHandler(this)">
                                        Acessar
                                    </button>
                                </footer>
                            </form>

                        </div>

                        <!--                        <h5 class="text-center"> - Or sign in using -</h5>
                        
                                                <ul class="list-inline text-center">
                                                    <li>
                                                        <a href="javascript:void(0);" class="btn btn-primary btn-circle"><i class="fa fa-facebook"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="btn btn-info btn-circle"><i class="fa fa-twitter"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="btn btn-warning btn-circle"><i class="fa fa-linkedin"></i></a>
                                                    </li>
                                                </ul>-->

                    </div>
                </div>
            </div>
        </div>
        <?php include IGENIAL_ROOT_DIR . '/bib/eFramework/view/inc/footer.js.php'; ?>


        <div class="modal fade" id="recoverModal" tabindex="-1" role="dialog" aria-labelledby="recoverModal" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#recoverModal').modal('hide')">&times;</button>
                        <h4 class="modal-title" class="modal-title">Recuperar Senha</h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= URL ?>index.php?action=Usuario.solicitaRecuperaSenhaSubmit" onsubmit="return false;">
                            <p>Digite seu e-mail, você receberá instruções sobre como recuperar sua senha.</p>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span><input class="form-control" type="text" id="email" name="email" placeholder="Endereço de E-mail" />
                            </div>
                            <div class="input-group" id="recaptcha" style="margin: 0 auto 0;">
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                                <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_PUBLIC_KEY ?>"></div>
                            </div>
                            <br/>
                            <p>
                                Para evitar a proliferação de SPAM, assim como uma medida de segurança, utilizamos este recurso para garantir que você realmente está solicitando isto.
                            </p>
                            <input style="display: none;" id="button_recuperar" type="submit" onclick="eqSolicitaRecuperaSenhaSubmitHandler(this)" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-inverse" value="Confirmar Recuperar" onclick="$('#button_recuperar').click()" />
                        <a href="#" class="btn btn-primary" data-dismiss="modal" onclick="$('#recoverModal').modal('hide')">Cancelar</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </body>
</html>










<? /** / ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
  <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/header.php'; ?>
  <link rel="stylesheet" href="<?php echo URL_WEBROOT ?>css/unicorn/unicorn-login.css" />
  </head>
  <body>
  <div id="container">
  <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/modals.php'; ?>
  <?php if ($response->get("error_message")) { ?>
  <div class="row">
  <div class="col-12">
  <div class="alert alert-danger">
  <i class="fa fa-warning-sign"></i> <?php echo $response->get("error_message") ?>
  </div>
  </div>
  </div>
  <?php } ?>
  <div id="logo">
  <img src="<?php echo URL_WEBROOT ?>css/img/logo.png" alt="" />
  </div>
  <div id="user">
  <div class="avatar">
  <div class="inner"></div>
  <img src="" id="user-img-login" />
  </div>
  <div class="text">
  <h4>Bem vindo(a), <span class="user_name"></span></h4>
  </div>
  </div>
  <div id="loginbox">
  <form id="loginform" class="form-vertical" action="<?php echo URL ?>index.php?action=Usuario.loginSubmit" onsubmit="return false;">
  <p>Digite seu usuário e senha.</p>
  <div class="input-group">
  <span class="input-group-addon"><i class="fa fa-user"></i></span>
  <input class="form-control" type="text" id="username" name="login" placeholder="Usuário (login)"  />
  </div>
  <div class="input-group">
  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
  <input class="form-control" type="password" id="password" name="senha" placeholder="Senha" />
  </div>
  <div class="form-actions clearfix">
  <div class="pull-right">
  <a href="#recoverform" class="flip-link to-recover grey">Esqueceu sua senha?</a><br />
  </div>
  <input type="submit" class="btn btn-block btn-primary btn-default" value="Acessar" onclick="eqLoginSubmitHandler(this)"/>
  </div>
  <div class="footer-login">
  <div class="pull-left text">
  Acessar como
  </div>
  <div class="pull-right btn-social">
  <a class="btn btn-facebook" href="#"><i class="fa fa-facebook"></i></a>
  <a class="btn btn-twitter" href="#"><i class="fa fa-twitter"></i></a>
  <a class="btn btn-google-plus" href="#"><i class="fa fa-google-plus"></i></a>
  </div>
  </div>
  </form>

  <form id="recoverform" action="<?php echo URL ?>index.php?action=Usuario.solicitaRecuperaSenhaSubmit" onsubmit="return false;">
  <p>Digite seu e-mail, você receberá instruções sobre como recuperar sua senha.</p>
  <div class="input-group">
  <span class="input-group-addon"><i class="fa fa-envelope"></i></span><input class="form-control" type="text" id="email" name="email" placeholder="Endereço de E-mail" />
  </div>

  <div class="form-actions clearfix">
  <div class="pull-left">
  <a href="#loginform" class="flip-link to-login">&laquo; Voltar para o acesso</a><br />
  </div>
  <input type="submit" class="btn btn-block btn-inverse" value="Recuperar" onclick="$('#recoverModal').modal('show');"  />
  </div>

  <div class="modal fade" id="recoverModal" tabindex="-1" role="dialog" aria-labelledby="myRecoverModal" aria-hidden="true" data-backdrop="">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" onclick="$('#actionModal').modal('hide')">&times</button>
  <h3 id="actionModalTitle">Informe os caracteres para continuar</h3>
  </div>
  <div class="modal-body">
  <div class="input-group" id="recaptcha" style="margin: 0 auto 0;">
  <?php echo recaptcha_get_html_customize(RECAPTCHA_PUBLIC_KEY); ?>
  </div>
  <p>
  Para evitar a proliferação de SPAM, assim como uma medida de segurança, utilizamos este recurso para garantir que você realmente está solicitando isto.
  </p>
  </div>
  <div class="modal-footer">
  <input type="submit" class="btn btn-inverse" value="Confirmar Recuperar" onclick="eqSolicitaRecuperaSenhaSubmitHandler(this)" />
  <input type="button" class="btn btn-inverse" value="Cancelar" onclick="$('#recoverModal').modal('hide');" data-dismiss="modal" />
  </div>
  </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  </form>
  </div>
  </div>

  <script src="<?php echo URL_WEBROOT ?>js/unicorn/unicorn.login.js"></script>
  </body>
  </html>
  <? /* */ ?>