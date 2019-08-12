
<!--MODELOS DE TIPO DE FORMULÁRIO DE CONTEUDO-->
<div style="display: none">
    <div class='tipo-mei row' id='tipo-mei'>
        <section class="col col-md-1">
            <label class="label" for="opcaoConteudo">Correta</label>
            <label class="radio">
                <input class="check-conteudo" type="radio" name="opcaoConteudoCorreta[]">
                <i></i>
            </label>
        </section>

        <section class="col col-md-8">
            <label class="label" for="valorConteudo">Valor</label>
            <label class="input">
                <input class="form-control valor-conteudo" type="text" id="titulo" name="valorConteudo[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
            </label>
        </section>

        <section class="col col-md-2">
            <label class="label">&nbsp;</label>
            <div class="input input-file">
                <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
            </div>
        </section>
    </div>
    <div class='tipo-mev row' id='tipo-mev'>
        <section class="col col-md-1">
            <label class="label" for="opcaoConteudoCorreta">Correta</label>
            <label class="radio">
                <input class="check-conteudo" type="checkbox" name="opcaoConteudoCorreta[]">
                <i></i>
            </label>
        </section>

        <section class="col col-md-8">
            <label class="label" for="valorConteudo">Valor</label>
            <label class="input">
                <input class="form-control valor-conteudo" type="text" id="titulo" name="valorConteudo[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
            </label>
        </section>

        <section class="col col-md-2">
            <label class="label">&nbsp;</label>
            <div class="input input-file">
                <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
            </div>
        </section>
    </div>

    <div class='tipo-txt' id='tipo-txt'>
    </div>
</div>


<!--MODELO DO CONTEUDO-->
        <div id="Atividade-conteudo-model" style="display: none;">
            <div class="panel panel-default conteudo-model">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#Atividade-conteudo-append" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Arquivo Multimídia (<span class="nome text-success">Novo</span>)
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body padding-10">
                        <div>
                            <button class="btn btn-danger btn-sm bt-person pull-right" onclick="$(this).closest('.conteudo-model').remove(); countConteudo--; AtividadeRecontarConteudo();"><i class="fa fa-trash-o"></i></button>

                            <div class="row">
                                <section class="col col-md-6">
                                    <label class="label" for="tituloConteudo">Título</label>
                                    <label class="input">
                                        <input class="form-control titulo"  type="text" name="tituloConteudo[]" maxlength='255' mask='' tabindex='<?= ( ++$tabindex) ?>' onkeyup="AtividadeOnChangeTituloConteudo(this)"/>
                                    </label>
                                </section>

                                <section class="col col-md-4">
                                    <label class="label">
                                        Arquivo
                                    </label>
                                    <div class="input input-file">
                                        <span class="button">
                                            <input type="file" id="file" name="arquivoConteudo[]"  onchange="$(this).closest('span.button').next('input').val(this.value);" tabindex='<?= ( ++$tabindex) ?>' />
                                            Selecionar
                                        </span>
                                        <input type="text" placeholder="Selecione o arquivo" readonly="">
                                    </div>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-md-6">
                                    <label class="label" for="enunciado">Enunciado</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="titulo" name="enunciadoConteudo[]" maxlength='1000' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                    </label>
                                </section>

                                <section class="col col-md-4">
                                    <label class="label">
                                        Tipo
                                    </label>
                                    <div class="input">
                                        <?= ConteudoFormularioAction::getComboBoxForTipo(null, ( ++$tabindex), false, "onchange=\"AtividadeSelecionaTipoFormulario(this.value, $(this).closest('div.conteudo-model'), 1)\"", 'tipoConteudo[]'); ?>
                                    </div>
                                </section>

                                <section class="col col-md-2" style="display: none" id='mais-opcao'>
                                    <label class="label">&nbsp;</label>
                                    <div class="input input-file">
                                        <button onclick="AtividadeSelecionaTipoFormulario($(this).closest('div.conteudo-model').find('option:selected').val(), $(this).closest('div.conteudo-model'), 0)" type="button" class="btn btn-primary btn-sm" ><i class="fa fa-plus"> opção</i></button>
                                    </div>
                                </section>
                            </div>

                            <div class="opcao-conteudo">

                            </div>
                            <hr style="border-style: solid">
                        </div>
                    </div>
                </div>
            </div>
        </div>