/* FUNÇÕES AUXILIARES DE FORMULÁRIO */
function eqSetUpPage() {

//    Mousetrap.bind("esc", function() {
//    });
//    Mousetrap.bind(['ctrl+enter', 'command+enter'], function() {
//    });
//    CKFinder.setupCKEditor(null, URL + 'ext/ckeditor/ckfinder/');

    // função que varre o menu para selecionar ativo
    var selectedEntity = $('nav ul').attr('selectedEntity');
    var selectedMethod = $('nav ul').attr('selectedMethod');
    if (IS_MODULE_INDEX) {
        $('li[module="' + MODULO_NAME + '"]').addClass('active').find("ul:first").slideDown(200);
    } else {
        $('li[entity]').each(function (i, e) {
            var aEntidade = $(e).attr('entity').split(";");
            if (aEntidade.length > 1 && in_array(selectedEntity, aEntidade)) {
                $(e).find("a[href$='/" + selectedEntity + "/" + selectedMethod + "']").first().parent("li").addClass('active');
            } else if (selectedEntity === $(e).attr('entity')) {
                var a = $(e).find("a[href$='/" + selectedEntity + "/" + selectedMethod + "']");
                if (a.length > 0)
                    a.first().parent("li").addClass('active');
                else
                    $('li[entity="' + selectedEntity + '"]').addClass('active');
            }
        });
    }

    $("form input[mask='date']:text").each(function (i, e) {
        $(("<i class='icon-prepend fa fa-calendar'></i>")).insertBefore(e);
        var datapickerTemp = $(e).datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function (ev) {
            datapickerTemp.hide();
        }).data('datepicker');
    });

    /* Fim das Ações do Bootstrap */

    setUpRegistryCounter();

    setUpMaskedInput();

    setUpSelectMultiple();

    setUpDataTable();

    // Remove os parametros

    setUpSuggest();

    setUpEditable();

    setFormFocus();
}

function setUpSuggest() {
    $("suggest").each(function (index, domElem) {
        var idName = $(domElem).attr('id');
        var realInputName = $(domElem).attr('name') ? $(domElem).attr('name') : idName;
        var entity = $(domElem).attr('entity');
        var hasComboBox = $(domElem).attr('hasComboBox');
        var hasPageLoad = $(domElem).attr('hasPageLoad');
        var idValue = $(domElem).attr('value');
        var tabindex = $(domElem).attr('tabindex');
        var onSelect = $(domElem).attr('onSelect');
        var action = $(domElem).attr('action');
        var only = $(domElem).attr('only') ? $(domElem).attr('only') : false;
        var filter = $(domElem).attr('filter') ? $(domElem).attr('filter') : false;

        var delay = $(domElem).attr('delay') ? $(domElem).attr('delay') : 1200;

        var placeholder = "Digite para pesquisar";
        var pageSuggest = $(domElem).attr('pageSuggest') ? $(domElem).attr('pageSuggest') : '0';

        // begin all - com quantidade para começar a busca
        var all = $(domElem).attr('all') ? 1 : 0;
        var minLength = $(domElem).attr('minLength') ? $(domElem).attr('minLength') : 0;
        if (minLength) {
            placeholder = "Digite " + minLength + " caracteres para pesquisar";
        }
        if (filter) {
            placeholder += " e é possível selecionar um item da lista";
        } else {
            placeholder += " e selecione um item da lista";
        }
        // end all - com quantidade para começar a busca

        var descValueJSON = null;
        var descValue = $(domElem).attr('descValue');

        if (idValue !== undefined && idValue != '' && (descValue === undefined || descValue === '')) {
            var errSuggest = false;
            descValueJSON = $.ajax({
                url: URL + "index.php?action=" + entity + ".suggest&ajaxRequest=1",
                dataType: "json",
                data: 'idValue' + '=' + idValue,
                async: false,
                error: function (data) {
                    errSuggest = true;
                    var erro = new String(data.responseText);
                    alert(erro + " (" + idName + ")");
                }
            }).responseText;

            if (!errSuggest) {
                descValueJSON = eval("(" + descValueJSON + ")");

                for (prop in descValueJSON) {
                    descValue = descValueJSON[prop].desc;
                }
            }
        }

        var divBase = $('<div class="input-group"/>');
        $(domElem).replaceWith(divBase);

        var suggestInput = $("<input placeholder='" + placeholder + "' class='form-control' type='text' id='" + idName + "Suggest' name='" + idName + "Suggest' value='" + (descValue != undefined ? descValue : '') + "' eqsuggest='true' tabindex='" + tabindex + "' />");
        $(divBase).html(suggestInput);

        var onSelectHandler = function (id, value) {
            var fun = new Function('id', 'value', onSelect);
            fun.call(document.getElementById(idName), id, value);
        };
        var url = "action=" + entity + ".suggest";
        var beforeSubmitHandler = null;
        if (action) {
            beforeSubmitHandler = action;
        }

        $('#' + idName + 'Suggest').eq_autocomplete({
            url: URL + "index.php?" + url,
            realInput: idName,
            realInputName: realInputName,
            hasComboBox: hasComboBox != undefined ? hasComboBox : false,
            hasPageLoad: hasPageLoad == undefined ? false : hasPageLoad, // por padrao ou senao tiver false
            idValue: (descValue != undefined ? idValue : null),
            onSelect: onSelectHandler,
            beforeSubmit: beforeSubmitHandler,
            tabindex: tabindex,
            only: only,
            filter: filter,
            minLength: minLength,
            delay: delay,
            all: all,
            pageSuggest: pageSuggest
        });
    });
}

