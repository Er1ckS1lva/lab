<?
if ($response->get("total") == 0) {
    include IGENIAL_DIR_BIBVIEW . '/empty.php';
} else {

    $dados = $response->get("dados");
//    $preparacao = Array([0] => ['067-Serviços de Bombeiro.', 1][1] => ['019-Outros', 188]

    $objects = $response->get("objects");
    $orderPageConditions = $response->get("orderPageConditions");
    $orderPageLinks = $response->get("orderPageLinks");
    $currentPageLink = "&page={$response->get("currentPage")}";
    $orderAscDesc = "&orderAscDesc={$response->get("orderAscDesc")}";
    $allFilters = "{$orderPageConditions}{$currentPageLink}{$orderAscDesc}{$response->get("porPagina")}";
    $delHandlerCurrPage = Util::getAdmPageDelHandlerCurrPage($response->get("resultsInPage"), $response->get("currentPage"));

    $orderAscDescRel = "&orderAscDesc=" . ControllerUtil::orderInverteAscDesc($orderAscDesc);
    $allFiltersRel = "order={$response->get("order")}{$orderPageConditions}{$currentPageLink}{$orderAscDescRel}&porPagina={$response->get('resultsInPage')}";
    ?>

    <style>
        .nav-tabs{
            padding-left: 16px;
        }
    </style>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Tabela</a></li>
        <li><a data-toggle="tab" href="#menu1">Gráfico</a></li>
    </ul>


    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Quantidade Acesso por Atividade Tabela</h2>
                        <div class="widget-toolbar" role="menu"> 
                            <?php echo $response->get("perPageLinks") ?>
                        </div>
                        <div class="widget-toolbar" role="menu"> 
                            <?php echo $response->get("paginationLinks") ?>
                        </div>
                        <div class="widget-toolbar" role="menu">
                            <a class="btn btn-info btn-xs" rel="tooltip" data-placement="top" title="Baixar PDF" target="_BLANK" href="<?php echo URL_APP ?><?= $this->module ?>/Relatorio/relQuantidadeAcessoAtividadeRelPdf?<?php echo $allFiltersRel ?>">
                                <span class="fa fa fa-file-pdf-o"></span>
                            </a>
                        </div>
                    </header>
                    <div>
                        <!-- widget content -->
                        <div class="widget-body no-padding">
                            <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' class='overflow_table'>
                                <table class="table table-bordered table-striped with-check table-hover">
                                    <thead>
                                        <tr>
                                            <th>Atividade</th>
                                            <th>Acessos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        foreach ($objects as $o) {
                                            $atividade = $o['atividade'];
                                            $acesso =  $o['acesso'];
                                            $serie[] = "
                                                {
                                                    name: '$atividade',
                                                    data: [" . $acesso . "]
                                                }";
                                            ?>
                                            <tr>
                                                <td><?= $o['atividade'] ?></td>
                                                <td><?= $o['acesso'] ?></td>
                                            </tr>
                                        <? } ?>
                                    </tbody>
                                </table>							
                                <input type="hidden" id="__gen_currpage_del_handler__" value="<?php echo $delHandlerCurrPage ?>" />
                                <input type="hidden" id="__gen_order_del_handler__" value="<?php echo "{$orderPageLinks}{$orderPageConditions}" ?>" />
                                <div class="widget-footer">
                                    <a href="#content" onclick="scrollAnimado(this)"><i class="fa fa-arrow-up"></i> Ir para o topo</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div id="menu1" class="tab-pane fade">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Quantidade Acesso por Atividade Gráfico</h2>
                        <div class="widget-toolbar" role="menu">
                            <a class="btn btn-info btn-xs" target="_BLANK" data-placement="top" title="Baixar PDF do Gráfico" href="#" id="btnExport">
                                <span class="fa fa fa-file-pdf-o"></span>
                            </a>
                        </div>
                    </header>
                    <div>
                        <!-- widget content -->
                        <div class="widget-body no-padding">
                            <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' class='overflow_table'>
                                <div class="col-xs-12">
                                    <div class="widget-box">
                                        <div class="widget-content">
                                            <div id="container">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <script>
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Relatório de Quantidade de Acesso por Atividade'
                },
                xAxis: {
                    categories: [
                        '<?php echo $response->get('mesGrafico'); ?>'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Acessos'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} acessos</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [<?= implode(",", $serie) ?>]
            });
        });


        $("#btnExport").bind('click', function (event) {
            $('#container').highcharts().exportChart({type: "application/pdf"});
        });

    </script>

    <?
}?>