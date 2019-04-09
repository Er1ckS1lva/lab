<!-- CKEditor -->
<script type="text/javascript" src="<?= URL ?>ext/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?= URL ?>ext/ckeditor/ckfinder/ckfinder.js"></script>


<?
if (isset($_USE_TREETABLE) && $_USE_TREETABLE === TRUE) {
    ?>
    <!--Arvore-->
    <script type="text/javascript" src="<?= URL_WEBROOT ?>js/jquery/jquery.treetable.js"></script>
    <link rel="stylesheet" href="<?= URL_WEBROOT ?>css/jquery/jquery.treetable.css" />
    <link rel="stylesheet" href="<?= URL_WEBROOT ?>css/jquery/jquery.treetable.theme.default.css" />
    <script type="text/javascript">
        $(document).ready(function() {
            $("#treetable-advanced").treetable({expandable: true});
            $("#treetable-advanced").treetable('expandAll');
        });
    </script>
    <?
}
?>

<?
if (isset($_USE_WEBCAM) && $_USE_WEBCAM === TRUE) {
    ?>
    <!--WEBCAM JS-->
    <script type="text/javascript" src="<?= URL ?>ext/webcamjs-master/webcam.js"></script>
    <script type="text/javascript">
        Webcam.set({
            image_format: 'png',
            jpeg_quality: 90
        });
        $('#pictureModal').on('shown.bs.modal', function(e) {
            WebcamInit();
        });
        $('#pictureModal').on('hide.bs.modal', function(e) {
            WebcamFinish();
        });
        function WebcamInit() {
            Webcam.attach('#camera_live');
        }
        function WebcamFinish() {
            Webcam.reset();
        }
        var __WebcamPicture__;
        function WebCamSnap() {
            var data_uri = Webcam.snap();
            var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
            // para seu ferramenta (modal)
            $('#camera_preview').html($('<img class="img-thumbnail img-responsive" src="' + data_uri + '"/>'));
            // para seu formulário
            $('#camera_form_preview').html($('<img class="img-thumbnail img-responsive" width="180"  src="' + data_uri + '"/>'));
            $('#camera_form_input').val(raw_image_data);
            __WebcamPicture__ = {
                'img': data_uri,
                'data': raw_image_data
            };
        }
    </script>
    <?
}
?>

<?
if (isset($_USE_WIZARD) && $_USE_WIZARD === TRUE) {
    ?>
    <!--Wizard-->
    <script type="text/javascript" src="<?= URL_WEBROOT ?>js/smart/plugin/fuelux/wizard/wizard.js"></script>
    <script type="text/javascript">
        var wizard;
        $(document).ready(function() {
            // fuelux wizard
            wizard = $('.wizard').wizard();

    <? if (isset($aValidateWizard)) { ?>
                // valida a cada etapa se tiver $aValidateWizard
                wizard.on('change', function(e, data) {
                    if (data.direction == "next") {
                        if (validateScriptWizardHeader("<?= join(",", $aValidateWizard) ?>")) {
                            return false;
                        }
                    }
                    return true;
                });
    <? } ?>

            wizard.on('finished.fu.wizard', function(e, data) {
                $.smallBox({
                    title: "Seu formulário está sendo submetido...",
                    content: "<i class='fa fa-clock-o'></i> <i>Aguarde enquanto seu formulário é enviado.</i>",
                    color: "#305d8c",
                    iconSmall: "fa fa-clock bounce animated",
                    timeout: 4000
                });
                eqMessage(eqBlue, "<i class='fa fa-clock-o'></i> <i>Aguarde enquanto seu formulário é enviado.</i>", "Seu formulário está sendo submetido");
                $("#button-submit").click();
                //                $("#fuelux-wizard").submit();
                return false;
                //                console.log("submitted!");
                //                $.smallBox({
                //                    title: "Seu formulário foi submetido!",
                //                    content: "<i class='fa fa-clock-o'></i> <i>1 segundo atrás...</i>",
                //                    color: "#5F895F",
                //                    iconSmall: "fa fa-check bounce animated",
                //                    timeout: 4000
                //                });
            });
        });

        // muito semelhante - validateScriptTopo()
        function validateScriptWizardHeader(sValidate) {
            if (sValidate) {
                var aValidate = sValidate.split(",");
                for (var i = 0; i < aValidate.length; i++) {
                    var name = aValidate[i];
                    var validate = null;
                    if ($("[name='" + name + "']").length) {
                        validate = $("[name='" + name + "']");
                    } else if ($("#" + name).length) {
                        // para caso suggest - sempre tem o id
                        validate = $("#" + name + "Suggest");
                        name = name + "Suggest";
                    }

                    if (validate && validate.length) {
                        if (name && name != "" && name != null && name != undefined) {
                            var asterisco = $(validate).closest("section").find('label.label');
                            // nao repete o asterisco, adicionar o * - ver se muda CAMPO_OBRIGATORIO
                            if (asterisco.find("span").html() != "*")
                                asterisco.prepend(CAMPO_OBRIGATORIO + " ");
                        }

                        // verifica se tem valor, esta visivel e entao valida =)
                        var valor = retornaValorValidate($(validate));
                        if (!valor) {
                            if ($(validate).is(':visible')) {
                                var validate_text = $(validate).attr('i-validate-text') ? $(validate).attr('i-validate-text') : 'Este campo é obrigatório!';
                                // poem a classe de error do validade
                                validate.parent().addClass("state-error");
                                var id_error = eliminarCaracteresInvalido('em_state_error_' + name, "A"); // somente permido pelo id
                                // so adiciona o em de alert senao tiver para aquele campo
                                if (!$("#" + id_error).length)
                                    validate.parent().parent().append('<em for="' + name + '" class="invalid" id="' + id_error + '">' + validate_text + '</em>');

                                // poem foco e valida
                                $(validate).focus();
                                return true;
                            }
                        }
                    }

                }
            }
            return false;
        }
    </script>

    <script type="text/javascript">
        // METODO PARA ADICIONAR A ABA DE UM OUTRO ALMOXARIFADO - SO PARA O ADD POIS NAO MUDA O ALMOXARIFADO
        function selecionaAlmoxarifado(id_almoxarifado) {
            // nao esta funcionando adicionar nem remover passos então deixar sem essa "REGRA" por enquanto 19/09/2014
            return false;
            switch (id_almoxarifado) {
                //        case 1:
                //            break;
                //        case 2:
                //            break;
                default:
                    $(wizard).wizard('removeSteps', 3, 1);
                    $(wizard).wizard('addSteps', 3, [
                        {
                            data: ':1',
                            badge: 'badge',
                            label: '3',
                            pane: '<div>Content</div>'
                        }
                    ]);

                    break;
            }
        }
    </script>
    <?
}
?>


<? if (isset($_USE_WIZARD_TAB) && $_USE_WIZARD_TAB === TRUE) { ?>
    <!--Wizard Tabs-->
    <script type="text/javascript" src="<?php echo URL_WEBROOT; ?>js/smart/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script type="text/javascript">
        $('#bootstrap-wizard').bootstrapWizard({
            'tabClass': 'form-wizard',
            'onNext': function(tab, navigation, index) {

            }
        });
    </script>
    <?
}
?>

<script src="<?= URL_WEBROOT ?>js/smart/plugin/x-editable/jquery.mockjax.min.js"></script>
<script src="<?= URL_WEBROOT ?>js/smart/plugin/x-editable/x-editable.min.js"></script>