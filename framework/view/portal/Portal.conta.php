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
        <?php include dirname(__FILE__) . "/inc/config_js.php"; ?>

    </head>

    <body>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>-->
        <script type="text/javascript">
            $(document).ready(function () {
                $('.data').mask('00/00/0000');
                $('.cpf').mask('000.000.000-00', {reverse: true});
            });

        </script>
        <div class="geral">
            <?php include dirname(__FILE__) . "/inc/header.php"; ?>
            <!--            <div class="cabecalho">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">
                                        <header class="d-flex flex-column flex-md-row justify-content-between align-items-center my-3">
                                            <div class="logo d-flex flex-column flex-md-row align-items-center">
                                                <a href="<?php echo URL ?>"><img src="<?= URL_PORTAL ?>img/logo-small.png" alt="logo" class="" /></a>
                                                <a href="interna.php" class="link-quem-somos">Quem somos</a>
                                            </div>
            <?php if (isset($_SESSION['serAlunoSessao'])) {
                ?><div class="usuario-logado">Bem vindo(a): <?php echo $_SESSION['alunoNome'] ?> | <a href="<?= URL ?>logout">Sair</a></div>
            <?php } ?>
                                        </header>
                                    </div>
                                </div>
                            </div>
                        </div>-->
            <div class="conteudo">
                <div class="container-fluid">
                    <div class="container">
                        <div class="row">
                            <div class="col pagina-interna">
                                <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Portal.criarContaSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                                    <label class="label" for="nome"><?php echo Lang::CONTA_nome; ?></label>
                                    <input class="form-control"  type="text" id="titulo" name="nome" maxlength='255' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label"><?php echo Lang::CONTA_email; ?></label>
                                    <input class="form-control" type="text" id="email" name="email" maxlength='255' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label" for="dataNascimento"><?php echo Lang::CONTA_dataNascimento; ?></label>
                                    <input class="form-control data"  type="text" id="dataNascimento" name="dataNascimento" maxlength='10' mask='date' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label" for="sexo"><?php echo Lang::CONTA_sexo; ?></label>
                                    <!--<label class="input">-->
                                    <?= AlunoAction::getComboBoxForSexo(null, ( ++$tabindex), "-Selecione-"); ?>
                                    <!--</label>-->

                                    <label class="label" for="CPF"><?php echo Lang::CONTA_cpf; ?></label>
                                    <input class="form-control cpf"  type="text" id="cpf" name="cpf" maxlength='14'tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label" for="cidade"><?php echo Lang::CONTA_cidade; ?></label>
                                    <input class="form-control"  type="text" id="cidade" name="cidade" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label" for="estado"><?php echo Lang::CONTA_estado; ?></label>
                                    <input class="form-control"  type="text" id="estado" name="estado" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label" for="nacionalidade"><?php echo Lang::CONTA_nacionalidade; ?></label>
                                    <input class="form-control"  type="text" id="nacionalidade" name="nacionalidade" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label" for="instituicaoEnsino"><?php echo Lang::CONTA_instituicaoEnsino; ?></label>
                                    <input class="form-control"  type="text" id="instituicaoEnsino" name="instituicaoEnsino" maxlength='150' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label" for="curso"><?php echo Lang::CONTA_curso; ?></label>
                                    <input class="form-control"  type="text" id="curso" name="curso" maxlength='150' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label"><?php echo Lang::CONTA_login; ?></label>
                                    <input class="form-control"  type="text" id="login" name="login" maxlength='20' mask='' tabindex='<?= ( ++$tabindex) ?>'/>

                                    <label class="label"><?php echo Lang::CONTA_senha; ?></label>
                                    <input class="form-control"  type="password" id="senha" name="senha" maxlength='256' mask='' validate='1' tabindex='<?= ( ++$tabindex) ?>' value=''/>

                                    <label class="label"><?php echo Lang::CONTA_confirmarSenha; ?></label>
                                    <input class="form-control"  type="password" id="senhaConf" name="senhaConf" maxlength='256' mask='' validate='1' tabindex='<?= ( ++$tabindex) ?>' value=''/>
                                    <br/>

                                    <input class="" value="S" onchange="carregaCamera(this);" type="checkbox" id="loginFacial" name="loginFacial" tabindex='<?= ( ++$tabindex) ?>' />
                                    <label class="label"><?php echo Lang::CONTA_loginFacial; ?></label>
                                    <br/>
                                    <div id="camera" style="display: none">
                                        <?php include dirname(__FILE__) . "/Portal.camera.php"; ?>
                                    </div>
                                    <br/>

                                    <div class="input-group" id="recaptcha" style="margin: 0 auto 0;">
                                        <script src='https://www.google.com/recaptcha/api.js?hl=<?php echo $_SESSION['lang']; ?>'></script>
                                        <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_PUBLIC_KEY ?>"></div>
                                    </div>
                                    <br/>
                                    <div>
                                        <button class="btn btn-primary" onclick="criarContaSubmit(this);" tabindex="<?= ++$tabindex ?>" ><?php echo Lang::CONTA_enviar; ?></button>
                                        <a href="<?php echo URL . "login/" ?>" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><?php echo Lang::GERAL_voltar; ?></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

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
                        <a class="btn btn-primary" data-dismiss="modal">Ok</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <?php include dirname(__FILE__) . "/inc/footer.php"; ?>


        <!--CONDIGURAÇÃO SCRIPS-->
    </body>
</html>
