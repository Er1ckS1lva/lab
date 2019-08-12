<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-o"></i> </span>
                <h2>Aluno</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Aluno.formSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <section>
                                <label class="label" for="nome">Nome</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="nome" name="nome" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="email">Email</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="email" name="email" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="senha">Senha</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="senha" name="senha" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="dtCadastro">Data de Cadastro</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="dtCadastro" name="dtCadastro" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="recuperaSenhaData">Data de recuperação de senha</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="recuperaSenhaData" name="recuperaSenhaData" maxlength='20' mask='date' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="recuperaSenhaHash">Hash de recuperaração senha</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="recuperaSenhaHash" name="recuperaSenhaHash" maxlength='20' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="criarContaHash">Hash de criação de conta</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="criarContaHash" name="criarContaHash" maxlength='256' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="ativo">Ativo</label>
                                <label class="input">
                                    <?= AlunoAction::getComboBoxForAtivo(null, ( ++$tabindex)); ?>

                                </label>
                            </section>


                            <section>
                                <label class="label" for="login">Login</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="login" name="login" maxlength='20' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="aceiteTermo">Aceite Termo</label>
                                <label class="input">
                                    <?= AlunoAction::getComboBoxForAceiteTermo(null, ( ++$tabindex)); ?>

                                </label>
                            </section>


                            <section>
                                <label class="label" for="dataNascimento">Data de Nascimento</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="dataNascimento" name="dataNascimento" maxlength='10' mask='date' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="sexo">Sexo</label>
                                <label class="input">
                                    <?= AlunoAction::getComboBoxForSexo(null, ( ++$tabindex)); ?>

                                </label>
                            </section>


                            <section>
                                <label class="label" for="moderado">Moderado</label>
                                <label class="input">
                                    <?= AlunoAction::getComboBoxForModerado(null, ( ++$tabindex)); ?>

                                </label>
                            </section>


                            <section>
                                <label class="label" for="cpf">CPF</label>
                                <label class="input">
                                    <input class="form-control" onkeyup="formatar(this, '9999999999')" type="text" id="cpf" name="cpf" maxlength='11' mask='cpf' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="cidade">Cidade</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="cidade" name="cidade" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="estado">Estado</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="estado" name="estado" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="nacionalidade">Nacionalidade</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="nacionalidade" name="nacionalidade" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="instituicaoEnsino">Instituição de Ensino</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="instituicaoEnsino" name="instituicaoEnsino" maxlength='150' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="curso">Curso</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="curso" name="curso" maxlength='150' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>


                        </fieldset>
                        <footer>
                            <button class="btn btn-primary" onclick="AlunoSubmitHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="AlunoSubmitHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a href="<?= URL_APP ?><?= $this->module ?>/Aluno/admFilter" tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>