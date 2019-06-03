<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Música</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=BibliotecaMusica.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                        <input type="hidden" id="id" name="id" value='<?=($o->getId())?>'/>
                        <section>
                            <label class="label" for="titulo">Título</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="titulo" name="titulo" maxlength='150' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getTitulo())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="compositor">Compositor</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="compositor" name="compositor" maxlength='150' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getCompositor())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="estilo">Estilo</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="estilo" name="estilo" maxlength='150' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getEstilo())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="interprete">Interprete</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="interprete" name="interprete" maxlength='150' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getInterprete())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="ano">Ano</label>
                                <label class="input">
                                    <input class="form-control" onkeyup="formatar(this, '9999999999')" type="text" id="ano" name="ano" maxlength='4' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getAno())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="fonte">Fonte</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="fonte" name="fonte" maxlength='100' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getFonte())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="palavraChaveMusica">Palavra chave</label>
                                <select id="select2" name="palavraChaveMusica[]" class="form-control" multiple="multiple">
                                <?php if($o->getPalavraChaveMusica()){ 
                                    foreach(explode(",", $o->getPalavraChaveMusica()) as $palavraChaveMusica) { ?>
                                        <option selected="selected"><?php echo $palavraChaveMusica ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </section>

                        <section>
                            <label class="label" for="arquivo">Trocar Arquivo <small class="text-info pull-right"><i class="fa fa-info-circle"></i> </small>
                            <div class="input input-file">
                                <span class="button">
                                    <input type="file" id="arquivo" name="arquivo" onchange="$(this).closest('div.input-file').find('input[readonly]').first().val($(this).val())"> Selecionar
                                </span>
                                <input type="text" placeholder="Selecione um arquivo" readonly="">
                            </div>
                            <div class="note">
                                <strong>Arquivo atual:</strong> <a href="<?php echo URL_APP ?><?= $this->module ?>/BibliotecaMusica/edit/<?php echo $o->getId() ?>?isDownload=1" target="_blank"><?php echo htmlentities($o->getArquivoName())?></a>
                            </div>
                        </section>

                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="BibliotecaMusicaEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="BibliotecaMusicaEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?=$this->module?>/BibliotecaMusica/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>
<script>
$(document).ready(function(){
    $("#select2").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
            return null;
            }

            return {
            id: term,
            text: term,
            newTag: true // add additional parameters
            }
        }
    });
});
</script>