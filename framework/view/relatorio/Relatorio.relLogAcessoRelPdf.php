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
                <h2>Log de Acesso</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
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
                    </form>
                </div>
            </div>
        </div>
    </article>
    <?
}?>