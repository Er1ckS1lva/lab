<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Menu do Modulo</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=ModuloMenu.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                        <input type="hidden" id="id" name="id" value='<?=($o->getId())?>'/>

                        <section>
                            <label class="label" for="nome">Nome</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="nome" name="nome" maxlength='255' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getNome())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="descricao">Descrição</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="descricao" name="descricao" maxlength='255' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getDescricao())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="class">Class</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="class" name="class" maxlength='100' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getClass())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="icon">Icon</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="icon" name="icon" maxlength='100' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getIcon())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="ordem">Ordem</label>
                                <label class="input">
                                    <input class="form-control" onkeyup="formatar(this, '9999999999')" type="text" id="ordem" name="ordem" maxlength='11' mask='inteiro' tabindex='<?=(++$tabindex)?>' value='<?=($o->getOrdem())?>'/>
                                </label>
                        </section>


                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="ModuloMenuEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="ModuloMenuEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?=$this->module?>/ModuloMenu/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>

