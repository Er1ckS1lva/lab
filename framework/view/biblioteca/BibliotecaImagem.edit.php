<? 
$o = $response->get("object");
$aFotografia = BibliotecaImagemAction::getValuesForFotografia(); 
$aGravura = BibliotecaImagemAction::getValuesForGravura();
$aDesenho = BibliotecaImagemAction::getValuesForDesenho();   
?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Imagem</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=BibliotecaImagem.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                        <input type="hidden" id="id" name="id" value='<?=($o->getId())?>'/>
                        <section>
                            <label class="label" for="tipo">Tipo</label>
                                <label class="input">
                                    <?= BibliotecaImagemAction::getComboBoxForTipo($o->getTipo(), (++$tabindex), '', disabled); ?>

                                </label>
                        </section>


                        <section>
                            <label class="label" for="titulo">Título</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="titulo" name="titulo" maxlength='150' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getTitulo())?>'/>
                                </label>
                        </section>

                        <section>
                            <label class="label" for="nome">Nome</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="nome" name="nome" maxlength='150' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getNome())?>' />
                                </label>
                        </section>
                        
                        <section>
                            <label class="label" for="estilo">Estilo</label>
                                <select id="estilo" name='estilo' class="form-control"> 
                                    <?php if(in_array($o->getEstilo(), $aFotografia)){ ?>
                                    <optgroup class="grupoEstilo" id="FOT" label="Fotografia" >
                                        <?php foreach($aFotografia as $fotografia){ ?>
                                            <option <?= $o->getEstilo() == $fotografia ? 'selected="selected"' : ''?> > <?php echo $fotografia ?> </option>
                                        <?php } ?>
                                    </optgroup>
                                    <?php } if(in_array($o->getEstilo(), $aGravura)){ ?>       
                                    <optgroup class="grupoEstilo" id="GRA" label="Gravura" >
                                        <?php foreach($aGravura as $gravura){ ?>
                                            <option <?= $o->getEstilo() == $gravura ? 'selected="selected"' : ''?> > <?php echo $gravura ?> </option>
                                        <?php } ?>
                                    </optgroup>
                                    <?php } if(in_array($o->getEstilo(), $aDesenho)){ ?>
                                    <optgroup class="grupoEstilo" id="DES" label="Desenho" >
                                        <?php foreach($aDesenho as $desenho){ ?>
                                            <option <?= $o->getEstilo() == $desenho ? 'selected="selected"' : ''?> > <?php echo $desenho ?> </option>
                                        <?php } ?>
                                    </optgroup>
                                    <?php } ?>
                                </select>
                        </section>


                        <section>
                            <label class="label" for="ano">Ano</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="ano" name="ano" maxlength='4' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getAno())?>'/>
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
                                <strong>Arquivo atual:</strong> <a href="<?php echo URL_APP ?><?= $this->module ?>/BibliotecaImagem/edit/<?php echo $o->getId() ?>?isDownload=1" target="_blank"><?php echo htmlentities($o->getArquivoName())?></a>
                            </div>
                        </section>

                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="BibliotecaImagemEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="BibliotecaImagemEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?=$this->module?>/BibliotecaImagem/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
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
            newTag: true
            }
        }
    });
});
</script>