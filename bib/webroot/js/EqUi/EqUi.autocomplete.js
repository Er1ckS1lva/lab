/*
 * Eq UI Autocomplete 1.0
 *
 * Copyright (c) 2010 Equilibrium Web
 *
 * Depends:
 *	jquery.ui.autocomplete.js
 */

(function ($) {

    $.widget("EqUi.eq_autocomplete", {
        options: {
            realInput: '__defaultEqAutoCompleteRealInput__',
            realInputName: null,
            url: '',
            requestTermKey: 'descValue',
            buttonId: 'realInputSuggestButton',
            hasComboBox: false,
            hasPageLoad: true,
            idValue: null,
            onSelect: null,
            beforeSubmit: null,
            only: false,
            pageSuggest: 0,
            filter: false
        },

        _create: function () {
            var self = this;
            var input = $('<input>');
            input.attr('id', this.options.realInput)
                    .attr('name', this.options.realInputName)
                    .css('display', 'none')
                    .insertAfter(this.element);

            if (this.options.idValue) {
                input.val(this.options.idValue);
            }

            var url = this.options.url;
            var data_dados = "";
            var requestTermKey = this.options.requestTermKey;

            var loadAddOnValue = "<i class='caret'></i>";
            var loadingAddOnValue = "<i class='fa fa-refresh fa-spin'></i>";

            this.element.autocomplete({
                source: function (request, response) {
                    if (self.options.beforeSubmit != undefined) {
                        eval("url = " + self.options.beforeSubmit);
                    }

                    var AddOn = $(input).parent().parent().find(".input-group-btn").find("button");
                    data_dados = requestTermKey + '=' + request.term;

                    // zera a paginacao
                    input.siblings(".ui-autocomplete-input").attr("pageSuggest", 0);
                    self.options.pageSuggest = 0;

                    $.ajax({
                        url: url + '&ajaxRequest=1&all=' + self.options.all,
                        dataType: "json",
                        data: data_dados,
                        beforeSend: function () {
//                            $(AddOn).html(loadingAddOnValue);
                        },
                        complete: function () {
//                            $(AddOn).html(loadAddOnValue);
                        },
                        error: function (serverResponse) {
                            if (!self.options.filter) { // nao pode dar o alert pq pode quebrar a requisição com outra
                                alert("Error: " + serverResponse.responseText + " (" + input.attr("id") + ")");
                            }
                            console.log(serverResponse);
                        },
                        success: function (serverResponse) {
                            var responseArr = [];
                            for (prop in serverResponse) {
                                responseArr.push({
                                    label: serverResponse[prop].descHtml ? serverResponse[prop].descHtml : serverResponse[prop].desc,
                                    value: serverResponse[prop].desc,
                                    id: serverResponse[prop].id
                                });
                            }
                            response(responseArr);

                            // only - preenche se tiver so um
                            if (self.options.only) {
                                if (responseArr.length == 1 && request.term) {
                                    var last = responseArr[0];
                                    if (last.id) { // se tiver
                                        var onlyId = last.id;
                                        var onlyDesc = last.desc;
                                        if (self.options.onSelect) {
                                            input.val(onlyId);
                                            self.options.onSelect(onlyId, onlyDesc);

                                            // reiniciar a variavel do termo de busca
                                            setTimeout(function () {
                                                $(this).val("");
                                                input.val('');
                                                self.element.blur();
                                                self.element.focus();

                                                self.element.autocomplete("search", "");
                                                self.element.autocomplete("close");

                                            }, 0);
                                        }
                                    }
                                }
                            }
                            // end only

                        }
                    });
                },

                change: function (event, ui) {
                    if (!ui.item && !self.options.minLength && !self.options.filter) { // nao limpa se for filter
                        // remove invalid value, as it didn't match anything - ou senao tiver minLength
                        $(this).val("");
                        input.val('');
                        return false;
                    } else if (self.options.filter && ui.item === null) { // limpa somente o input caso deixe texto            
                        input.val('');
                        return false;
                    }
                },

                select: function (event, ui) {
                    input.val(ui.item.id);
                    if (self.options.onSelect) {
                        self.options.onSelect(ui.item.id, ui.item.value);
                    }
                },

                minLength: self.options.minLength,
                delay: self.options.delay
            }).data("ui-autocomplete")._renderItem = function (ul, item) {
                return $("<li>")
                        .append("<a>" + item.label + "</a>")
                        .appendTo(ul);
            };


            //*
            //isso para forçar um tamanho no menu
            if (this.options.hasPageLoad == true) {
                setTimeout(function () {
                    $('.ui-autocomplete').css({
                        'max-height': '100px',
                        'overflow-y': 'auto',
                        'overflow-x': 'hidden'
                    });
                }, 100);
                //isso aqui para detectar o scroll e o hit no final dele
                function isScrollbarBottom(container) {
                    var height = container.outerHeight();
                    var scrollHeight = container[0].scrollHeight;
                    var scrollTop = container.scrollTop();
                    if (scrollTop >= scrollHeight - height) {
                        return true;
                    }
                    return false;
                }
                //https://stackoverflow.com/questions/43190802/jquery-ui-autocomplete-w-infinite-scroll
                //http://jsfiddle.net/Lp6zP/
                this.element.data('ui-autocomplete')._renderMenu = function (ul, items) {
                    var self_ui = this;
                    //isso para inserir os itens
                    $.each(items, function (index, item) {
                        self_ui._renderItemData(ul, item);
                    });
                    $(ul).animate({scrollTop: 0}, 1);

                    $(ul).unbind("scroll");
                    var AddOn2 = $(input).parent().parent().find(".input-group-btn").find("button");

                    var scroll = function () {
                        if (isScrollbarBottom($(ul))) {

                            $(ul).unbind("scroll"); //enquanto faz o ajax desliga o scroll?                        
                            $.ajax({
                                url: url + "&ajaxRequest=1&pageSuggest=" + (++self.options.pageSuggest),
                                data: data_dados,
                                dataType: "json",
                                beforeSend: function () {
                                    $(AddOn2).html(loadingAddOnValue);
                                },
                                complete: function (response) {
                                    $(AddOn2).html(loadAddOnValue);

                                    if (countJsonAjax(response) == 0) {
                                        $(ul).parent().attr("title", "Todos os itens já carregados.");
                                    }

                                    $(ul).scroll(scroll);
                                    input.siblings(".ui-autocomplete-input").attr("pageSuggest", self.options.pageSuggest);
                                },
                                success: function (response) {
                                    for (prop in response) {
                                        var li = self_ui._renderItemData(ul, {
                                            label: response[prop].desc,
                                            value: response[prop].desc,
                                            id: response[prop].id
                                        });
                                        li.addClass("ui-menu-item");
                                    }
                                },
                                error: function (response) {
                                    alert("Erro: " + response);
                                    console.log(response);
                                }
                            });


                        }
                    };
                    $(ul).scroll(scroll);
                };
            }
            //*/


            $('.ui-helper-hidden-accessible').remove();
            if (this.options.hasComboBox) {
                var button = $("<button style='padding: 5px 13px 7px' type='button' class='btn btn-default'><i class='caret'></i></button>")
                        .attr("id", this.options.buttonId + this.options.realInput)
                        .attr("tabIndex", self.options.tabindex)
                        .attr("title", "Mostrar todos os itens")
                        .click(function () {
                            // close if already visible
                            if (self.element.autocomplete("widget").is(":visible")) {
                                self.element.autocomplete("close");
                                return false;
                            }

                            if (self.options.minLength > 0) {
                                // quando tiver minLength busca por aquela quantidade de item
                                var valor = $("#" + $(input).attr("id") + "Suggest");
                                if (valor.val().length >= self.options.minLength) {
                                    self.element.autocomplete("search", valor.val());
                                } else {
                                    alert("Digite " + self.options.minLength + " caracteres para pesquisar.");
                                }
                            } else {
                                // pass empty string as value to search for, displaying all results
                                self.element.autocomplete("search", "");
                            }

                            self.element.focus();
                            return false;
                        });

                $("<span class='input-group-btn'></span>")
                        .append(button)
                        .insertAfter(input);
            }

        },

        //TODO finish, this is not right! --salaniojr
        destroy: function () {
            this.element.autocomplete().destroy();
            this.element.attr('id', this.options.realInput);
            this.element.attr('name', this.options.realInput);
            $(this.options.realInput).remove();
            $(this.options.realInputSuggestButton).remove();
            $.Widget.prototype.destroy.call(this);
        }

    });

}(jQuery));