function RelatorioCarregaHora(valueInicial) {
    $isDisabled = true;
    $('#horaFinal option').each(function () {
        if (this.value == valueInicial) {
            $isDisabled = false;
        }
        if ($isDisabled) {
            $(this).attr("disabled", true);
        } else {
            $(this).removeAttr("disabled");
        }

    });
}

function alternaAbaDetalhe(div, id, form = null) {
    var serializeDados = null;
    if (form) {
        serializeDados = $(form.form).serialize();
    }

    $.ajax({
        url: URL + "?action=Relatorio.laboratorioDetalhe&div=" + div + "&dados=" + id,
        data: serializeDados,
        beforeSend: function () {
            $('#' + div).html('<div class="row"><div class="col-sm-12 text-center"><span class="fa fa-refresh fa-spin fa-2x"></span><br/>Carregando...</div></div>');
        },
        success: function (response) {
            $("#" + div).html(response);
        },
        error: function (response) {
            alert(response);
            console.log(response);
        }
    });
}

function alternaUsuarioAbaDetalhe(div, id, form = null) {
    var serializeDados = null;
    if (form) {
        serializeDados = $(form.form).serialize();
    }

    $.ajax({
        url: URL + "?action=Relatorio.relUsuarioDetalhe&div=" + div + "&dados=" + id,
        data: serializeDados,
        beforeSend: function () {
            $('#' + div).html('<div class="row"><div class="col-sm-12 text-center"><span class="fa fa-refresh fa-spin fa-2x"></span><br/>Carregando...</div></div>');
        },
        success: function (response) {
            $("#" + div).html(response);
        },
        error: function (response) {
            alert(response);
            console.log(response);
        }
    });
}