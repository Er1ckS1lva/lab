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
                <h2>Vídeos</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
                        <table class="table table-bordered table-striped with-check table-hover">
                            <thead>
                                <tr>
                                    <th><a href="?order=titulo<?= $allFilters ?>">Título</a></th>
<th><a href="?order=nomeAutor<?= $allFilters ?>">Nome do autor</a></th>
<th><a href="?order=ano<?= $allFilters ?>">Ano</a></th>
<th><a href="?order=fonte<?= $allFilters ?>">Fonte</a></th>
<th><a href="?order=palavraChaveMusica<?= $allFilters ?>">Palavra chave</a></th>
<th><a href="?order=arquivo<?= $allFilters ?>">Arquivo</a></th>
<th><a href="?order=arquivoName<?= $allFilters ?>">Nome do arquivo</a></th>
<th><a href="?order=arquivoType<?= $allFilters ?>">Tipo do arquivo</a></th>
<th><a href="?order=arquivoSize<?= $allFilters ?>">Tamanho do arquivo</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($objects as $o) { ?>
                                    <tr>
                                        <td><?=$o->getTitulo()?></td>
<td><?=$o->getNomeAutor()?></td>
<td><?=$o->getAno()?></td>
<td><?=$o->getFonte()?></td>
<td><?=$o->getPalavraChaveMusica()?></td>
<td><?=$o->getArquivo()?></td>
<td><?=$o->getArquivoName()?></td>
<td><?=$o->getArquivoType()?></td>
<td><?=$o->getArquivoSize()?></td>
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