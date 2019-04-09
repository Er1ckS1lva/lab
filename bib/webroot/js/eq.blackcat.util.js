function moveFocus(oForm) {
    var names = htmlCollectionToArrayName(oForm.elements);
    loop:for (var i = 0; i < oForm.elements.length; i++) {
        id = oForm.elements[i].id;
        name = oForm.elements[i].name;
        validate = oForm.elements[i].getAttribute('validate');
        tab = oForm.elements[i].getAttribute('tabindex');
        type = oForm.elements[i].type;
        val = null;

        //depura = "I:"+id+"|N:"+name+"|V:"+validate+"|T:"+tab+"|TY:"+type;

        if (type == "text") {
            val = escape(oForm.elements[i].value);
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        } else if (type == "password") {
            val = escape(oForm.elements[i].value);
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        } else if (type == "select-one") {
            val = escape(oForm.elements[i].options[oForm.elements[i].selectedIndex].value);
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        } else if (type == "radio") {
            val = escape(oForm.elements[i].value);
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        } else if (type == "checkbox") {
            val = escape(oForm.elements[i].value)
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        } else if (type == "select-multiple") {
            val = new Array();
            var j = 0;
            if (oForm.elements[i].options) {
                for (var z = 0; z < oForm.elements[i].options.length; z++) {
                    if (oForm.elements[i].options[z].selected)
                        val[j++] = escape(oForm.elements[i].options[z].value);
                }
            }
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        } else if (type == "textarea") {
            val = escape(oForm.elements[i].value);
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        } else {
            val = escape(oForm.elements[i].value)
            if (in_array(name, names) && validate == 'S' && !val) {
                setFormFocus(tab);
                break loop;
            }
        }
    }
}

function htmlCollectionToArrayName(collection) {
    var r = new Array();
    var j = 0;
    for (var i = 0; i < collection.length; i++) {
        if (collection[i]) {
            r[j] = collection[i].name;
            j++;
        }
    }
    return r;
}

/**
 * Repassa um valor e um vetor, se encontrar retorna o valor encontrado, senão retorn falso;
 */
function in_array(valor, vetor) {
    for (var i in vetor) {
        if (valor == vetor[i]) {
            return true;
        }
    }
    return false;
}
/**
 * Função que remove acentos de uma determinada string
 */
function removeAcentos(value) {
    var varString = new String(value);
    var stringAcentos = new String('àâäêèôûãõáéíóúçüÀÂÄÊÔÛÃÕÁÉÈÍÓÚÇÜ');
    var stringSemAcento = new String('aaaeeouaoaeioucuAAAEOUAOAEEIOUCU');
     
    var i = new Number();
    var j = new Number();
    var cString = new String();
    var varRes = '';
     
    for (i = 0; i < varString.length; i++) {
        cString = varString.substring(i, i + 1);
        for (j = 0; j < stringAcentos.length; j++) {
            if (stringAcentos.substring(j, j + 1) == cString) {
                cString = stringSemAcento.substring(j, j + 1);
            }
        }
        varRes += cString;
    }
    return varRes;
}

/**
 * Função que alterna entre marcar/desmarcar todos os checkboxes com o nome repassado
 */
function alternaCheckbox(valor, frm, nome) {
    for (i = 0; i < frm.elements.length; i++) {
        if (frm.elements[i].type == "checkbox") {
            if (frm.elements[i].name == (nome + "[]")) {
                if (valor) {
                    frm.elements[i].checked = true;
                }
                else {
                    frm.elements[i].checked = false;
                }
            }
        }
    }
}


/**
 * Função que serve para marcar/desmarcar todos na listagem (apenas)
 */
function toggleCheckboxStatus(valor, frm) {
    for (i = 0; i < frm.elements.length; i++) {
        if (frm.elements[i].type == "checkbox") {
            if (frm.elements[i].name == "seleciona[]") {
                if (valor) {
                    frm.elements[i].checked = true;
                }
                else {

                    frm.elements[i].checked = false;
                }
            }
        }
    }
}

function eqAlternaPorPagina(elemento, url, parametros) {
    $(window.location).attr('href', url + "&porPagina=" + $(elemento).val() + parametros);
}


/**
 * Função que abri as acoes por modulo
 */
function alternaAcao(id_modulo) {
    var id_acao = "#div_acoes";
    $.ajax({
        type: "POST",
        url: URL + 'index.php?&action=Perfil.carregaAcoes',
        data: {
            "id_modulo": id_modulo
        },
        beforeSubmit: function(formData, jqForm, options) {

        },
        success: function(serverResponse) {
            $(id_acao).html(serverResponse);
        },
        error: ajaxError,
        complete: ajaxComplete
    });

    $(id_acao).show("fast");
}



