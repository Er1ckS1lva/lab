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
            <li class="submenu" entity="Usuario">
                <a href="<?= $sUrlEstou ?>Usuario"><i class="fa fa-user"></i> <span>Usuário</span></a>
            </li>

            <li class="submenu" entity="Perfil">
                <a href="<?= $sUrlEstou ?>Perfil"><i class="fa fa-unlock-alt"></i> <span>Perfil</span></a>
            </li>
            
            <? if (MODULO_CONFIGURACAO_ATIVO) { ?>
                <li class="submenu" entity="Configuracao">
                    <a href="<?= $sUrlEstou ?>Configuracao"><i class="fa fa-gears"></i> <span>Configuração</span></a>
                </li>
            <? } ?>

            <? if (MODULO_MENU_ATIVO) { ?>
                <li class="submenu" entity="ModuloMenu">
                    <a href="<?= $sUrlEstou ?>ModuloMenu"><i class="fa fa-adjust"></i> <span>Módulo do Menu</span></a>
                </li>
            <? } ?>


            <!--
            <li class="submenu" entity="Modulo">
                <a href="<?= $sUrlEstou ?>Modulo"><i class="fa fa-stack-overflow"></i> <span>Módulo</span></a>
            </li>

            <li class="submenu" entity="Entidade">
                <a href="<?= $sUrlEstou ?>Entidade"><i class="fa fa-bars"></i> <span>Entidade</span></a>
            </li>

            <li class="submenu" entity="Acao">
                <a href="<?= $sUrlEstou ?>Acao"><i class="fa fa-bullhorn"></i> <span>Ação</span></a>
            </li>
            -->
        </ul>
    </li>
    <?
}?>