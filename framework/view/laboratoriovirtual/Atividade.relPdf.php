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
                <h2>Atividades</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
                        <table class="table table-bordered table-striped with-check table-hover">
                            <thead>
                                <tr>
                                    <th><a href="?order=Tema<?= $allFilters ?>">Tema</a></th>
<th><a href="?order=titulo<?= $allFilters ?>">Título</a></th>
<th><a href="?order=descricao<?= $allFilters ?>">Descrição</a></th>
<th><a href="?order=tipo<?= $allFilters ?>">Tipo</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($objects as $o) { ?>
                                    <tr>
                                        <td><?=$o->getTema()->getTitulo()?></td>
<td><?=$o->getTitulo()?></td>
<td><?=$o->getDescricao()?></td>
<td><?= AtividadeAction::getValueForTipo($o->getTipo()); ?></td>
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