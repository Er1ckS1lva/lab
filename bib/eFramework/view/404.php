<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-warning"></i> </span>
            <h2>Erro 404</h2>
        </header>
        <div>
            <!-- CONTEUDO DO WIDGET-->
            <div class="widget-body padding">
                <div class="alert alert-danger alert-block">
                    <h4 class="alert-heading">Página não encontrada!</h4>
                    <p>Ocorreu um erro ao tentar buscar a página.</p>
                    <p>Verifique o caminho informado:</p>
                    <p class="alert alert-info">
                        <strong><?= $this->name ?></strong>
                    </p>
                    <p>Nota: Caso o caminho acima seja o desta página (no caso, <b>404.php</b>), a <strong>controller</strong> ou o seu <strong>método</strong> não foram encontrados.</p>
            </div>
            </div>
        </div>
    </div>
</article>