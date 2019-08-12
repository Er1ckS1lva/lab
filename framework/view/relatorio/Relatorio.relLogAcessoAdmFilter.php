<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
                <h2>Filtrar Relatório</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form class="smart-form" action="<?= URL_APP ?><?= $this->module ?>/Relatorio/relLogAcessoAdmFilter" id="frm" method="GET" autocomplete="off">
                        <fieldset>
                            <div class="row">
                                <section class="col col-md-6">
                                    <label class="label" for="mes">Mês</label>
                                    <label class="input">
                                        <?= RelatorioAction::getComboBoxMes($response->get('mes'), ( ++$tabindex)); ?>
                                    </label>
                                </section>

                                <section class="col col-md-6">
                                    <label class="label" for="ano">Ano</label>
                                    <label class="input">
                                        <input class='form-control input-sm invalid' data-mask="2099" type='text' id='ano' name='ano'  tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('ano') ? $response->get('ano') : date('Y') ?>'/>
                                    </label>
                                </section>
                            </div>

                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Gerar Relatório</button>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
    <? include 'Relatorio.relLogAcessoAdm.php'; ?>
</div>
