<?
if ($response->get("total") == 0) {
    include IGENIAL_DIR_BIBVIEW . '/empty.php';
} else {
    $objects = $response->get("objects");
    ?>
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2>Logs</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
                        <table class="table table-bordered table-striped with-check table-hover">
                            <thead>
                                <tr>
                                    <th><a href="?order=Usuario<?= $allFilters ?>">Usuário</a></th>
<th><a href="?order=login<?= $allFilters ?>">Login</a></th>
<th><a href="?order=dataHora<?= $allFilters ?>">Data e hora</a></th>
<th><a href="?order=acao<?= $allFilters ?>">Ação</a></th>
<th><a href="?order=operacao<?= $allFilters ?>">Operação</a></th>
<th><a href="?order=descricao<?= $allFilters ?>">Descrição</a></th>
<th><a href="?order=ip<?= $allFilters ?>">IP</a></th>
<th><a href="?order=nomeHost<?= $allFilters ?>">HOSTNAME</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($objects as $o) { ?>
                                    <tr>
                                        <td><?=$o->getUsuario()->getNome()?></td>
<td><?=$o->getLogin()?></td>
<td><?=Util::convertDataOut($o->getDataHora(),1)?></td>
<td><?=$o->getAcao()?></td>
<td><?= LogAction::getValueForOperacao($o->getOperacao()); ?></td>
<td><?=$o->getDescricao()?></td>
<td><?=$o->getIp()?></td>
<td><?=$o->getNomeHost()?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>							

                    </form>
                </div>
            </div>
        </div>
    </article>
    <?
}?>