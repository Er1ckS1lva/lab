<?
$oUsuario = UtilAuth::recuperaObjetoUsuario();
$oLogAction = new LogAction();
$oUltimo = $oLogAction->ultimoLogin($oUsuario->getId());
$hora = (int) date("H");
if ($hora >= 6 && $hora < 12) {
    $saudacao = "Bom dia ";
} else if ($hora >= 12 && $hora < 18) {
    $saudacao = "Boa tarde ";
} else if (($hora >= 18 && $hora <= 23) || ($hora >= 0 && $hora < 6)) {
    $saudacao = "Boa noite ";
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa fa-home"></i> <?= $saudacao ?><?= $oUsuario->getNome() ?><?= ($oUltimo) ? " <span>Seu último acesso foi em " . Util::transformaData($oUltimo->getDataHora()->format('c'), 'mysql2normal', true) . "</span>" : "" ?></h1>
    </div>
</div>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-11" data-widget-colorbutton="false" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2><strong>Últimos Registros </strong> <i>(log)</i></h2>	
                    <ul id="widget-tab-1" class="nav nav-tabs pull-right">
                        <li class="active">
                            <a data-toggle="tab" href="#hr1"> <i class="fa fa-lg fa-database"></i> <span class="hidden-mobile hidden-tablet"> Ações </span> </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#hr2"> <i class="fa fa-lg fa-history"></i> <span class="hidden-mobile hidden-tablet"> Acessos </span></a>
                        </li>
                    </ul>	
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <!-- end widget edit box -->
                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <!-- widget body text-->
                        <div class="tab-content padding-10">
                            <div class="tab-pane fade in active" id="hr1">
                                <?
                                $objectsUltimos = $response->get("objectsUltimos");
                                if ($objectsUltimos) {
                                    ?>
                                    <table class="table table-bordered table-striped with-check table-hover">
                                        <thead>
                                            <tr>
                                                <th width="">Data e hora</th>
                                                <th width="">Operação</th>
                                                <th width="">Descrição</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($objectsUltimos as $o) { ?>
                                                <tr>
                                                    <td><?= Util::transformaData($o->getDataHora()->format('c'), 'mysql2normal', true) ?></td>
                                                    <td><?= LogAction::getValueForOperacao($o->getOperacao()); ?></td>
                                                    <td><?= $o->getDescricao() ?></td>
                                                </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                <? } else { ?>
                                    <h4 class="alert alert-info"> Nenhum registro de ação realizada. </h4>
                                <? } ?>
                            </div>
                            <div class="tab-pane fade" id="hr2">
                                <?
                                $objectsUltimosAcessos = $response->get("objectsUltimosAcessos");
                                if ($objectsUltimosAcessos) {
                                    ?>
                                    <table class="table table-bordered table-striped with-check table-hover">
                                        <thead>
                                            <tr>
                                                <th width="">Data e hora</th>
                                                <th width="">Operação</th>
                                                <th width="">Descrição</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach ($objectsUltimosAcessos as $o) { ?>
                                                <tr>
                                                    <td><?= Util::transformaData($o->getDataHora()->format('c'), 'mysql2normal', true) ?></td>
                                                    <td><?= LogAction::getValueForOperacao($o->getOperacao()); ?></td>
                                                    <td><?= $o->getDescricao() ?></td>
                                                </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                <? } else { ?>
                                    <h4 class="alert alert-info"> Nenhum registro de último acesso. </h4>
                                <? } ?>
                            </div>
                        </div>
                        <!-- end widget body text-->
                        <!-- widget footer -->
                        <!--                        <div class="widget-footer text-right">
                                                    <span class="onoffswitch-title">
                                                        <i class="fa fa-check"></i> Show Tabs
                                                    </span>
                                                    <span class="onoffswitch">
                                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="show-tabs" checked="checked">
                                                        <label class="onoffswitch-label" for="show-tabs"> 
                                                            <span class="onoffswitch-inner" data-swchon-text="True" data-swchoff-text="NO"></span> 
                                                            <span class="onoffswitch-switch"></span> 
                                                        </label> 
                                                    </span>
                                                </div>-->
                        <!-- end widget footer -->
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
    </div>
</section>