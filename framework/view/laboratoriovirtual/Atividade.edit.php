<?
$aIdioma = $response->get("aIdioma");
$kIdioma = $response->get("kIdioma");

$o = $response->get("object");
?>

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
                            <div class="row">
                                <section class="col col-3">
                                    <label class="label" for="Tema">Tema</label>
                                    <label class="input">
                                        <suggest id='Tema' entity='Tema' hasComboBox='true' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getTema()->getId()) ?>' />
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="label" for="titulo">Título</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="titulo" name="titulo" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getTitulo()) ?>'/>
                                    </label>
                                </section>
                                <section class="col col-3">
                                    <label class="label" for="ordem">Ordem (quanto menor mais relevante)</label>
                                    <label class="input">
                                        <input class="form-control" onkeyup="formatar(this, '9999999999')" onkeypress="formatarIntContinue(this);" type="text" id="ordem" name="ordem" maxlength='11' mask='inteiro' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getOrdem()) ?>'/>
                                    </label>
                                </section>
                            </div>

                            <section>
                                <label class="label" for="descricao">Descrição</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="descricao" name="descricao" tabindex='<?= ( ++$tabindex) ?>'><?= ($o->getDescricao()) ?></textarea>
                                </label>
                            </section>

                            <div class="padding-10" >
                                <?php if ($aIdioma) { ?>
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

                        </fieldset>

                        <fieldset>
                            <section>
                                <label class="label" for="tipo">Tipo</label>
                                <label class="input">
                                    <b><?= AtividadeAction::getValueForTipo($o->getTipo()) ?></b>
                                    <input type="hidden" name="tipo" value="<?php echo $o->getTipo() ?>"/>
                                </label>
                            </section>

                            <?php include("inc/Atividade.PRC.php"); ?>
                            <?php include("inc/Atividade.REL.php"); ?>                        
                        </fieldset>

                        <?php include("inc/Atividade.conteudo.php"); ?>

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