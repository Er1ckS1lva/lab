<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Configuração</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Configuracao.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                        <input type="hidden" id="id" name="id" value='<?=($o->getId())?>'/>
                        <section>
                            <label class="label" for="sistema">Sistema</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="sistema" name="sistema" maxlength='255' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getSistema())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="empresa">Empresa</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="empresa" name="empresa" maxlength='255' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getEmpresa())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="endereco">Endereço</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="endereco" name="endereco" maxlength='255' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getEndereco())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="link">Site</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="link" name="link" maxlength='255' mask='counter' tabindex='<?=(++$tabindex)?>' value='<?=($o->getLink())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="twitter">Twitter</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="twitter" name="twitter" maxlength='255' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getTwitter())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="facebook">Facebook</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="facebook" name="facebook" maxlength='255' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getFacebook())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="email">E-mail (s)</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="email" name="email" maxlength='100' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getEmail())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="telefone">Telefone (s)</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="telefone" name="telefone" maxlength='100' mask='phone' tabindex='<?=(++$tabindex)?>' value='<?=($o->getTelefone())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="emailContato">E-mail (s) de contato</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="emailContato" name="emailContato" maxlength='100' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getEmailContato())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="tituloContato">Titulo do texto de contato</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="tituloContato" name="tituloContato" maxlength='100' mask='' tabindex='<?=(++$tabindex)?>' value='<?=($o->getTituloContato())?>'/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="relatorioLogo">Logo do relatório</label>
                                <label class="input">
                                    <img src="<?= MediaUtil::getLinkForFileNameById('Configuracao/relatorioLogo', $o->getId()); ?>"  alt="" class="img-thumbnail" width="75" height="75"> <button title="Alterar imagem" onclick="$('#relatorioLogo').slideToggle()" class="btn btn-default btn-mini tip-top"><i class="fa fa-pencil"></i></button>
<input class="inptext" type="file" id="relatorioLogo" name="relatorioLogo" maxlength='100' tabindex="<?=++$tabindex?>" size='20' style="display:none;"/>
                                </label>
                        </section>


                        <section>
                            <label class="label" for="relatorioCabecalho">Cabeçalho do relatório</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="relatorioCabecalho" name="relatorioCabecalho" tabindex='<?=(++$tabindex)?>'><?=($o->getRelatorioCabecalho())?></textarea>
                                </label>
                        </section>


                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="ConfiguracaoEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="ConfiguracaoEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?=$this->module?>/Configuracao/adm" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>