<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
                <h2>Pesquisar Perfis</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form class="smart-form" action="<?= URL_APP ?><?= $this->module ?>/Perfil/admFilter" id="frm" method="GET" autocomplete="off">
                        <fieldset>
                            <section>
                                <label class="label"for="nome">Nome</label>
                                <label class="input">
                                    <input class='form-control input-sm' type='text' id='nome' name='nome' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('nome') ?>'/>
                                </label>
                            </section>


                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                            <a class="btn btn-info" href="<?= URL_APP ?><?= $this->module ?>/Perfil/form"><i class="fa fa-file"></i> Novo</a>
                            <a data-toggle="modal" class="btn btn-danger" href="#deleteMultipleActionModal" onclick="eqDeleteSelecionadosForm('resultados', 'Perfil.delSelected')" title="Clique aqui para excluir o(s) registro(s) selecionado(s)"><i class="fa fa-trash-o"></i> Excluir Selecionados</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
    <? include 'Perfil.adm.php'; ?>
</div>
