<!--css do botão de apagar conteudo-->
<style type="text/css">
    .conteudo-model .panel-heading {padding: 8px;}
</style>


<!--PARTE CONTEÚDO-->
<header style="display: flex; justify-content: space-between; align-items: center">
    Conteúdo
    <button onclick="AtividadeAdicionarConteudo()" type="button" class="btn btn-primary btn-sm" title="Clique para adicionar mais conteudo"><i class="fa fa-plus"></i></button>
</header>
<fieldset style="margin-top: 10px">
    <div class="atividade-conteudo">

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
                                                <input class="form-control"  type="text" id="titulo" name="enunciadoConteudoEdit[<?php echo $oConteudo->getId(); ?>]" maxlength='1000' mask='' tabindex='<?= ( ++$tabindex) ?>' value="<?php echo $oConteudoFormulario->getEnunciado() ?? $oConteudoFormulario->getEnunciado(); ?>"/>
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
                                            <?php foreach ($aFormularioOpcao as $keyF => $oFO) { /* @var $oFO FormularioOpcao */
                                                ?>
                                                <div class='tipo-mei row' id='tipo-mei'>
                                                    <section class="col col-md-1">
                                                        <label class="label" for="opcaoConteudo">Correta</label>
                                                        <label class="radio">
                                                            <input class="check-conteudo" value="<?php echo $keyF; ?>" <?php echo $oFO->getCorreta() == 'S' ? 'checked="checked"' : ''; ?> type="radio" name="opcaoConteudoCorretaEdit[<?php echo $key ?>][]">
                                                            <i></i>
                                                        </label>
                                                    </section>

                                                    <section class="col col-md-8">
                                                        <label class="label" for="valorConteudo">Valor</label>
                                                        <label class="input">
                                                            <input class="form-control valor-conteudo" value="<?php echo $oFO->getValor(); ?>" type="text" id="titulo" name="valorConteudo[<?php echo $key ?>][]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
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
                                            <?php foreach ($aFormularioOpcao as $keyF => $oFO) {
                                                ?>
                                                <div class='tipo-mev row' id='tipo-mev'>
                                                    <section class="col col-md-1">
                                                        <label class="label" for="opcaoConteudoCorreta">Correta</label>
                                                        <label class="radio">
                                                            <input class="check-conteudo" value="<?php echo $keyF; ?>" <?php echo $oFO->getCorreta() == 'S' ? 'checked="checked"' : ''; ?> type="checkbox" name="opcaoConteudoCorreta[<?php echo $key ?>][]">
                                                            <i></i>
                                                        </label>
                                                    </section>

                                                    <section class="col col-md-8">
                                                        <label class="label" for="valorConteudo">Valor</label>
                                                        <label class="input">
                                                            <input class="form-control valor-conteudo" value="<?php echo $oFO->getValor(); ?>" type="text" id="titulo" name="valorConteudo[<?php echo $key ?>][]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
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
<!--PARTE CONTEUDO - FIM-->