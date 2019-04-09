<?
$o = $response->get("object");
?>

<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-o"></i> </span>
                <h2>Configuração</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Configuracao.formSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <legend>DADOS GERAIS</legend>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"for="sistema">Sistema</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="sistema" name="sistema" maxlength='255' mask='' validate='0' tabindex='<?= (++$tabindex) ?>' value="<?= $o ? $o->getSistema() : "" ?>"/>
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label class="label"for="empresa">Empresa</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="empresa" name="empresa" maxlength='255' mask='' validate='0' tabindex='<?= (++$tabindex) ?>' value="<?= $o ? $o->getEmpresa() : "" ?>"/>
                                    </label>
                                </section>
                            </div>

                            <section>
                                <label class="label"for="endereco">Endereço</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="endereco" name="endereco" maxlength='255' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value="<?= $o ? $o->getEndereco() : "" ?>"/>
                                </label>
                            </section>
                        </fieldset>

                        <fieldset>
                            <legend>RELACIONAMENTOS</legend>
                            <div class="row">
                                <section class="col col-4">
                                    <label class="label"for="link">Site</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="link" name="link" maxlength='255' mask='counter' validate='1' tabindex='<?= (++$tabindex) ?>' value="<?= $o ? $o->getLink() : "" ?>"/>
                                    </label>
                                </section>

                                <section class="col col-4">
                                    <label class="label"for="twitter">Twitter</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="twitter" name="twitter" maxlength='255' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value="<?= $o ? $o->getTwitter() : "" ?>"/>
                                    </label>
                                </section>

                                <section class="col col-4">
                                    <label class="label"for="facebook">Facebook</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="facebook" name="facebook" maxlength='255' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value="<?= $o ? $o->getFacebook() : "" ?>"/>
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-4">
                                    <label class="input">
                                        <a href="javascript:void(0)" onclick="ConfiguracaoAddEmail()" class="btn btn-primary btn-block btn-lg" title="Clique para adicionar e-mail">
                                            <i class="fa fa-envelope-o"></i> Adicionar E-mail
                                        </a>
                                    </label>
                                </section>
                                <div id="email-model" style="display: none;">
                                    <div class="row">
                                        <section class="col col-10">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon" title="E-mail"><i class="fa fa-envelope-o fa-lg fa-fw"></i></span>
                                                    <input class="form-control" placeholder="E-mail" type="text" name="email[]"/>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="col col-2">
                                            <div class="form-group">
                                                <button onclick="$(this).closest('div.row').remove();" type="button" class="btn-danger btn-sm" title="Clique para remover"><i class="fa fa-trash-o"></i></button>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <section class="col col-8">
                                    <div id="email-append">
                                        <? if ($o && $o->getEmail()) { ?>
                                            <?
                                            $aEmail = explode(",", $o->getEmail());
                                            foreach ($aEmail as $email) {
                                                ?>
                                                <div class="row">
                                                    <section class="col col-10">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" title="E-mail"><i class="fa fa-envelope-o fa-lg fa-fw"></i></span>
                                                                <input class="form-control" placeholder="E-mail" type="text" name="email[]" value="<?= $email ?>"/>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    <section class="col col-2">
                                                        <div class="form-group">
                                                            <button onclick="$(this).closest('div.row').remove();" type="button" class="btn-danger btn-sm" title="Clique para remover"><i class="fa fa-trash-o"></i></button>
                                                        </div>
                                                    </section>
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-4">
                                    <label class="input">
                                        <a href="javascript:void(0)" onclick="ConfiguracaoAddTelephone()" class="btn btn-primary btn-block btn-lg" title="Clique para adicionar telefone">
                                            <i class="fa fa-phone"></i> Adicionar Telefone
                                        </a>
                                    </label>
                                </section>
                                <div id="telefone-model" style="display: none;">
                                    <div class="row">
                                        <section class="col col-10">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon" title="Telefone"><i class="fa fa-phone fa-lg fa-fw"></i></span>
                                                    <input class="form-control" placeholder="Telefone" mask="phone" type="text" name="telefone[]"/>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="col col-2">
                                            <div class="form-group">
                                                <button onclick="$(this).closest('div.row').remove();" type="button" class="btn-danger btn-sm" title="Clique para remover"><i class="fa fa-trash-o"></i></button>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <section class="col col-8">
                                    <div id="telefone-append">
                                        <? if ($o && $o->getTelefone()) { ?>
                                            <?
                                            $aTelefone = explode(",", $o->getTelefone());
                                            foreach ($aTelefone as $telefone) {
                                                ?>
                                                <div class="row">
                                                    <section class="col col-10">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" title="Telefone"><i class="fa fa-phone fa-lg fa-fw"></i></span>
                                                                <input class="form-control" placeholder="Telefone" mask="phone" type="text" name="telefone[]" value="<?=$telefone?>"/>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    <section class="col col-2">
                                                        <div class="form-group">
                                                            <button onclick="$(this).closest('div.row').remove();" type="button" class="btn-danger btn-sm" title="Clique para remover"><i class="fa fa-trash-o"></i></button>
                                                        </div>
                                                    </section>
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                </section>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>CONTATO VIA SITE</legend>
                            <section>
                                <label class="label"for="tituloContato">Titulo do texto de contato</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="tituloContato" name="tituloContato" maxlength='100' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value="<?= $o ? $o->getTituloContato() : "" ?>"/>
                                </label>
                            </section>

                            <div class="row">
                                <section class="col col-4">
                                    <label class="input">
                                        <a href="javascript:void(0)" onclick="ConfiguracaoAddEmailContato()" class="btn btn-warning btn-block btn-lg" title="Clique para adicionar e-mail de contato">
                                            <i class="fa fa-envelope-o"></i> Adicionar E-mail de Contato
                                        </a>
                                    </label>
                                </section>
                                <div id="emailContato-model" style="display: none;">
                                    <div class="row">
                                        <section class="col col-10">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon" title="E-mail de Contato"><i class="fa fa-envelope-o fa-lg fa-fw"></i></span>
                                                    <input class="form-control" placeholder="E-mail de Contato" type="text" name="emailContato[]"/>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="col col-2">
                                            <div class="form-group">
                                                <button onclick="$(this).closest('div.row').remove();" type="button" class="btn-danger btn-sm" title="Clique para remover"><i class="fa fa-trash-o"></i></button>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <section class="col col-8">
                                    <div id="emailContato-append">
                                        <? if ($o && $o->getEmailContato()) { ?>
                                            <?
                                            $aEmailContato = explode(",", $o->getEmailContato());
                                            foreach ($aEmailContato as $email) {
                                                ?>
                                                <div class="row">
                                                    <section class="col col-10">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" title="E-mail"><i class="fa fa-envelope-o fa-lg fa-fw"></i></span>
                                                                <input class="form-control" placeholder="E-mail" type="text" name="emailContato[]" value="<?= $email ?>"/>
                                                            </div>
                                                        </div>
                                                    </section>
                                                    <section class="col col-2">
                                                        <div class="form-group">
                                                            <button onclick="$(this).closest('div.row').remove();" type="button" class="btn-danger btn-sm" title="Clique para remover"><i class="fa fa-trash-o"></i></button>
                                                        </div>
                                                    </section>
                                                </div>
                                            <? } ?>
                                        <? } ?>
                                    </div>
                                </section>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>RELATÓRIO</legend>
                            <section>
                                <label class="label"for="relatorioLogo">Logo do relatório</label>
                                <label class="input">
                                    <? if ($o) { ?>
                                        <img src="<?= MediaUtil::getLinkForFileNameById('Configuracao/relatorioLogo', $o->getId()); ?>"  alt="" class="img-thumbnail" width="75" height="75"> <button title="Alterar imagem" onclick="$('#relatorioLogo').slideToggle()" class="btn btn-default btn-mini tip-top"><i class="icon-pencil"></i></button>
                                    <? } ?>
                                    <input type="file" id="relatorioLogo" name="relatorioLogo" validate='1' tabindex='<?= (++$tabindex) ?>' <? if ($o && $o->getRelatorioLogo()) { ?>style="display:none;"<? } ?>/>
                                </label>
                            </section>

                            <section>
                                <label class="label"for="relatorioCabecalho">Cabeçalho do relatório</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="relatorioCabecalho" name="relatorioCabecalho" tabindex='<?= (++$tabindex) ?>'><?= ($o ? $o->getRelatorioCabecalho() : "") ?></textarea>
                                </label>
                            </section>
                        </fieldset>

                        <footer>
                            <button class="btn btn-primary" onclick="ConfiguracaoSubmitHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <!--<button class="btn btn-primary" onclick="ConfiguracaoSubmitHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>-->
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?= $this->module ?>" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>