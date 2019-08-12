var countConteudo = 0;

function AtividadeSubmitHandler(botao, redirect) {
    var form = botao.form;
    var defaultValue = botao.value;
    var options = {
        type: 'POST',
        data: {
            'ajaxRequest': true
        },
        beforeSubmit: function (formData, jqForm, options) {
            return ajaxBeforeSend(botao);
        },
        success: function (serverResponse) {
            if (serverResponse == 'OK') {
                if (redirect) {
                    eqRedirectTimeout(URL_APP + MODULO_NAME + '/Atividade/admFilter?MESSAGE_TYPE=1&MESSAGE_CODE=1&Tema=' + $('#Tema').val());
                } else {
                    eqRedirectTimeout(eqGetCurrentUrl() + '?MESSAGE_TYPE=1&MESSAGE_CODE=1');
                }
            } else {
                eqMessage(eqYellow, serverResponse);
                moveFocus(form);
            }
            $(botao).attr('disabled', false).val(defaultValue);
        },
        error: ajaxError,
        complete: ajaxComplete
    };
    $(form).ajaxSubmit(options);
}

function AtividadeEditHandler(botao, redirect) {
    var form = botao.form;
    var defaultValue = botao.value;
    var options = {
        type: 'POST',
        data: {
            'ajaxRequest': true
        },
        beforeSubmit: function (formData, jqForm, options) {
            return ajaxBeforeSend(botao);
        },
        success: function (serverResponse) {
            if (serverResponse == 'OK') {
                if (redirect) {
                    eqRedirectTimeout(URL_APP + MODULO_NAME + '/Atividade/admFilter?MESSAGE_TYPE=1&MESSAGE_CODE=2&Tema=' + $('#Tema').val());
                } else {
                    eqRedirectTimeout(eqGetCurrentUrl() + '?MESSAGE_TYPE=1&MESSAGE_CODE=2');
                }
            } else {
                eqMessage(eqYellow, serverResponse);
                moveFocus(form);
            }
            $(botao).attr('disabled', false).val(defaultValue);
        },
        error: ajaxError,
        complete: ajaxComplete
    };
    $(form).ajaxSubmit(options);
}

function AtividadeDeleteHandler(action) {
    eqDeleteDialog(action, URL_APP + MODULO_NAME + '/Atividade/admFilter?MESSAGE_TYPE=3&MESSAGE_CODE=3&Tema=' + $('#Tema').val() + '&page=' + $('#__gen_currpage_del_handler__').val() + $('#__gen_order_del_handler__').val());
}

/**
 * Creates a string that can be used for dynamic id attributes
 * Example: "id-so7567s1pcpojemi"
 * @returns {string}
 */
function uniqueId() {
    return 'id-' + Math.random().toString(36).substr(2, 16);
}
;

function AtividadeAdicionarConteudo() {
    var div = $('#Atividade-conteudo-model').children('.conteudo-model').clone();
    var id = uniqueId();
    div.find('a[data-toggle="collapse"]').first().attr('href', "#" + id).attr('aria-controls', id);
    div.find('div[role="tabpanel"]').first().attr('id', id);
    div.find('span.nome').first().attr('id', "span-" + id);
    div.find('input[name="tituloConteudo[]"]').first().attr('data-id', "#span-" + id);
    $('#Atividade-conteudo-append').append(div);
    countConteudo++;
}

function AtividadeOnChangeTituloConteudo(e) {
    $($(e).data('id')).html(e.value);
}

function AtividadeAdicionarOpcao() {
    $clone = $('#Atividade-opcao-model').children('div.row').clone();
    $('#Atividade-opcao-append').append($clone.show());

    $i = 0;
    $('#atividade-opcao').find('.check').each(function () {
        $(this).val($i);
        $i++;
    });
}

function AtividadeSelecionaTipo(tipo) {
    $('.remover_div').hide();
    switch ($(tipo).val()) {
        case "PRC":
            $('#div-opcao').show();
            break;
        case "REL":
            $('#div-relaciona').show();
            break;
    }
}

