<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
                <h2>Pesquisar Vídeos</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form class="smart-form" action="<?= URL_APP ?><?=$this->module?>/BibliotecaVideo/admFilter" id="frm" method="GET" autocomplete="off">
                        <fieldset>
                            <div class="row">
                                <section class="col col-md-6">
                                    <label class="label" for="titulo">Título</label>
                                        <label class="input">
                                            <input class='form-control input-sm' type='text' id='titulo' name='titulo' mask='' tabindex='<?=(++$tabindex)?>' value='<?= $response->get('titulo') ?>'/>
                                        </label>
                                </section>

                                <section class="col col-md-6">
                                    <label class="label" for="nomeAutor">Nome do autor</label>
                                        <label class="input">
                                            <input class='form-control input-sm' type='text' id='nomeAutor' name='nomeAutor' mask='' tabindex='<?=(++$tabindex)?>' value='<?= $response->get('nomeAutor') ?>'/>
                                        </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-md-6">
                                    <label class="label" for="ano">Ano</label>
                                        <label class="input">
                                            <input class='form-control input-sm' type='text' id='ano' name='ano' mask='' tabindex='<?=(++$tabindex)?>' value='<?= $response->get('ano') ?>'/>
                                        </label>
                                </section>

                                <section class="col col-md-6">
                                    <label class="label" for="fonte">Fonte</label>
                                        <label class="input">
                                            <input class='form-control input-sm' type='text' id='fonte' name='fonte' mask='' tabindex='<?=(++$tabindex)?>' value='<?= $response->get('fonte') ?>'/>
                                        </label>
                                </section>
                            </div>

                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
                            <a class="btn btn-info" href="<?= URL_APP ?><?=$this->module?>/BibliotecaVideo/form"><i class="fa fa-file"></i> Novo</a>
                            <a data-toggle="modal" class="btn btn-danger" href="#deleteMultipleActionModal" onclick="eqDeleteSelecionadosForm('resultados', 'BibliotecaVideo.delSelected')" title="Clique aqui para excluir o(s) registro(s) selecionado(s)"><i class="fa fa-trash-o-o"></i> Excluir Selecionados</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
    <? include 'BibliotecaVideo.adm.php'; ?>
</div>
