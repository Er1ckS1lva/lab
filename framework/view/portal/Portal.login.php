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
        <title>Login - Laboratório Virtual</title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include dirname(__FILE__) . "/inc/config_css.php"; ?>
        <?php include dirname(__FILE__) . "/inc/config_js.php"; ?>
        <!--<script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>--> 


    </head>

    <body>
        <div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog" aria-labelledby="myDynamicModal" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <p id="dynamicModalBody"></p>
                    </div>
                    <div class="modal-footer">
                        <!--<a id="btn_ok" class="btn btn-primary ok">Sim</a>-->
                        <a class="btn btn-primary cancel" data-dismiss="modal">ok</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="geral">
            <?php include dirname(__FILE__) . "/inc/header.php"; ?>;


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Recuperar senha</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= URL ?>index.php?action=Portal.solicitaRecuperaSenhaSubmit" onsubmit="return false;">
                                <p>Digite seu e-mail, você receberá instruções sobre como recuperar sua senha.</p>
                                <div class="input-group">
                                    <input type="email" id="email-recuperacao" name="email-recuperacao" class="form-control" placeholder="Informe o seu e-mail cadastrado" />
                                </div>
                                <br/>
                                <div class="input-group" id="recaptcha" style="margin: 0 auto 0;">
                                    <script src='https://www.google.com/recaptcha/api.js'></script>
                                    <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_PUBLIC_KEY ?>"></div>
                                </div>
                                <br/>
                                <p>
                                    Para evitar a proliferação de SPAM, assim como uma medida de segurança, utilizamos este recurso para garantir que você realmente está solicitando isto.
                                </p>
                                <input style="display: none;" id="button_recuperar" type="submit" onclick="recuperaSenhaSubmit(this)"/>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" onclick="$('#button_recuperar').click()" >Enviar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="container">

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="panel-login h-100">
                                <div class="p-5 d-flex flex-column justify-content-center h-100 w-100">
                                    <h1 class="display-6">Acessar</h1>
                                    <p class="lead"></p>
                                    <hr class="my-4">
                                    <form action="<?php echo URL ?>index.php?action=Portal.loginSubmit" id="login-form" onsubmit="return false;">
                                        <input class="" value="S" onchange="carregaCamera(this);" type="checkbox" id="loginFacial" name="loginFacial" tabindex='<?= ( ++$tabindex) ?>' />
                                        <label class="label"><?php echo Lang::loginFacial; ?></label>
                                        <div class="mb-2">
                                            <input type="text" id="login" name="login" class="form-control" placeholder="Login" value="<?= isset($_COOKIE["login_digitado" . SESSION_NAME]) ? $_COOKIE["login_digitado" . SESSION_NAME] : "" ?>"/>
                                        </div>
                                        <div class="mb-2" id="camera" style="display: none">
                                            <?php include dirname(__FILE__) . "/Portal.cameraLogin.php"; ?>
                                        </div>
                                        <div class="mb-2 password">
                                            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" value="<?= isset($_COOKIE["senha_digitado" . SESSION_NAME]) ? $_COOKIE["senha_digitado" . SESSION_NAME] : "" ?>" />
                                        </div>
                                        <br>
                                        <div class="d-flex align-items-center">
                                            <button id="log-in" class="btn btn-primary btn-login" role="button" type="submit" onclick="loginSubmit(this)">Acessar</button>&ensp;
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">Continuar conectado</label>
                                            </div>
                                        </div>
                                    </form>
                                    <hr />
                                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-lock"></i> Esqueceu sua senha</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="panel-login h-100">
                                <div class="p-5 d-flex flex-column justify-content-center h-100 w-100">
                                    <h1 class="display-6">É a sua primeira vez aqui?</h1>
                                    <div class="text-center py-3">
                                        <h5>
                                            <b>Instruções para criação de conta:</b><br>
                                        </h5>
                                        <ul>
                                            <li>
                                                <b>Identificação de Usuário</b>: preencha com sua identificação
                                                estudantil ou funcional.
                                            </li>
                                            <li>
                                                <b>Endereço de E-mail</b>: preencha com sua conta de e-mail
                                                institucional (<b>e-mail @ufu.br</b>). Não será permitido
                                                endereço de e-mail provenientes de outras contas (exemplo
                                                Google, Yahoo, Hotmail, Outlook etc).<br>
                                            </li>
                                        </ul>

                                        <a id="create-account" href="<?php echo URL . "conta/" ?>" class="btn btn-primary my-3"> Criar uma conta</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function playAudio(audio) {
                    $('#ufu_audios').replaceWith(
                            $("<audio></audio>").attr({
                        id: "ufu_audios",
                        'src': audio,
                        'volume': 0.4,
                        'autoplay': 'autoplay'
                    })
                            );
                    document.getElementById('ufu_audios').play();
                }
                $(function () {
                    $("#log-in").mouseenter(function () {
                        playAudio('<?php echo URL . "ext/audios/en_us/LOG IN 2.mp3" ?>');
                    });
                    $("#create-account").mouseenter(function () {
                        playAudio('<?php echo URL . "ext/audios/en_us/SIGN UP.mp3" ?>');
                    });
                });
            </script>
        </div>
        <?php include dirname(__FILE__) . "/inc/footer.php"; ?>

        <!--CONDIGURAÇÃO SCRIPS-->
        <audio id="ufu_audios"></audio>
    </body>
</html>
