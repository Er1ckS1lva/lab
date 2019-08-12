<?php
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
            <li class="submenu" entity="BibliotecaMusica">
                <a href="<?= $sUrlEstou ?>BibliotecaMusica"><i class="fa fa-music"></i> <span>Músicas</span></a>
            </li>
            <li class="submenu" entity="BibliotecaObraArte">
                <a href="<?= $sUrlEstou ?>BibliotecaObraArte"><i class="fa fa-file-audio-o"></i> <span>Obras de artes</span></a>
            </li>
            <li class="submenu" entity="BibliotecaVideo">
                <a href="<?= $sUrlEstou ?>BibliotecaVideo"><i class="fa fa-file-video-o"></i> <span>Vídeos</span></a>
            </li>
            <li class="submenu" entity="BibliotecaImagem">
                <a href="<?= $sUrlEstou ?>BibliotecaImagem"><i class="fa fa-file-image-o"></i> <span>Imagens</span></a>
            </li>
        </ul>
    </li>
    <?
}?>