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
                <h2>Logs</h2>
                <div class="widget-toolbar" role="menu"> 
                    <?php echo $response->get("perPageLinks") ?>
                </div>
                <div class="widget-toolbar" role="menu"> 
                    <?php echo $response->get("paginationLinks") ?>
                </div>
                <div class="widget-toolbar" role="menu">
                    <a class="btn btn-info btn-xs" rel="tooltip" data-placement="top" title="Baixar PDF" target="_BLANK" href="<?php echo URL_APP ?><?= $this->module ?>/Log/relPDF?<?php echo $allFiltersRel ?>">
                        <span class="fa fa fa-file-pdf-o"></span>
                    </a>
                    <a class="btn btn-info btn-xs" rel="tooltip" data-placement="top" title="Baixar tudo HTML" target="_BLANK" href="<?php echo URL_APP ?><?= $this->module ?>/Log/relPdf?porPagina=T">
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
                                    <th width="">
                                        <input type="checkbox" id="title-checkbox" name="title-checkbox" onchange="toggleCheckboxStatus(this.checked, this.form)"/>
                                    </th>
                                    <th><a href="?order=Usuario<?= $allFilters ?>">Usuário</a></th>
                                    <th><a href="?order=login<?= $allFilters ?>">Login</a></th>
                                    <th><a href="?order=dataHora<?= $allFilters ?>">Data e hora</a></th>
                                    <th><a href="?order=acao<?= $allFilters ?>">Ação</a></th>
                                    <th><a href="?order=operacao<?= $allFilters ?>">Operação</a></th>
                                    <th><a href="?order=descricao<?= $allFilters ?>">Descrição</a></th>
                                    <th><a href="?order=ip<?= $allFilters ?>">IP</a></th>
                                    <th><a href="?order=nomeHost<?= $allFilters ?>">HOSTNAME</a></th>
                                    <th width="" colspan="2" class="acao">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($objects as $o) { ?>
                                    <tr>
                                        <td><input type="checkbox" name="seleciona[]" value="<?php echo $o->getId() ?>" /></td>
                                        <td><?= $o->getUsuario()->getNome() ?></td>
                                        <td><?= $o->getLogin() ?></td>
                                        <td><?= $o->getDataHora()->format('d/m/Y H:i:s') ?></td>
                                        <td><?= $o->getAcao() ?></td>
                                        <td><?= LogAction::getValueForOperacao($o->getOperacao()); ?></td>
                                        <td><?= $o->getDescricao() ?></td>
                                        <td><?= $o->getIp() ?></td>
                                        <td><?= $o->getNomeHost() ?></td>
                                        <td class="edicao">
                                            <a href="<?php echo URL_APP ?><?= $this->module ?>/Log/edit/<?php echo $o->getId() ?>" class="btn btn-default btn-small">
                                                <i class="fa fa-edit"></i> Editar
                                            </a>
                                        </td>
                                        <td class="delecao">
                                            <a data-toggle="modal" href="#deleteActionModal" onclick="LogDeleteHandler('Log.del&id=<?php echo $o->getId() ?>');" class="btn btn-danger btn-small">
                                                <i class="fa fa-trash-o"></i> Excluir
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