<!--css do botão de apagar conteudo-->
<style type="text/css">
    .conteudo-model .panel-heading {padding: 8px;}
</style>

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

<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-o"></i> </span>
                <h2>Atividade</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">

                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Atividade.formSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <section>
                                <label class="label" for="Tema">Tema</label>
                                <label class="input">
                                    <suggest id='Tema' entity='Tema' hasComboBox='true' tabindex='<?= ( ++$tabindex) ?>' />
                                </label>
                            </section>


                            <section>
                                <label class="label" for="titulo">Título</label>
                                <label class="input">
                                    <input class="form-control" type="text" id="titulo" name="titulo" maxlength='150' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>

                            <section>
                                <label class="label" for="ordem">Ordem (quanto menor mais relevante)</label>
                                <label class="input">
                                    <input class="form-control" onkeyup="formatar(this, '9999999999')" onkeypress="formatarIntContinue(this);" type="text" id="ordem" name="ordem" maxlength='11' mask='inteiro' tabindex='<?= ( ++$tabindex) ?>' value=''/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="descricao">Descrição</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="descricao" name="descricao" tabindex='<?= ( ++$tabindex) ?>'></textarea>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="tipo">Tipo</label>
                                <label class="input">
                                    <?= AtividadeAction::getComboBoxForTipo(null, ( ++$tabindex), false, "onchange=AtividadeSelecionaTipo(this)"); ?>

                                </label>
                            </section>

                        </fieldset>
                        <div id="div-opcao" style="display: none">
                            <header style="display: flex; justify-content: space-between; align-items: center">
                                Opções
                                <button onclick="AtividadeAdicionarOpcao()" type="button" class="btn btn-primary btn-sm pull-right" title="Clique para adicionar mais opção"><i class="fa fa-plus"></i></button>
                            </header>
                            <fieldset>
                                <div id ="atividade-opcao" class="atividade-opcao">
                                    <div id="Atividade-opcao-model" style="display: none;">
                                        <div class="row">
                                            <section class="col col-md-1">
                                                <label class="label" for="corretaOpcao">Correta</label>
                                                <label class="radio">
                                                    <input class="check" type="radio" name="corretaOpcao">
                                                    <i></i>
                                                </label>
                                            </section>

                                            <section class="col col-md-5">
                                                <label class="label" for="valorOpcao">Valor</label>
                                                <label class="input">
                                                    <input class="form-control" type="text" id="titulo" name="valorOpcao[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                </label>
                                            </section>

                                            <section class="col col-md-4">
                                                <label class="label" for="valorFoneticoOpcao">Valor Fonético</label>
                                                <label class="input">
                                                    <input class="form-control" type="text" id="titulo" name="valorFoneticoOpcao[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                </label>
                                            </section>

                                            <section class="col col-md-2">
                                                <label class="label">&nbsp;</label>
                                                <div class="input input-file">
                                                    <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div id="Atividade-opcao-append">

                                    </div>
                                </div>
                            </fieldset>
                        </div>


                        <div class="padding-10" >
                            <?php
                            $oIdiomaAction = new IdiomaAction();
                            $aIdioma = $oIdiomaAction->collection(null, null, 'padrao ASC');
                            if ($aIdioma) {
                                ?>
                                <ul id="myTab1" class="nav nav-tabs bordered">
                                    <?php
                                    foreach ($aIdioma as $k => $oIdioma) {
                                        $active = ($k == 0) ? 'active' : '';
                                        $id_idioma = $oIdioma->getId();
                                        ?>
                                        <li class="<?php echo $active ?>">
                                            <a style="color: #000!important" href="#aba-idioma-<?php echo $oIdioma->getId() ?>" data-toggle="tab">
                                                <?php echo $oIdioma->getSigla() ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <div id="myTabContent1" class="tab-content padding-10">
                                    <?php
                                    $titulo = $descricao = "";
                                    foreach ($aIdioma as $k => $oIdioma) {
                                        $active = ($k == 0) ? 'active' : '';
                                        $id_idioma = $oIdioma->getId();
                                        ?>
                                        <div class="tab-pane fade in <?php echo $active ?>" id="aba-idioma-<?php echo $oIdioma->getId() ?>">


                                            <? // if ($oIdioma->getPadrao() == "1") { ?>
                                            <? if (true) { ?>
                                                <?
                                                ### obrigatorio ter pelo menos o padrão
                                                $aValidateNovo = array();
                                                $aValidateNovo[] = "titulo_" . $oIdioma->getId() . "";
                                                $aValidateNovo[] = "descricao_" . $oIdioma->getId() . "";
                                                ?>
                                                <script>
                                                    $(document).ready(function () {
                                                        validateScriptTopo('<?= join(",", $aValidateNovo) ?>');
                                                    });
                                                </script>
                                            <? } ?>


                                            <input type="hidden" value="<?php echo $id_idioma ?>" name="aIdioma[]" />
                                            <fieldset>
                                                <section>
                                                    <label class="label" for="titulo">Título</label>
                                                    <label class="input">
                                                        <input class="form-control" value="" type="text" id="titulo_<?php echo $oIdioma->getId() ?>" name="aTitulo[<?php echo $id_idioma ?>]" maxlength='255' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                    </label>
                                                </section>

                                                <section class="conteudo-noticia conteudo-interna">
                                                    <label class="label" for="descricao">Descrição</label>
                                                    <label class="input">
                                                        <textarea class="ckeditor" id="descricao_<?php echo $oIdioma->getId() ?>" name="aDescricao[<?php echo $id_idioma ?>]" tabindex='<?= ( ++$tabindex) ?>'></textarea>
                                                    </label>
                                                </section>

                                            </fieldset>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                        <!--PARTE CONTEÚDO-->
                        <header style="display: flex; justify-content: space-between; align-items: center">
                            Conteúdo
                            <button onclick="AtividadeAdicionarConteudo()" type="button" class="btn btn-primary btn-sm" title="Clique para adicionar mais conteudo"><i class="fa fa-plus"></i></button>
                        </header>
                        <fieldset style="padding-top: 10px">
                            <div class="atividade-conteudo">

                                <!--MODELO DO CONTEUDO-->
                                <div id="Atividade-conteudo-model"  style="display: none;">
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
                                                                <input class="form-control"  type="text" id="titulo" name="enunciadoConteudo[]" maxlength='500' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
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

                                <!--CONTEUDOS ADVINDOS DO MODELO-->
                                <div id="Atividade-conteudo-append">

                                </div>
                            </div>

                        </fieldset>
                        <!--PARTE CONTEUDO - FIM-->

                        <footer>
                            <button class="btn btn-primary" onclick="AtividadeSubmitHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="AtividadeSubmitHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a data-toggle="modal" href="#confirmationModal" onclick="eqConfirm('Você deseja sair sem salvar?', 'eqRedirectTimeout(URL_APP + MODULO_NAME + \'/Atividade/admFilter\')');" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>