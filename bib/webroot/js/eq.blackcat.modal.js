function eqMessage(alertType, message, heading) {
    eqLimpaAreaAlertas();
    if (heading != undefined && heading != null)
        message = "<h4 class='alert-heading'>" + heading + "</h4>" + message;
    if (alertType == "yellow")
        alertType = "alert-warning";
    else if (alertType == "red")
        alertType = "alert-danger";
    else if (alertType == "green")
        alertType = "alert-success";
    else if (alertType == "blue")
        alertType = "alert-info";
    else
        alertType = "alert-warning"; // para todo caso, sempre mostra amarelo
    message = '<a class="close" data-dismiss="alert" href="javascript:void(0)">×</a>' + message;
    $('<div>').addClass("alert").addClass("alert-block").addClass(alertType).html(message).appendTo('#alert-box').wrap($('<div class="col-xs-12"/>'));
//    $('html, body').stop().animate({
//        'scrollTop': $('#alert-box').offset().top
//    }, 900, 'swing');
}

function eqDeleteDialog(action, redirectUrl) {
    $("#target-botao-excluir").html($('<a href="javascript:void(0)" id="botao-excluir-confirmar" class="btn btn-danger">Sim</a>').click(function() {
        $.ajax({
            url: URL + "?action=" + action,
            data: {
                "ajaxRequest": true
            },
            type: "POST",
            beforeSend: function() {
                $('#botao-excluir-confirmar').html("Enviando").addClass('disabled');
                $("#target-botao-excluir").siblings("a.btn").addClass('disabled');
            },
            success: function(serverResponse) {
                eqLimpaAreaAlertas();
                if (serverResponse == 'OK') {
                    eqMessage(eqRed, '<i class="icon-trash"></i> Registro excluído!');
                    eqRedirectTimeout(redirectUrl);
                }
                else {
                    eqMessage(eqYellow, serverResponse);
                    $('#deleteActionModal').modal('hide');
                }
                $("#target-botao-excluir").siblings("a.btn").removeClass('disabled');
            },
            error: function(response) {

            }
        });
    }));
}

function eqConfirmDialog(texto, action, redirectUrl) {
    $('#confirmationModalBody').html((texto ? texto : "Confirma a operação?"));
    $("#target-botao-confirmacao").html($('<a href="javascript:void(0)" id="botao-confirmar" class="btn btn-warning">Sim</a>').click(function() {
        $.ajax({
            url: URL + "?action=" + action,
            type: "POST",
            beforeSend: function() {
                $('#botao-confirmar').html("Aguarde...").addClass('disabled');
                $("#target-botao-confirmacao").siblings("a.btn").addClass('disabled');
            },
            success: function(serverResponse) {
                eqLimpaAreaAlertas();
                $('#confirmationModal').modal('hide');
                $("#target-botao-confirmacao").siblings("a.btn").removeClass('disabled');
                eqDialog(serverResponse, "Resultado da Operação");
                if (redirectUrl)
                    setTimeout(function() {
                        eqRedirectTimeout(redirectUrl);
                    }, 1000);
            },
            error: function(response) {

            }
        });
    }));
}

function eqActionDialog(texto, label, handler) {
    $("#actionModal").modal('show');
    $('#actionModalBody').html((texto ? texto : "Confirma a operação?"));
    $("#target-botao-acao").html($('<a href="javascript:void(0)" id="botao-acao" class="btn btn-primary">' + label + '</a>').click(
            function() {
                eval(handler);
            }
    ));
}

function eqAlternaValorAtivo(elemento, action) {
    $.ajax({
        type: "POST",
        url: URL + "index.php?action=" + action,
        beforeSend: function() {
            eqMessage(eqYellow, "Estamos enviando sua requisição...");
        },
        success: function(serverResponse) {
            if (serverResponse == 'OK') {
                eqMessage(eqGreen, "Registro alterado com sucesso!")
            } else {
                eqMessage(eqRed, serverResponse)
            }
        },
        error: ajaxError,
        complete: ajaxComplete
    });
}

