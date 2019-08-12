<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-filter"></i> </span>
                <h2>Relatorio de Usuário</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form class="smart-form" action="<?= URL_APP ?><?= $this->module ?>/Relatorio/relUsuarioAdmfilter" id="frm" method="GET" autocomplete="off">
                        <fieldset>
                            <section>
                                <label class="label" for="nome">Nome</label>
                                <label class="input">
                                    <input class='form-control input-sm' type='text' id='nome' name='nome' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('nome') ?>'/>
                                </label>
                            </section>
                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Gerar</button>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
    <? include 'Relatorio.relUsuarioAdm.php'; ?>
</div>
