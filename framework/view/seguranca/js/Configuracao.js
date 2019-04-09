function ConfiguracaoSubmitHandler(botao, redirect)  {
    var form = botao.form;
    var defaultValue = botao.value;
    var options = {
        type: "POST",
        data: {
            "ajaxRequest": true
        },
        beforeSubmit: function(formData, jqForm, options) {
            return ajaxBeforeSend(botao);
        },
        success: function(serverResponse) {
            if (serverResponse == 'OK') {
                if(redirect){
                    eqRedirectTimeout(URL_APP + MODULO_NAME + '/Configuracao/admFilter?MESSAGE_TYPE=1&MESSAGE_CODE=1');
                }else{
                    eqRedirectTimeout(eqGetCurrentUrl() + "?MESSAGE_TYPE=1&MESSAGE_CODE=1");
                }
            } else {
                eqMessage(eqYellow, serverResponse);
                moveFocus(form);
            }
            $(botao).attr('disabled',false).val(defaultValue);
        },
        error: ajaxError,
        complete: ajaxComplete
    };
    $(form).ajaxSubmit(options);
}

function ConfiguracaoEditHandler(botao, redirect)  {
    var form = botao.form;
    var defaultValue = botao.value;
    var options = {
        type: "POST",
        data: {
            "ajaxRequest": true
        },
        beforeSubmit: function(formData, jqForm, options) {
            return ajaxBeforeSend(botao);
        },
        success: function(serverResponse) {
            if (serverResponse == 'OK' ) {
                if(redirect){
                    eqRedirectTimeout(URL_APP + MODULO_NAME + '/Configuracao/admFilter?MESSAGE_TYPE=1&MESSAGE_CODE=2');
                }else{
                    eqRedirectTimeout(eqGetCurrentUrl() + "?MESSAGE_TYPE=1&MESSAGE_CODE=2");
                }
            } else {
                eqMessage(eqYellow, serverResponse);
                moveFocus(form);
            }
            $(botao).attr('disabled',false).val(defaultValue);
        },
        error: ajaxError,
        complete: ajaxComplete
    };
    $(form).ajaxSubmit(options);
}

function ConfiguracaoDeleteHandler(action) {
    eqDeleteDialog(action, URL_APP + MODULO_NAME + '/Configuracao/admFilter?MESSAGE_TYPE=3&MESSAGE_CODE=3&page='+$('#__gen_currpage_del_handler__').val() + $('#__gen_order_del_handler__').val());
}

function ConfiguracaoAddEmail() {
    var div_copy = $("#email-model").children("div").clone();
    $("#email-append").append(div_copy.show());
}
function ConfiguracaoAddTelephone() {
    var div_copy = $("#telefone-model").children("div").clone();
    div_copy.find('input[mask=phone]').mask('(99) 9999-9999');
    $("#telefone-append").append(div_copy.show());
}
function ConfiguracaoAddEmailContato() {
    var div_copy = $("#emailContato-model").children("div").clone();
    $("#emailContato-append").append(div_copy.show());
}