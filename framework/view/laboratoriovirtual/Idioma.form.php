<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-o"></i> </span>
                <h2>Idioma</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Idioma.formSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <div class="row">
                                <section class="col col-md-5">                            
                                    <label class="label" for="titulo">Título</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="titulo" name="titulo" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                    </label>
                                </section>


                                <section class="col col-md-4">
                                    <label class="label" for="sigla">Sigla</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="sigla" name="sigla" maxlength='10' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                    </label>
                                </section>


                                <section class="col col-md-3">
                                    <label class="label" for="padrao">Idioma Padrão</label>
                                    <label class="input">
                                        <?= IdiomaAction::getComboBoxForPadrao(null, ( ++$tabindex)); ?>

                                    </label>
                                </section>
                            </div>

                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="IdiomaSubmitHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="IdiomaSubmitHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?= $this->module ?>/Idioma/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>