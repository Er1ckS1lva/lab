<? foreach ($this->aModules as $sUrl => $sModulo) { ?>
    <li>
        <a href="<?= $sUrl ?>" class="<?= $sModulo["class"] ?> txt-color-white">
            <i class="fa fa-lg fa-fw <?= $sModulo["icon"] ?>"></i> 
            <span class="menu-item-parent"><?= $sModulo["descricao"] ?></span>
        </a>
    </li>
<? } ?>