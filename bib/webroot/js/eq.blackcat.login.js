function eqLoginSubmitHandler(botao) {
    var form = botao.form;
    $(form).serialize();
    var userinput = $('#username');
    var passinput = $('#password');
    var options = {
        type: "POST",
        dataType: "json",
        data: {
            "ajaxRequest": true
        },
        beforeSubmit: function(formData, jqForm, options) {
            ajaxBeforeSend(botao);
            $("#dialog-area").html('');
        },
        success: function(serverResponse) {
            if (serverResponse.status == 'OK') {
                eqRedirectTimeout();
            } else {
                $("#senha").val('').focus();
                eqDialog(serverResponse.status);
            }
            $(botao).removeAttr('disabled').val('Acessar');
        },
        error: function(serverResponse){
            console.log(serverResponse);
            alert(serverResponse.responseText);
            $(botao).removeAttr('disabled').val('Acessar');
            ajaxError();
            eqRedirectTimeout();
        },
        complete: ajaxComplete
    };
    $(form).ajaxSubmit(options);
}


function eqSolicitaRecuperaSenhaSubmitHandler(botao) {
    var form = botao.form;
    $(form).serialize();
    var options = {
        type: "POST",
        data: {
            "ajaxRequest": true
        },
        beforeSubmit: function(formData, jqForm, options) {
            ajaxBeforeSend(botao);
            $('#recoverModal').modal('hide');
            $("#dialog-area").html('');
        },
        success: function(serverResponse) {
            if (serverResponse == 'OK') {
                eqDialog("As instruções de como recuperar a sua senha foram mandadas por e-mail.");
//                eqRedirectTimeout();

                var login = $('#loginform');
                var recover_register = $('#recoverform, #registerform');
                var loginbox = $('#loginbox');
                var speed = 300;
                recover_register.css('z-index', '100').fadeTo(speed, 0.01, function() {
                    loginbox.animate({'height': '255px'}, speed, function() {
                        login.fadeTo(speed, 1).css('z-index', '200');
                    });
                });

                $("#email").val();


            } else {
                $("#email").focus();
                eqDialog(serverResponse);
                moveFocus(form);
            }
            $('#recaptcha_reload').click();
            $(botao).removeAttr('disabled').val('Recuperar');
        },
        error: ajaxError,
        complete: ajaxComplete
    };
    $(form).ajaxSubmit(options);
}



function eqRecuperarSenhaSubmitHandler(botao) {
    var form = botao.form;
    $(form).serialize();
    var options = {
        type: "POST",
        data: {
            "ajaxRequest": true
        },
        beforeSubmit: function(formData, jqForm, options) {
            ajaxBeforeSend(botao);
            $("#dialog-area").html('');
        },
        success: function(serverResponse) {
            if (serverResponse == 'OK') {
                eqActionDialog("Senha alterada com sucesso!", "Confirmar", "eqRedirectTimeout(URL_APP)");
            } else {
                eqDialog(serverResponse);
                moveFocus(form);
            }
            $(botao).removeAttr('disabled').val('Alterar');
        },
        error: ajaxError,
        complete: ajaxComplete
    };
    $(form).ajaxSubmit(options);
}
