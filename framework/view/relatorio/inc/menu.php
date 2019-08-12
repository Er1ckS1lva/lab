
<script src="<?= URL_WEBROOT ?>js/highcharts/highcharts.js"></script>
<script src="<?= URL_WEBROOT ?>js/highcharts/exporting.js"></script>
<?
$sUrlEstou = URL_APP . $this->module . "/";
# senao foi setado é porque não tem permissão na View
if (isset($this->aModules[$sUrlEstou])) {
    $sModuloEstou = $this->aModules[$sUrlEstou];
    ?>

    <li module="<?= $sModuloEstou["nome"] ?>">
        <a href="#" class="<?= $sModuloEstou["class"] ?>">
            <i class="fa fa-lg fa-fw <?= $sModuloEstou["icon"] ?>"></i> 
            <span class="menu-item-parent"><?= $sModuloEstou["descricao"] ?></span>
        </a>

        <ul>
            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relLogAcessoAdmFilter"><i class="fa fa-sign-in"></i> <span>Log de Acesso</span></a>
            </li>

            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relQuantidadeAcessoTemaAdmFilter"><i class="fa fa-th-list"></i> <span>Quantidade de Acesso por Tema</span></a>
            </li>

            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relQuantidadeAcessoAtividadeAdmFilter"><i class="fa fa-tasks"></i> <span>Quantidade de Acesso por Atividade</span></a>
            </li>

            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relQuantidadeAcessoUsuarioAdmFilter"><i class="fa fa-user"></i> <span>Quantidade de Acesso por Usuário</span></a>
            </li>

            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relQuantidadeAcessoTemaPeriodoAdmFilter"><i class="fa fa-calendar"></i> <span>Quantidade de Acesso por Tema por Período</span></a>
            </li>

            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relQuantidadeAcessoAtividadeMensalAdmFilter"><i class="fa fa-calendar-o"></i> <span>Quantidade de Acesso Mensal por Atividade</span></a>
            </li>

            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relQuantidadeAcessoUsuarioHoraAdmFilter"><i class="fa fa-clock-o"></i> <span>Quantidade de Acesso por Usuário por Hora</span></a>
            </li>

            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/relUsuarioAdmFilter"><i class="fa fa-sign-in"></i> <span>Usuário</span></a>
            </li>
            
            <li class="submenu" entity="Relatorio">
                <a href="<?= $sUrlEstou ?>Relatorio/laboratorioAdmFilter"><i class="fa fa-check-square-o"></i> <span>Laboratório</span></a>
            </li>
        </ul>
    </li>

    <?
}?>