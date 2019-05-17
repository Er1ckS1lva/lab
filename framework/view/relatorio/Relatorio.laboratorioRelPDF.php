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
                <h2>Relatório de Laboratório</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
                        <table class="table table-bordered table-striped with-check table-hover">
                            <thead>
                                <tr>                                    
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Nº de Temas</th>
                                    <th>Quantidade de Participantes</th>
                                    <th>Quantidade de Acesso</th>
                                    <th>Média de Acesso</th>
                                    <th>Primeiro Acesso</th>
                                    <th>Segundo Acesso</th>
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