function eqDeleteSelecionadosForm(form_id, action) {
    var form = document.getElementById(form_id);
    $("#target-botao-excluir-multiplos").html($('<a href="javascript:void(0)" id="botao-excluir-multiplos-confirmar" class="btn btn-danger">Sim</a>').click(function() {
        $(form).serialize();
        var options = {
            type: "POST",
            url: URL + 'index.php?&action=' + action,
            beforeSubmit: function(formData, jqForm, options) {
                $('#botao-excluir-multiplos-confirmar').html("Enviado, por favor aguarde...").addClass('disabled');
                $("#target-botao-excluir-multiplos").siblings("a.btn").addClass('disabled');
            },
            success: function(serverResponse) {
                if (serverResponse == 'OK') {
                    eqMessage(eqRed, "Registro(s) excluído(s)!");
                    $(window.location).attr('href', eqGetCurrentUrl() + '?page=' + $('#__gen_currpage_del_handler__').val() + $('#__gen_order_del_handler__').val());
                } else {
                    eqMessage(eqYellow, serverResponse);
                    $('#deleteMultipleActionModal').modal('hide');
                }
                $("#target-botao-excluir-multiplos").siblings("a.btn").removeClass('disabled');
            },
            error: ajaxError,
            complete: ajaxComplete
        };
        $(form).ajaxSubmit(options);
    }));
}
/**
 * Exibe uma dialog com um botão de confirmação.<br/>
 * <b>As dialogs são reutilizadas</b>
 * @param string texto da dialog
 * @param string texto
 * @returns esta função não retorna nenhum valor.
 */
function eqDialog(texto, titulo) {
    $('#alertModalTitle').html((titulo ? titulo : "Aviso"));
    $('#alertModalBody').html(texto);
    $('#alertModal').modal('show');
}

function eqLimpaAreaAlertas() {
    $("#dialog-area").html("")
    $("#alert-box").html("")
    $('div.ui-dialog').remove();
}

function eqDialogInclude(action, texto, dados_extra, width) {
    $("#actionModalTitle").html(texto);
    $("#actionModal").modal("show");
    $('#actionModalBody').html("<i class='fa  fa-refresh fa-spin'></i> Aguarde, carregando...");
    $.ajax({
        url: URL + 'index.php?&action=' + action,
        data: {
            dados: dados_extra,
            ajaxRequest: true
        },
        type: "POST",
        beforeSend: function() {
        },
        success: function(serverResponse) {
            if (width)
                $('#actionModalBody').html(serverResponse).closest('div.modal-dialog').css('width', width);
            else
                $('#actionModalBody').html(serverResponse);
            eqSetUpPage();
        },
        error: function(response) {

        }
    });
}

function eqDialogRelMais(elemento, titulo) {
    elemento = $(elemento);
    var texto = elemento.attr("rel");
    $("#actionModalTitle").html(titulo);
    $("#actionModal").modal("show");
    $('#actionModalBody').html(texto);
}

function eqConfirm(texto, functionOK, functionNOK, labelOK, labelNOK) {
    if (!labelOK)
        labelOK = "Sim";
    if (!labelNOK)
        labelNOK = "Não";

    $('#confirmationModalBody').html((texto ? texto : "Confirma a operação?"));
    $('#confirmationModal').modal('show');
    $("#target-botao-confirmacao").html($('<a href="javascript:void(0)" id="botao-confirmar" class="btn btn-warning">' + labelOK + '</a>').click(function() {
        $('#confirmationModal').modal('hide');
        eval(functionOK);
    }));

    if (functionNOK) {
        $("#target-botao-negacao").html($('<a href="javascript:void(0)" id="botao-negar" class="btn btn-primary">' + labelNOK + '</a>').click(function() {
            $('#confirmationModal').modal('hide');
            eval(functionNOK);
        }));
    } else {
        $("#target-botao-negacao").html('<a href="javascript:void(0)" class="btn btn-primary" data-dismiss="modal" onclick="$(\'#confirmationModal\').modal(\'hide\')">Não</a>');
    }
}



window.loadingModalStack = [];
function loadingModal(open) {
    if (open) {
        window.loadingModalStack.push(open);
        if (window.loadingModalStack.length == 1) {
            clearTimeout(window.loadingModalTimeoutId);
            $('#loadModal').modal('show');
        }
    } else {
        if (window.loadingModalStack.length == 1) {
            clearTimeout(window.loadingModalTimeoutId);
            window.loadingModalTimeoutId = setTimeout(function() {
                $('#loadModal').modal('hide');
                $(".invalid").first().focus();
            }, 500);
        }
        window.loadingModalStack.pop();
    }
    /*
     * ERRO TOO MUCH RECURSION - não se preocupar pois o controle é feito direto no ajax
     * ex beforeSend: loadingModal(1); e os outros loadingModal() - sem parametro 1
     */
//    console.log("n_req="+window.loadingModalStack.length);
}