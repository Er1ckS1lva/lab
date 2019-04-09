<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Perfil</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Perfil.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <input type="hidden" id="id" name="id" value='<?= ($o->getId()) ?>'/>
                            <div class="row">
                                 <section class="col col-10">
                                    <label class="label"for="nome">Nome</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="nome" name="nome" maxlength='45' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value='<?= ($o->getNome()) ?>'/>
                                    </label>
                                </section>
                                 
                                <section class="col col-2">
                                    <label class="label"for="ativo">Ativo</label>
                                    <label class="input">
                                        <?= PerfilAction::getComboBoxForAtivo($o->getAtivo()); ?>

                                    </label>
                                </section>
                            </div>
                        </fieldset>

                        <? include $this->dir . "/seguranca/pessoal/Perfil.permissao.php"; ?>

                        <? include $this->dir . "/seguranca/pessoal/Perfil.module_view.php"; ?>

                        <footer>
                            <button class="btn btn-primary" onclick="PerfilEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="PerfilEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?= $this->module ?>/Perfil/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>

