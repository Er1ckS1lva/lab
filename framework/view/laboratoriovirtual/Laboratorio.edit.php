<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Laboratório</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Laboratorio.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                        <input type="hidden" id="id" name="id" value='<?=($o->getId())?>'/>
                        <section>
                            <label class="label" for="titulo">Título</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="titulo" name="titulo" maxlength='45' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getTitulo())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="descricao">Descrição</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="descricao" name="descricao" tabindex='<?=(++$tabindex)?>'><?=($o->getDescricao())?></textarea>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="termoUso">Termo de Uso</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="termoUso" name="termoUso" tabindex='<?=(++$tabindex)?>'><?=($o->getTermoUso())?></textarea>
                                </label>
                        </section>


                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="LaboratorioEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="LaboratorioEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a data-toggle="modal" href="#confirmationModal" onclick="eqConfirm('Você deseja sair sem salvar?', 'eqRedirectTimeout(URL_APP + MODULO_NAME + \'/Laboratorio/admFilter\')');"  tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>