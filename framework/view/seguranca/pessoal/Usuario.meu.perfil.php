<?
$o = $response->get("object");
$oUsuario = UtilAuth::recuperaObjetoUsuario();
$oPermissaoAction = new PermissaoAction();
$oModuloAction = new ModuloAction();
$oAcaoAction = new AcaoAction();
$aPermissao = $oPermissaoAction->collection(null, "o.Perfil = {$oUsuario->getPerfil()->getId()}");
?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-eye"></i> </span>
                <h2>Ações que posso realizar</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <div class="widget-body-toolbar">

                    </div>
                    <table id="<?php echo $aPermissao ? "dt_basic" : "" ?>" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Ação</th>
								<th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            if ($aPermissao) {
                                foreach ($aPermissao as $oPermissao) {
                                    $aAcao = $oAcaoAction->collection(null, "o.Modulo = {$oPermissao->getModulo()->getId()}");
                                    if ($aAcao) {
                                        foreach ($aAcao as $oAcao) {
                                            ?>
                                            <tr>
                                                <td><?= $oPermissao->getModulo()->getNome() ?></td>
                                                <td><?= $oAcao->getNome() ?></td>
												<td><?= $oAcao->getDescricao() ?></td>
                                            </tr>
                                            <?
                                        }
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="2">Você não possui nenhuma permissão!</td>
                                </tr>
                                <?
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </article>
</div>