function AtividadeSelecionaTipoFormulario(tipo, object, clear) {
    $conteudo = object;
    var conteudo_atual = $conteudo.prevAll().length;
    if (clear == 1)
        $conteudo.find('.opcao-conteudo').html('');
    if (tipo == "MEI" || tipo == "MEV") {
        if (tipo == "MEI")
            $cl = $("#tipo-mei").clone();
        else if (tipo == "MEV")
            $cl = $("#tipo-mev").clone();

        $cl.appendTo($conteudo.find('.opcao-conteudo'));
        $i = 0;
        $conteudo.find('.check-conteudo').each(function () {
            $(this).val($i);
            $(this).attr('name', 'opcaoConteudoCorreta[' + conteudo_atual + '][]');
            $i++;
        });

        $conteudo.find('.valor-conteudo').each(function () {
            $(this).attr('name', 'valorConteudo[' + conteudo_atual + '][]');
            $i++;
        });

        $conteudo.find('#mais-opcao').show();
    } else {
        $conteudo.find('#mais-opcao').hide();
        $conteudo.find('.opcao-conteudo').html('');
    }

}

function AtividadeRecontarConteudo() {
    $count = 1;
    $('.conteudo-model').each(function () {
        $conteudo = $(this);
        $conteudo.find('.check-conteudo').each(function () {
            $(this).attr('name', 'opcaoConteudoCorreta[' + $count + '][]');
        });

        $conteudo.find('.valor-conteudo').each(function () {
            $(this).attr('name', 'valorConteudo[' + $count + '][]');
        });
        $count++;
    });
}

var countColuna = 0;
function AtividadeAdicionarColuna(aIdIdioma) {
    countColuna = $('#coluna').val();

    countColuna++; // o controle é para todos os IDIOMAS - ENTAO SE ADICIONAR UM VAI PARA TODOS, SE APAGAR UM APAGA TODOS DAQUELA POSICAO
    $('#coluna').val(countColuna);
    var aIdioma = aIdIdioma.split("_"); // para cada idioma
    $('.Atividade-coluna-append').each(function (i) {
        $clone = $('#Atividade-coluna-model').children('div.row').clone();
        $($clone).attr("rel", "div_coluna_" + countColuna);
        $($clone).find(".numero_coluna").html(countColuna);

        // coluna A
        $($clone).find("#aColunaTmp_tipo1").attr("name", "aColunaTmp[" + aIdioma[i] + "][tipo1][]");
        $($clone).find("#aColunaTmp_TEX1").attr("name", "aColunaTmp[" + aIdioma[i] + "][TEX1][]");
        $($clone).find("#aColunaTmp_IMG1").attr("name", "aColunaTmp[" + aIdioma[i] + "][IMG1][]");
        $($clone).find("#aColunaTmp_VID1").attr("name", "aColunaTmp[" + aIdioma[i] + "][VID1][]");

        // coluna B
        $($clone).find("#aColunaTmp_tipo2").attr("name", "aColunaTmp[" + aIdioma[i] + "][tipo2][]");
        $($clone).find("#aColunaTmp_TEX2").attr("name", "aColunaTmp[" + aIdioma[i] + "][TEX2][]");
        $($clone).find("#aColunaTmp_IMG2").attr("name", "aColunaTmp[" + aIdioma[i] + "][IMG2][]");
        $($clone).find("#aColunaTmp_VID2").attr("name", "aColunaTmp[" + aIdioma[i] + "][VID2][]");

        $(this).append($clone.show());
    });
}

function AtividadeDelColuna(that) {
    var classe = $(that).closest('div.row').attr("rel");
    $('[rel="' + classe + '"]').remove();

    $('#coluna').val(--countColuna);
}

function AtividadeColunaTipo(that) {
    $(that).parent().parent().parent().find('#tipos').find('.escondeTipo').hide();
    $(that).parent().parent().parent().find('#tipos').find('#div-' + $(that).val()).show();
}