<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Aluno</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Aluno.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            
                            <input type="hidden" id="id" name="id" value='<?= ($o->getId()) ?>'/>
                            <section>
                                <label class="label" for="nome">Nome</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="nome" name="nome" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getNome()) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="email">Email</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="email" name="email" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getEmail()) ?>'/>
                                </label>
                            </section>

                            <section>
                                <label class="label" for="ativo">Ativo</label>
                                <label class="input">
                                    <?= AlunoAction::getComboBoxForAtivo($o->getAtivo(), ( ++$tabindex)); ?>

                                </label>
                            </section>



                            <section>
                                <label class="label" for="dataNascimento">Data de Nascimento</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="dataNascimento" name="dataNascimento" maxlength='10' mask='date' tabindex='<?= ( ++$tabindex) ?>' value='<?= Util::convertDataOut($o->getDataNascimento()) ?>' >
                                </label>
                            </section>


                            <section>
                                <label class="label" for="sexo">Sexo</label>
                                <label class="input">
                                    <?= AlunoAction::getComboBoxForSexo($o->getSexo(), ( ++$tabindex)); ?>

                                </label>
                            </section>


                            <section>
                                <label class="label" for="cpf">CPF</label>
                                <label class="input">
                                    <input  value='<?= ($o->getCpf()) ?>' class="form-control" onkeyup="formatar(this, '9999999999')" type="text" id="cpf" name="cpf" maxlength='14' mask='cpf' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="cidade">Cidade</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="cidade" name="cidade" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getCidade()) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="estado">Estado</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="estado" name="estado" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getEstado()) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="nacionalidade">Nacionalidade</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="nacionalidade" name="nacionalidade" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getNacionalidade()) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="instituicaoEnsino">Instituição de Ensino</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="instituicaoEnsino" name="instituicaoEnsino" maxlength='150' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getInstituicaoEnsino()) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="curso">Curso</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="curso" name="curso" maxlength='150' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getCurso()) ?>'/>
                                </label>
                            </section>


                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="AlunoEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="AlunoEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?= $this->module ?>/Aluno/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>