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
                        <h2>Log de Acesso Tabela</h2>
                        <div class="widget-toolbar" role="menu"> 
                            <?php echo $response->get("perPageLinks") ?>
                        </div>
                        <div class="widget-toolbar" role="menu"> 
                            <?php echo $response->get("paginationLinks") ?>
                        </div>
                        <div class="widget-toolbar" role="menu">
                            <a class="btn btn-info btn-xs" rel="tooltip" data-placement="top" title="Baixar PDF" target="_BLANK" href="<?php echo URL_APP ?><?= $this->module ?>/Relatorio/relLogAcessoRelPdf?<?php echo $allFiltersRel ?>">
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
                                            <th>Recurso</th>
                                            <th>Atividade</th>
                                            <th>Tema</th>
                                            <th>Aluno</th>
                                            <th>Data de Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        foreach ($objects as $o) {
                                            ?>
                                            <tr>
                                                <td><?= AlunoAcessoAction::getValueForRecurso($o['recurso']); ?></td>
                                                <td><?= $o['atividade'] ? $o['atividade'] : "" ?></td>
                                                <td><?= $o['tema'] ? $o['tema'] : "" ?></td>
                                                <td><?= $o['aluno'] ?></td>
                                                <td><?= $o['dt_registro'] ?></td>
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
                        <h2>Log de Acesso Gráfico</h2>
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
                                                    text: 'Relatório de Log de Acesso'
                                                },
                                                xAxis: {
                                                    type: 'category',
                                                    labels: {
                                                        rotation: -45,
                                                        style: {
                                                            fontSize: '11px',
                                                            fontFamily: 'Verdana, sans-serif'
                                                        }
                                                    }
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: 'Acessos'
                                                    }
                                                },
                                                legend: {
                                                    enabled: false
                                                },
                                                tooltip: {
                                                    pointFormat: 'Acessos: <b>{point.y:.1f}</b>',
                                                },
                                                series: [{
                                                        name: 'Acesso',
                                                        data: [
    <?= implode(",", $dados) ?>
                                                        ],
                                                        dataLabels: {
                                                            enabled: true,
                                                            rotation: -90,
                                                            color: '#FFFFFF',
                                                            align: 'right',
                                                            x: 4,
                                                            y: 10,
                                                            style: {
                                                                fontSize: '13px',
                                                                fontFamily: 'Verdana, sans-serif',
                                                                textShadow: '0 0 3px black'
                                                            }
                                                        }
                                                    }]
                                            });
                                        });


                                        $("#btnExport").bind('click', function (event) {
                                            $('#container').highcharts().exportChart({type: "application/pdf"});
                                        });

    </script>

    <?
}?>