function countJsonAjax(json, properties) {
    if (properties == undefined)
        properties = 19; // 19 é aonde fica o objeto de resposta do ajax

    var arr = [];
    for (var prop in json) {
        arr.push(json[prop]);
    }
    // console.log(arr); // sao 22
    return (arr[properties].length);
}

function setUpRegistryCounter() {

}

function setUpDataTable() {
    $('.eqDataTable').each(function (i, e) {
        var paginateStyle = $(this).attr("rel") !== "" ? $(this).attr("rel") : "bootstrap_full";

        if (paginateStyle === undefined) {
            $(this).dataTable({
                "oLanguage": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });
        } else {
            $(this).dataTable({
                "sPaginationType": paginateStyle,
                "oLanguage": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });
        }
    });
}

function setUpMaskedInput() {
    // Códigos de Máscaras
    $("form input[mask='date']:text").mask('99/99/9999');
    $("form input[mask='cep']:text").mask('99999-999');
    $("form input[mask='time']:text").mask('99:99:99');
    $("form input[mask='hour']:text").mask('99:99');
    $("form input[mask='cpf']:text").mask('999.999.999-99');
    $("form input[mask='cnpj']:text").mask('99.999.999/9999-99');
    $("form input[mask='phone']:text").focusout(function () {
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if (phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    }).trigger('focusout');
    //$("form input[mask]:text").removeAttr("mask");

    //Mascaras de decima
    $("form input[mask='decimal']:text").maskMoney({
        showSymbol: false,
        decimal: ",",
        thousands: "."
    });
    $("form input[mask='money']:text").maskMoney({
        symbol: "R$",
        decimal: ",",
        thousands: "."
    });
    $("form input[mask='datePeriodo']:text").mask('99/9999');
    $("form input[mask='datePeriodoCurto']:text").mask('99/99');
}

function setUpSelectMultiple() {
    $(".low input[type='button']").click(function () {
        var arr = $(this).attr("name").split("TO"); // TO é protegido no nome do ID
        var from = arr[0];
        var to = arr[1];
        $("#" + from + " option:selected").each(function () {
            $("#" + to).append($(this).clone());
            $(this).remove();
        });
    });
}

function removeQueryStringAndHashFromPath(url) {
    url = new String(url);
    return url.split("?")[0].split("#")[0];
}

function eqGetCurrentUrl() {
    return removeQueryStringAndHashFromPath($(window).attr('location'));
}

function eqRedirectTimeout(url) {
    if (!url)
        url = eqGetCurrentUrl();
    $(window.location).attr('href', url);
}

function setUpEditable() {
    $('.ativo_inativo').each(function (i, e) {
        var that = $(this);
        var valorDefault = that.html();
        var aValores = new Array();
        
        var valores = that.attr("data-values").split(",");
        $(valores).each(function (i, e) {
            var valor = valores[i].split(":");
            aValores[i] = {value: valor[0], text: valor[1]};
        });

        $(that).editable({
            showbuttons: true,
            success: function (response, newValue) {
                if (response == "OK") {
                    eqRedirectTimeout($(window).attr('location') + "?MESSAGE_TYPE=1&MESSAGE_CODE=2");
                } else {
                    eqDialog(response, "Erro");
                    // senao OK retorna para o valor inicial
                    window.setTimeout(
                            function () {
                                that.html(valorDefault);
                            }
                    , 1000);
                }
            },
            source: aValores
        });
    });
}

function setFormFocus(tab) {
    if (!tab)
        tab = 1; // senão passar o tab padrão é 1
    gFoco = retornaElementoFocusPorTabIndex(tab);
//    alert(tab + "/" + gFoco);
    if (gFoco)
        gFoco.focus();
    else {
        window.setTimeout(
                function () {
                    $('select[disabled!="disabled"]:first , textarea[disabled!="disabled"]:first, textarea[readonly!="readonly"]:first,input[type!="hidden"]:first, input[readonly!="readonly"]:first, input[disabled!="disabled"]:first, select', 'form').first().focus();
                }
        , 0);
    }
}

function retornaElementoFocusPorTabIndex(index) {
    //Varre todos os campos que foram setados com tabindex
    var form = document.forms[1]; // agora o 0 é o relógio
    if (form) {
        var tam = form.elements.length;
        var foco = false;
        for (var i = 0; i < tam; i++) {
            //verifica se o tabindex setado é o desejado
            if (form.elements[i].tabIndex == index) {
                // verifica se esta visivel
                if ($(form.elements[i]).is(':visible')) {
                    // verifica se esta disponível
                    if (!$(form.elements[i]).attr("readonly") && !$(form.elements[i]).attr("disabled")) {
                        //se for, seta o foco para ele
                        foco = form.elements[i];
                        break;
                    }
                } else {
                    index += 1;
                }
            }
        }
    }
    return foco;
}

function togglePrintOptions() {
    $('ul.printable').each(function () {
        $(this).toggle();
    });
}
function toggleRecordsQuantityOptions() {
    $('ul.records').each(function () {
        $(this).toggle();
    });
}


/* FUNÇÕES AUXILIARES AJAX */
function ajaxBeforeSend(botao) {
    if (botao) {
        if ($(botao.form).valid() === false)
            return false;
        $(botao).focus();
        $(botao).attr('value', 'Enviando...');
    }
    loadingModal(1);
    eqLimpaAreaAlertas();
    $(".btn").each(function (i, e) {
        $(e).attr('disabled', true);
    });
    $("select[uType='multiple'] option").each(function () {
        $(this).prop('selected', true);
    });
    return true;
}
function ajaxError() {
    loadingModal();
}

function ajaxComplete() {
    loadingModal();
    $(".btn").each(function (i, e) {
        $(e).removeAttr('disabled');
    });
}


// http://stackoverflow.com/questions/4825683/how-do-i-create-and-read-a-value-from-cookie
function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : ("; expires=" + exdate.toUTCString()));
    document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
    var i, x, y, ARRcookies = document.cookie.split(";");
    for (i = 0; i < ARRcookies.length; i++)
    {
        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
        x = x.replace(/^\s+|\s+$/g, "");
        if (x == c_name) {
            return unescape(y);
        }
    }
}

