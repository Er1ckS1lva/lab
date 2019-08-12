<?
if ($response->get("total") == 0) {
    include IGENIAL_DIR_BIBVIEW . '/empty.php';
} else {
    $objects = $response->get("objects");
    $orderPageConditions = $response->get("orderPageConditions");
    $orderPageLinks = $response->get("orderPageLinks");
    $currentPageLink = "&page={$response->get("currentPage")}";
    $orderAscDesc = "&orderAscDesc={$response->get("orderAscDesc")}";
    $allFilters = "{$orderPageConditions}{$currentPageLink}{$orderAscDesc}";
    $delHandlerCurrPage = Util::getAdmPageDelHandlerCurrPage($response->get("resultsInPage"), $response->get("currentPage"));

    $orderAscDescRel = "&orderAscDesc=" . ControllerUtil::orderInverteAscDesc($orderAscDesc);
    $allFiltersRel = "order={$response->get("order")}{$orderPageConditions}{$currentPageLink}{$orderAscDescRel}&porPagina={$response->get('resultsInPage')}";
    ?>
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2>Laboratórios</h2>
                <div class="widget-toolbar" role="menu"> 
                    <?php echo $response->get("perPageLinks") ?>
                </div>
                <div class="widget-toolbar" role="menu"> 
                    <?php echo $response->get("paginationLinks") ?>
                </div>
                <div class="widget-toolbar" role="menu">
                    <a class="btn btn-info btn-xs" rel="tooltip" data-placement="top" title="Baixar PDF" target="_BLANK" href="<?php echo URL_APP ?><?= $this->module ?>/Relatorio/laboratorioRelPDF?<?php echo $allFiltersRel ?>">
                        <span class="fa fa fa-file-pdf-o"></span>
                    </a>
                    <a class="btn btn-info btn-xs" rel="tooltip" data-placement="top" title="Baixar tudo HTML" target="_BLANK" href="<?php echo URL_APP ?><?= $this->module ?>/Relatorio/laboratorioRelPDF?porPagina=T">
                        <span class="fa fa fa-file"></span>
                    </a>
                </div>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
                        <table class="table table-bordered table-striped with-check table-hover">
                            <thead>
                                <tr>                                    
                                    <th><a href="?order=o.id<?= $allFilters ?>">ID</a></th>
                                    <th><a href="?order=o.titulo<?= $allFilters ?>">Título</a></th>
                                    <th>Nº de Temas</th>
                                    <th>Quantidade de Participantes</th>
                                    <th>Quantidade de Acesso</th>
                                    <th>Média de Acesso</th>
                                    <th>Primeiro Acesso</th>
                                    <th>Segundo Acesso</th>
                                    <th width="" colspan="1" class="acao">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($objects as $k => $o) { ?>
                                    <tr>
                                        <td><?= $o["ID"] ?></td>
                                        <td><?= $o["titulo"] ?></td>
                                        <td><?= $o["temas"] ?></td>
                                        <td><?= $o["participantes"] ?></td>
                                        <td><?= $o["acessos"] ?></td>
                                        <td><?= $o["medias_acesso"] ?></td>
                                        <td><?= $o["primeiro_acesso"] ? Util::transformaData($o["primeiro_acesso"], 'mysql2normal', true) : NULL ?></td>
                                        <td><?= $o["ultimo_acesso"] ? Util::transformaData($o["ultimo_acesso"], 'mysql2normal', true) : NULL ?></td>
                                        <td class="">                                            
                                            <a class="btn btn-default" data-toggle="modal" href="#actionModal" onclick="eqDialogInclude('Relatorio.laboratorioDetalhe', 'Detalhes', '<?php echo $o["ID"] ?>', '95%');">
                                                <i class="fa fa-eye"></i> Detalhes
                                            </a>
                                        </td>                                        
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
    <?
}?>