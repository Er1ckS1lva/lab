<? $o = $response->get("object"); ?>
<style>
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
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Atividade</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Atividade.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <input type="hidden" id="id" name="id" value='<?= ($o->getId()) ?>'/>
                            <section>
                                <label class="label" for="Tema">Tema</label>
                                <label class="input">
                                    <suggest id='Tema' entity='Tema' hasComboBox='true' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getTema()->getId()) ?>' />
                                </label>
                            </section>

                            <section>
                                <label class="label" for="titulo">Título</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="titulo" name="titulo" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getTitulo()) ?>'/>
                                </label>
                            </section>

                            <section>
                                <label class="label" for="ordem">Ordem (quanto menor mais relevante)</label>
                                <label class="input">
                                    <input class="form-control" onkeyup="formatar(this, '9999999999')" onkeypress="formatarIntContinue(this);" type="text" id="ordem" name="ordem" maxlength='11' mask='inteiro' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getOrdem()) ?>'/>
                                </label>
                            </section>

                            <section>
                                <label class="label" for="descricao">Descrição</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="descricao" name="descricao" tabindex='<?= ( ++$tabindex) ?>'><?= ($o->getDescricao()) ?></textarea>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="tipo">Tipo</label>
                                <label class="input">
                                    <?= AtividadeAction::getComboBoxForTipo($o->getTipo(), ( ++$tabindex), false, "onchange=AtividadeSelecionaTipo(this)"); ?>
                                </label>
                            </section>

                        </fieldset>
                        <div id="div-opcao" style="<?php echo $o->getTipo() != 'PRC' ? 'display: none' : '' ?>">
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

                                        <?php
                                        $aOpcao = $response->get('aOpcao');
                                        if ($aOpcao) {
                                            foreach ($aOpcao as $key => $oOpcao) {
                                                ?>
                                                <div class="row">
                                                    <section class="col col-md-1">
                                                        <label class="label" for="corretaOpcao">Correta</label>
                                                        <label class="radio">
                                                            <input type="radio" name="corretaOpcao" <?php echo $oOpcao->getCorreta() == 'S' ? 'checked' : '' ?> value="<?php echo $oOpcao->getId() ?>">
                                                            <i></i>
                                                        </label>
                                                    </section>

                                                    <section class="col col-md-5">
                                                        <label class="label" for="valorOpcao">Valor</label>
                                                        <label class="input">
                                                            <input class="form-control" type="text" value="<?php echo $oOpcao->getValor(); ?>" id="valor" name="valorOpcaoEdit[<?php echo $oOpcao->getId(); ?>]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                        </label>
                                                    </section>

                                                    <section class="col col-md-4">
                                                        <label class="label" for="valorFoneticoOpcao">Valor Fonético</label>
                                                        <label class="input">
                                                            <input class="form-control valorOpcao" type="text" value="<?php echo $oOpcao->getValorFonetico(); ?>" id="valorFonetico" name="valorFoneticoOpcaoEdit[<?php echo $oOpcao->getId(); ?>]" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                        </label>
                                                    </section>

                                                    <section class="col col-md-2">
                                                        <label class="label">&nbsp;</label>
                                                        <div class="input input-file">
                                                            <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </section>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
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
                                        $id_idioma = $oIdioma->getId();
                                        $oAtividadeIdiomaAction = new AtividadeIdiomaAction();
                                        $oAtividadeIdioma = $oAtividadeIdiomaAction->select($o->getId(), $id_idioma);
                                        if ($oAtividadeIdioma) {
                                            $id_idioma = "{$id_idioma}#{$o->getId()}";
                                            $titulo = $oAtividadeIdioma->getTitulo();
                                            $descricao = $oAtividadeIdioma->getDescricao();
                                        }
                                        $active = ($k == 0) ? 'active' : '';
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
                                                        <input class="form-control" value="<?php echo $titulo ?>" type="text" id="titulo_<?php echo $oIdioma->getId() ?>" name="aTitulo[<?php echo $id_idioma ?>]" maxlength='255' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                    </label>
                                                </section>

                                                <section class="conteudo-noticia conteudo-interna">
                                                    <label class="label" for="descricao">Descrição</label>
                                                    <label class="input">
                                                        <textarea class="ckeditor" id="descricao_<?php echo $oIdioma->getId() ?>" name="aDescricao[<?php echo $id_idioma ?>]" tabindex='<?= ( ++$tabindex) ?>'><?php echo $descricao ?></textarea>
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

                        <header style="display: flex; justify-content: space-between; align-items: center">
                            Conteúdo
                            <button onclick="AtividadeAdicionarConteudo()" type="button" class="btn btn-primary btn-sm" title="Clique para adicionar mais conteudo"><i class="fa fa-plus"></i></button>
                        </header>
                        <fieldset style="margin-top: 10px">
                            <div class="atividade-conteudo">

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
                                <div id="Atividade-conteudo-append" class="panel-group" role="tablist" aria-multiselectable="true">
                                    <?php
                                    $aConteudo = $response->get('aConteudo');
                                    $aConteudoArquivo = $response->get('aConteudoArquivo');
                                    if ($aConteudo) {
                                        $aConteudoFormulario = $response->get('aConteudoFormulario');
                                        foreach ($aConteudo as $key => $oConteudo) {
                                            $oConteudoArquivo = $aConteudoArquivo[$oConteudo->getId()];
                                            $oConteudoFormulario = $aConteudoFormulario[$oConteudo->getId()]; /* @var $oConteudoFormulario ConteudoFormulario */
                                            ?>

                                            <input type="hidden" value="<?php echo $oConteudoFormulario->getId() ?>" name="aIdFormulario[]" />

                                            <div class="panel panel-default conteudo-model">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#Atividade-conteudo-append" href="#collapse-<?php echo $key ?>" aria-expanded="true" aria-controls="collapse-<?php echo $key ?>">
                                                            Arquivo Multimídia (<span id="span-<?php echo $key ?>" class="text-success"><?php echo $oConteudo->getTitulo(); ?></span>)
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse-<?php echo $key ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body padding-10">
                                                        <input type="hidden" value="">
                                                        <div>
                                                            <button class="btn btn-danger btn-sm bt-person pull-right" onclick="$(this).closest('.conteudo-model').remove(); countConteudo--; AtividadeRecontarConteudo();"><i class="fa fa-trash-o"></i></button>
                                                            <div class="row">
                                                                <section class="col col-md-6">
                                                                    <label class="label" for="tituloConteudo">Título</label>
                                                                    <label class="input">
                                                                        <input  onkeyup="AtividadeOnChangeTituloConteudo(this)" data-id="#span-<?php echo $key ?>" class="form-control" type="text" id="titulo" name="tituloConteudoEdit[<?php echo $oConteudo->getId(); ?>]" maxlength='255' mask='' tabindex='<?= ( ++$tabindex) ?>' value="<?php echo $oConteudo->getTitulo(); ?>"/>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-md-4">
                                                                    <label class="label">Arquivo<small class="text-info pull-right"><i class="fa fa-info-circle"></i> Tamanho máximo: <?php echo '<b>definir</b>' ?> MB</small></label>
                                                                    <div class="input input-file">
                                                                        <span class="button">
                                                                            <input type="file" id="file" name="arquivoConteudoEdit[<?php echo $oConteudo->getId(); ?>]"  onchange="$(this).closest('span.button').next('input').val(this.value);" tabindex='<?= ( ++$tabindex) ?>' />
                                                                            Selecionar
                                                                        </span>
                                                                        <input type="text" placeholder="Selecione o arquivo" readonly="">
                                                                    </div>
                                                                    <div class="note">
                                                                        <strong>Arquivo atual:</strong> <a href="<?php echo URL_APP ?><?= $this->module ?>/Atividade/conteudoDownload/<?php echo $oConteudo->getId() ?>" target="_blank"><?php echo htmlentities($oConteudoArquivo->getNome()) ?></a>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div class="row">
                                                                <section class="col col-md-6">
                                                                    <label class="label" for="enunciado">Enunciado</label>
                                                                    <label class="input">
                                                                        <input class="form-control"  type="text" id="titulo" name="enunciadoConteudoEdit[<?php echo $oConteudo->getId(); ?>]" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>' value="<?php echo $oConteudoFormulario->getEnunciado() ?? $oConteudoFormulario->getEnunciado(); ?>"/>
                                                                    </label>
                                                                </section>

                                                                <section class="col col-md-4">
                                                                    <label class="label">
                                                                        Tipo
                                                                    </label>
                                                                    <div class="input">
                                                                        <?= ConteudoFormularioAction::getComboBoxForTipo($oConteudoFormulario ? $oConteudoFormulario->getTipo() : null, ( ++$tabindex), false, "onchange=\"AtividadeSelecionaTipoFormulario(this.value, $(this).closest('div.conteudo-model'), 1)\"", 'tipoConteudoEdit[' . $oConteudo->getId() . ']'); ?>
                                                                    </div>
                                                                </section>

                                                                <section class="col col-md-2"  <?php echo ($oConteudoFormulario->getTipo() == "MEI" || $oConteudoFormulario->getTipo() == "MEV") ?? 'style="display: none"'; ?> id='mais-opcao'>
                                                                    <label class="label">&nbsp;</label>
                                                                    <div class="input input-file">
                                                                        <button onclick="AtividadeSelecionaTipoFormulario($(this).closest('div.conteudo-model').find('option:selected').val(), $(this).closest('div.conteudo-model'), 0)" type="button" class="btn btn-primary btn-sm" ><i class="fa fa-plus"> opção</i></button>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div class="opcao-conteudo">
                                                                <?php
                                                                $oFormularioOpcaoAction = new FormularioOpcaoAction();
                                                                $aFormularioOpcao = $oFormularioOpcaoAction->collection(null, "o.ConteudoFormulario = {$oConteudoFormulario->getId()}");
                                                                if ($oConteudoFormulario->getTipo() == "MEI") {
                                                                    ?>
                                                                    <?php foreach ($aFormularioOpcao as $key => $oFO) { /* @var $oFO FormularioOpcao */
                                                                        ?>
                                                                        <div class='tipo-mei row' id='tipo-mei'>
                                                                            <section class="col col-md-1">
                                                                                <label class="label" for="opcaoConteudo">Correta</label>
                                                                                <label class="radio">
                                                                                    <input class="check-conteudo"  <?php echo $oFO->getCorreta() == 'S' ? 'checked="checked"' : ''; ?> type="radio" name="opcaoConteudoCorreta[]">
                                                                                    <i></i>
                                                                                </label>
                                                                            </section>

                                                                            <section class="col col-md-8">
                                                                                <label class="label" for="valorConteudo">Valor</label>
                                                                                <label class="input">
                                                                                    <input class="form-control valor-conteudo" value="<?php echo $oFO->getValor(); ?>" type="text" id="titulo" name="valorConteudo[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                                                </label>
                                                                            </section>

                                                                            <section class="col col-md-2">
                                                                                <label class="label">&nbsp;</label>
                                                                                <div class="input input-file">
                                                                                    <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                } else if ($aConteudoFormulario[$oConteudo->getId()]->getTipo() == "MEV") {
                                                                    ?>
                                                                    <?php foreach ($aFormularioOpcao as $key => $oFO) {
                                                                        ?>
                                                                        <div class='tipo-mev row' id='tipo-mev'>
                                                                            <section class="col col-md-1">
                                                                                <label class="label" for="opcaoConteudoCorreta">Correta</label>
                                                                                <label class="radio">
                                                                                    <input class="check-conteudo" <?php echo $oFO->getCorreta() == 'S' ? 'checked="checked"' : ''; ?> type="checkbox" name="opcaoConteudoCorreta[]">
                                                                                    <i></i>
                                                                                </label>
                                                                            </section>

                                                                            <section class="col col-md-8">
                                                                                <label class="label" for="valorConteudo">Valor</label>
                                                                                <label class="input">
                                                                                    <input class="form-control valor-conteudo" value="<?php echo $oFO->getValor(); ?>" type="text" id="titulo" name="valorConteudo[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                                                </label>
                                                                            </section>

                                                                            <section class="col col-md-2">
                                                                                <label class="label">&nbsp;</label>
                                                                                <div class="input input-file">
                                                                                    <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
                                                                                </div>
                                                                            </section>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            <hr style="border-style: solid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="AtividadeEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="AtividadeEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a data-toggle="modal" href="#confirmationModal" onclick="eqConfirm('Você deseja sair sem salvar?', 'eqRedirectTimeout(URL_APP + MODULO_NAME + \'/Atividade/admFilter\')');"  tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>