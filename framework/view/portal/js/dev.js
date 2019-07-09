$(window).ready(function () {
    if (document.getElementById('aceite') != undefined) {
        $('#aceite').modal('show')
    }
});

function criarContaSubmit(botao) {
    var count = $('[name^="afoto[]"]').length;

    if (count >= 5 || true) {
        var form = botao.form;
        $(form).serialize();
        var options = {
            type: "POST",
            dataType: "json",
            data: {
                "ajaxRequest": true
            },
            beforeSubmit: function (formData, jqForm, options) {
                $('#dynamicModal').modal();
                $("#dynamicModal").show();
                $("#dynamicModal .modal-body").html('<p id="dynamicModalBody">Aguarde...</p>');
            },
            success: function (serverResponse) {
                if (serverResponse.status == 'OK') {
                    $(window.location).attr('href', URL_NOVA);
                } else {
                    $("#dynamicModal .modal-body").html('<p id="dynamicModalBody"> ' + serverResponse + '</p>');
                }
            },
            error: function (serverResponse) {
                console.log(serverResponse);
                $("#dynamicModal .modal-body").html('<p id="dynamicModalBody"> ' + serverResponse + '</p>');
            }
        };
        $(form).ajaxSubmit(options);
    } else {
        alert('Você precisar tirar 5 fotos!');
    }
}

function loginSubmit(botao) {
    var form = botao.form;
    $(form).serialize();
    var options = {
        type: "POST",
        dataType: "json",
        data: {
            "ajaxRequest": true
        },
        beforeSubmit: function (formData, jqForm, options) {
            $('#dynamicModal').modal('toggle');
            $("#dynamicModal").show();
            $(".modal-body").html('<p id="dynamicModalBody">Aguarde...</p>');
        },
        success: function (serverResponse) {
            if (serverResponse.status == 'OK') {
                $(".modal-body").html('<p id="dynamicModalBody">Cadastro realizado. Aguarde 24 horas para que seu cadastro seja moderado!</p>');
                $("#dynamicModal").hide();
                $(window.location).attr('href', URL_NOVA);
            } else {
                $(".modal-body").html('<p id="dynamicModalBody"> ' + serverResponse.status + '</p>');
                $("#senha").val('').focus();
            }
            $(botao).removeAttr('disabled').val('Acessar');
        },
        error: function (serverResponse) {
        }
    };
    $(form).ajaxSubmit(options);
}

function recuperaSenhaSubmit(botao) {
    var form = botao.form;
    $(form).serialize();
    var options = {
        type: "POST",
        data: {
            "ajaxRequest": true
        },
        beforeSubmit: function (formData, jqForm, options) {

        },
        success: function (serverResponse) {
            if (serverResponse == 'OK') {
                $(".modal-body").html("As instruções de como recuperar a sua senha foram enviadas para o seu email.");
                $(window.location).attr('href', URL_NOVA);
            } else {
                $(".modal-body").html(serverResponse);
            }
            $('#recaptcha_reload').click();
        },
        error: function (serverResponse) {
            $(".modal-body").html("Ocorreu um erro inesperado. Tente novamente mais tarde!");
        }
    };
    $(form).ajaxSubmit(options);
}

function formComentarioSubmit(botao) {
    var form = botao.form;
    var defaultValue = botao.value;

    var options = {
        type: "POST",
        beforeSubmit: function (formData, jqForm, options) {
            $('#dynamicModal').modal('toggle');
            $("#dynamicModal").show();
            $(".modal-body").html('<p id="dynamicModalBody">Enviando...</p> <div class="progress progress-striped active"><div class="progress-bar progress-bar-danger" style="width: 100%;"></div>');
        },
        success: function (msg) {
            if (msg === "OK") {
                $(".modal-body").html('<p id="dynamicModalBody"> Obrigado por seu comentário, ele será moderado e em breve será exibido</p>');
                document.getElementById("frm").reset();
            } else {
                $(".modal-body").html('<p> Houve um erro!</p><p id="dynamicModalBody"> ' + msg + '</p>');
            }
        }
    };
    $(form).ajaxSubmit(options);
}

function aceitaTermo(botao) {
    if (botao.id == "aceite") {
        $.ajax({
            url: URL_NOVA + "?action=Aluno.aceitaTermo",
            beforeSend: function () {
                $(".modal-body").html('<p id="dynamicModalBody">Enviando...</p> <div class="progress progress-striped active"><div class="progress-bar progress-bar-danger" style="width: 100%;"></div>');
            },
            success: function (msg) {
                if (msg == "OK") {
                    $(window.location).attr('href', URL_NOVA);
                } else {
                    $(".modal-body").html('<p> Houve um erro!</p><p id="dynamicModalBody"> ' + msg + '</p>');
                }
            }
        });

    } else if (botao.id == "noaceite") {
//        se ele não aceita o sistema desloga
        $(window.location).attr('href', URL_NOVA + 'logout');
    }
}

function carregaCamera(objeto) {
    var loginFacial = objeto.checked;
    if (loginFacial) {
        $("#camera").show();
        $(".password").hide();
        Webcam.set({
            width: 300,
            height: 220,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');
    } else {
        Webcam.reset();
        $("#camera").hide();
        $(".password").show();
    }
}

function excluiFotoReload(div) {
    var id = (div.parent().attr('class'));
    $("#" + id).remove();
}