<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Usuário</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Usuario.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <input type="hidden" id="id" name="id" value='<?= ($o->getId()) ?>'/>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"for="Perfil">Perfil</label>
                                    <label class="input">
                                        <suggest id='Perfil' entity='Perfil' hasComboBox='true' tabindex='<?= (++$tabindex) ?>' value='<?= ($o->getPerfil()->getId()) ?>' />
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label class="label"for="nome">Nome</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="nome" name="nome" maxlength='45' mask='' validate='0' tabindex='<?= (++$tabindex) ?>' value='<?= ($o->getNome()) ?>'/>
                                    </label>
                                </section>
                            </div>


                            <section>
                                <label class="label"for="login">Login</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="login" name="login" maxlength='20' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value='<?= ($o->getLogin()) ?>'/>
                                </label>
                            </section>


                            <!--                            
                                                        <section>
                                                            <label class="label"for="senha">Senha</label>
                                                            <label class="input">
                                                                <input class="form-control"  type="text" id="senha" name="senha" maxlength='256' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value=''/>
                                                            </label>
                                                        </section>
                            
                                                        <section>
                                                            <label class="label"for="senha">Senha Conf.</label>
                                                            <label class="input">
                                                                <input class="form-control"  type="text" id="senhaConf" name="senhaConf" maxlength='256' mask='' validate='1' tabindex='<?= (++$tabindex) ?>' value=''/>
                                                            </label>
                                                        </section>
                            -->


                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"for="email">E-mail</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="email" name="email" maxlength='200' mask='' validate='0' tabindex='<?= (++$tabindex) ?>' value='<?= ($o->getEmail()) ?>'/>
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label class="label"for="ativo">Ativo</label>
                                    <label class="input">
                                        <?= UsuarioAction::getComboBoxForAtivo($o->getAtivo()); ?>

                                    </label>
                                </section>
                            </div>


                            <div class="row">
                                <section class="col col-4">
                                    <label class="label"for="foto">Foto</label>
                                    <label class="input">
                                        <img src="<?= MediaUtil::getLinkForFileNameById('Usuario/foto', $o->getId()); ?>"  alt="" class="img-thumbnail" width="75" height="75"> 
                                        <button title="Alterar imagem" onclick="$('#foto').slideToggle()" class="btn btn-default btn-mini tip-top"><i class="fa fa-pencil"></i></button>
                                        <input class="inptext" type="file" id="foto" name="foto" maxlength='100' tabindex="<?= ++$tabindex ?>" size='20' style="display:none;"/>
                                    </label>
                                </section>

                                <section class="col col-4">
                                    <label class="label"for="dataInicio">Data de Início</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="dataInicio" name="dataInicio" maxlength='10' mask='date' validate='0' tabindex='<?= (++$tabindex) ?>' value='<?= ($o->getDataInicio()->format('d/m/Y')) ?>' >
                                    </label>
                                </section>

                                <section class="col col-4">
                                    <label class="label"for="dataFinal">Data Final</label>
                                    <label class="input">
                                        <input class="form-control"  type="text" id="dataFinal" name="dataFinal" maxlength='10' mask='date' validate='1' tabindex='<?= (++$tabindex) ?>' value='<?= $o->getDataFinal() ? ($o->getDataFinal()->format('d/m/Y')) : "" ?>' >
                                    </label>
                                </section>
                            </div>

                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="UsuarioEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="UsuarioEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?= $this->module ?>/Usuario/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>

