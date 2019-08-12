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
                    <form class="smart-form" action="<?= URL_APP ?><?= $this->module ?>/Relatorio/relQuantidadeAcessoTemaPeriodoAdmFilter" id="frm" method="GET" autocomplete="off">
                        <fieldset>
                            <div class="row">
                                <section class="col col-md-6">
                                    <label class="label" for="dataInicial">Data Inicial</label>
                                    <label class="input">
                                        <input class='form-control input-sm' mask="date" type='text' id='dataInicial' name='dataInicial'  tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('dataInicial') ? $response->get('dataInicial') : date('d/m/Y', strtotime('-15 days', strtotime(date('d-m-Y')))) ?>'/>
                                    </label>
                                </section>

                                <section class="col col-md-6">
                                    <label class="label" for="dataFinal">Data Final</label>
                                    <label class="input">
                                        <input class='form-control input-sm' mask="date" type='text' id='dataFinal' name='dataFinal'  tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('dataFinal') ? $response->get('dataFinal') : date('d/m/Y') ?>'/>
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
    <? include 'Relatorio.relQuantidadeAcessoTemaPeriodoAdm.php' ?>
</div>
