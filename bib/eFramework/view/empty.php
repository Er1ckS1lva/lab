<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-info"></i> </span>
            <h2>Aviso</h2>
        </header>
        <div>
            <!-- CONTEUDO DO WIDGET-->
            <div class="widget-body padding">
                <div class="alert alert-info alert-block">
                    <h4 class="alert-heading"><?= $response->get("title") ? $response->get("title") : "Nenhum registro encontrado!" ?></h4>
                    <?= $response->get("msg") ? $response->get("msg") : "Efetue novos cadastros ou aguarde a criação dos mesmos. Eles aparecerão aqui." ?>
                </div>
            </div>
        </div>
    </div>
</article>