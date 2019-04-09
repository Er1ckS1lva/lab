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
    </li>

    <?
}?>