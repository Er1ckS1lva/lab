<?
if ($response->get("total") == 0) {
    include IGENIAL_DIR_BIBVIEW . '/empty.php';
} else {
    $aHora = $response->get('aHora');
    $aAluno = $response->get('aAluno');
    $objects = $response->get("objects");
    ?>
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2>Quantidade de Acesso por Usuário por Hora</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
                        <table class="table table-bordered table-striped with-check table-hover">
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <?php
                                    foreach ($aHora as $h) {
                                        ?>
                                        <th><?php echo $h ?>H</th>
                                    <? } ?>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                foreach ($aAluno as $k => $a) {
                                    $totalAcesso = array_sum($a);
                                    ?>
                                    <tr>
                                        <td><?= $k ?></td>
                                        <?php
                                        foreach ($aHora as $h) {
                                            if (isset($a[$h])) {
                                                echo "<td>{$a[$h]}</td>";
                                            } else {
                                                echo "<td>-</td>";
                                            }
                                        }
                                        ?>
                                        <td><?= $totalAcesso ?></td>
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