function formatar(src, mask) {
    var i = src.value.length;
    var saida = mask.substring(0, 1);
    var texto = mask.substring(i);
    var digitado = src.value.substring(i - 1, i);
    digitado = eliminarCaracteresInvalido(digitado, saida);
    if (digitado == '') {
        src.value = src.value.substring(0, i - 1);
        return;
    }
    if (texto.substring(0, 1) != saida)
    {
        src.value += texto.substring(0, 1);
    }
}

function formatarIntContinue(src) {
	// para funcionar inteiro - ex: onkeyup="formatar(this, '999')" onkeypress="formatarIntContinue(this);"
    var valor = src.value;
    src.value = valor.toString().split('').filter(function (ele) {
        return !isNaN(ele);
    }).join(''); // retorna "51"
}

function eliminarCaracteresInvalido(valor, tipo) {
    var i, ret, caracteres;
    if (tipo == "9")
        caracteres = "0123456789";
    else if (tipo == "A" || tipo == "a")
        caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
    else if (tipo == "L" || tipo == "l")
        caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    else if (tipo == "N" || tipo == "n")
        caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ";
    else if (tipo == "T" || tipo == "t")
        caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 çáàêãäéêeëiíïoóôõöuúûüÇÁÀÊÃÄÉÊEËIÍÏOÓÔÕÖUÚÛÜ(){}[]-_,.;:!@#$%¨&ºª<>?*+\/";
    ret = "";
    for (i = 0; i < valor.length; i++)
        if (tipo == 'x' || tipo == 'X')
            ret += valor.substr(i, 1);
        else
        if (caracteres.indexOf(valor.substr(i, 1), 0) != -1)
            ret += valor.substr(i, 1);
    return ret;
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // http://phpjs.org/functions/number_format/
    number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                        .toFixed(prec);
            };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
                .join('0');
    }
    return s.join(dec);
}

function selecionaOpcoesEAmbos(elemento, seleciona_todos, aPossiveisMarcados, aDivs, nTotalMarcaTodos) {
    if (!nTotalMarcaTodos)
        nTotalMarcaTodos = aPossiveisMarcados.length;

    // regras para marcacao - desmarcacao
    var check = $(elemento).is(':checked');
    var valor = $(elemento).val();
    var tot_marcados = 0;
    var aMarcados = new Array();
    $("[name='" + $(elemento).attr("name") + "']").each(function() {
        if (valor) {
            $("#" + seleciona_todos).prop("checked", false);
        } else if (!valor && check) {
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", false);
        }

        if ($(this).is(':checked')) {
            tot_marcados++;
            aMarcados.push($(this).val());
        }
    });

    if (tot_marcados >= nTotalMarcaTodos && $(elemento).attr("id") != seleciona_todos) {
        $("#" + seleciona_todos).prop("checked", true);
    }

    // regras para mostrar/esconder
    for (var i = 0; i < aPossiveisMarcados.length; i++) {
        if (in_array(aPossiveisMarcados[i], aMarcados)) {
            $("#" + aDivs[i]).show("slow");
        }
        else {
            $("#" + aDivs[i]).hide("slow");
        }
    }

}

function buscaCtrlF(campo_busca, aBuscados, aLegendasBusca, div_total) {
    var busca = $(campo_busca).val();

    // limpa o realce anterior - poem o texto sem a marcacao style_abre e style_fecha
    for (var k = 0; k < aBuscados.length; k++) {
        var html = $(aBuscados[k]);
        $(html).each(function() {
            $(this).html($(this).text());
        });
    }

    if (busca) {
        // estilo da marcacao
        var style_abre = '<b style="background-color:yellow;">';
        var style_fecha = '</b>';

        // pesquisa em cada aBuscados busca - ex: view/venda/Venda.DependentesPessoa.php
        var total = 0;
        for (var j = 0; j < aBuscados.length; j++) {
            var html = $(aBuscados[j]);
            $(html).each(function() {
                var text = $(this).text();
                var pattern = "([^\\w]*)(" + busca + ")([^\\w]*)";
                var rg = new RegExp(pattern);
                var match = rg.exec(text);
                // achou
                if (match) {
                    text = text.replace(rg, match[1] + style_abre + match[2] + style_fecha + match[3]);
                    total++;
                }
                $(this).html(text);
            });
        }
        // mostrando resultado - se tiver
        if (div_total)
            $(div_total).html(total + " " + aLegendasBusca.join(' ou '));
    } else {
        $(div_total).html("");
    }
}

function tabComoEnter(elemento, evento) {
    /*
     * como usar:
     Mousetrap.bindGlobal('enter', function(evento, tecla) {
     tabComoEnter($(evento.target),evento);
     });
     * 
     */

    if (!$(elemento).is("textarea")) {
        var tab = $(elemento).attr("tabindex");
        var novo_tab = parseInt(tab) + 1;
        setFormFocus(novo_tab);
    }
}