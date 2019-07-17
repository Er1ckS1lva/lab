<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
                <h2>Pesquisar Usuários</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form class="smart-form" action="<?= URL_APP ?><?= $this->module ?>/Usuario/admFilter" id="frm" method="GET" autocomplete="off">
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"for="Perfil">Perfil</label>
                                    <label class="input">
                                        <suggest id='Perfil' entity='Perfil' hasComboBox='true' tabindex='<?= (++$tabindex) ?>' value='<?= $response->get('Perfil') ?>' />
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label class="label"for="nome">Nome</label>
                                    <label class="input">
                                        <input class='form-control input-sm' type='text' id='nome' name='nome' mask='' tabindex='<?= (++$tabindex) ?>' value='<?= $response->get('nome') ?>'/>
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"for="login">Login</label>
                                    <label class="input">
                                        <input class='form-control input-sm' type='text' id='login' name='login' mask='' tabindex='<?= (++$tabindex) ?>' value='<?= $response->get('login') ?>'/>
                                    </label>
                                </section>

                                <section class="col col-6">
                                    <label class="label"for="email">E-mail</label>
                                    <label class="input">
                                        <input class='form-control input-sm' type='text' id='email' name='email' mask='' tabindex='<?= (++$tabindex) ?>' value='<?= $response->get('email') ?>'/>
                                    </label>
                                </section>
                            </div>

                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                            <a class="btn btn-info" href="<?= URL_APP ?><?= $this->module ?>/Usuario/form"><i class="fa fa-file"></i> Novo</a>
                            <a data-toggle="modal" class="btn btn-danger" href="#deleteMultipleActionModal" onclick="eqDeleteSelecionadosForm('resultados', 'Usuario.delSelected')" title="Clique aqui para excluir o(s) registro(s) selecionado(s)"><i class="fa fa-trash-o"></i> Excluir Selecionados</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
    <? include 'Usuario.adm.php'; ?>
</div>