function setCookieMenuSession() {
    var class_body = $("body").attr("class");
    var aux = class_body.split(" ");
    var bExiste = false;
    for (var i = 0; i < aux.length; i++) {
        if (aux[i] === "minified") {
            bExiste = true;
            break;
        }
    }
    var tipo;
    if (!bExiste)
        tipo = "recolher";
    else
        tipo = "expandir";

//    alert(tipo);
    setCookie("class_body", tipo);
}

// Referencia: http://css-tricks.com/snippets/jquery/smooth-scrolling/
function scrollAnimado(elemento) {
    if (location.pathname.replace(/^\//, '') == elemento.pathname.replace(/^\//, '') || location.hostname == elemento.hostname) {
        var target = $(elemento.hash);
        target = target.length ? target : $('[class=' + elemento.hash.slice(1) + ']');

        if (target.length) {
            $('html,body').animate({
                scrollTop: target.offset().top
            }, 1000);
            return false;
        }
    }
}



function retornaParametros(oForm) {
    params = new Array();
    j = 0;
    for (var i = 0; i < oForm.elements.length; i++) {
        switch (oForm.elements[i].type) {
            case "text":
                params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].value);
                break;
            case "password":
                params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].value);
                break;
                //            case "hidden": // não mais utilizado FCK
                //                if (typeof(FCKeditorAPI) !== 'undefined') {
                //                    var oEditor = FCKeditorAPI.GetInstance(oForm.elements[i].name);
                //                }
                //                if (oEditor == undefined) {
                //                    params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].value);
                //                } else {
                //                    var oEditor = FCKeditorAPI.GetInstance(oForm.elements[i].name);
                //                    params[j++] = oForm.elements[i].name + '=' + escape(oEditor.EditorDocument.body.innerHTML);
                //                }
                //                break;
            case "select-one":
                params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].options[oForm.elements[i].selectedIndex].value);
                break;
            case "radio":
                if (oForm.elements[i].checked)
                    params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].value);
                break;
            case "textarea":

                if (typeof (CKEDITOR) != "undefined") {
                    //                    if (CKEDITOR.instances[form.elements[i].name]) { // ckeditor
                    var oEditor = CKEDITOR.instances[oForm.elements[i].name];
                    params[j++] = oForm.elements[i].name + '=' + escape(oEditor.getData());
                    //                    }
                } else {
                    params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].value);
                }

                break;
            case "checkbox":
                if (oForm.elements[i].checked)
                    params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].value);
                break;
            case "select-multiple":
                for (var z = 0; z < oForm.elements[i].options.length; z++) {
                    if (oForm.elements[i].options[z].selected)
                        params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].options[z].value);
                }
                break;

            default:
                params[j++] = oForm.elements[i].name + '=' + escape(oForm.elements[i].value);
                break;
        }
    }

    return params.join('&');
}

function retornaValorRadio(name) {
    var radio = document.getElementsByName(name);
    for (var i = 0; i < radio.length; i++) {
        if (radio[i].checked) {
            var rad_val = radio[i].value;
        }
    }
    return rad_val;
}

function retornaValorValidate(elemento) {
    var type = elemento.attr('type');
    var valor = null;
    switch (type) {
        case "text":
        case "password":
            valor = $(elemento).val();
            break;
        case "radio":
            valor = retornaValorRadio(elemento.attr("name"));
            break;
        case "checkbox":
            valor = $("input[name=" + elemento.attr("name") + "]:checked").val();
            break;
        case "select-one":
            valor = $(elemento).val();
            break;
        case "select-multiple":
            var aValor = Array;
            $("input[name=" + elemento.attr("name") + "]" + ' :selected').each(function () {
                aValor[$(this).val()] = $(this).text();
            });
            valor = aValor;
            break;

        default:
            valor = $(elemento).val();
            break;
    }
    return valor;
}