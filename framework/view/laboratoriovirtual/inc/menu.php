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
<!--            <li class="submenu" entity="Idioma">
                <a href="<?= $sUrlEstou ?>Idioma"><i class="fa fa-language"></i> <span>Idiomas</span></a>
            </li>-->
            
            <li class="submenu" entity="Laboratorio">
                <a href="<?= $sUrlEstou ?>Laboratorio"><i class="fa fa-building"></i> <span>Laboratório</span></a>
            </li>

            <li class="submenu" entity="Tema">
                <a href="<?= $sUrlEstou ?>Tema"><i class="fa fa-th-list"></i> <span>Tema</span></a>
            </li>

            <li class="submenu" entity="Atividade">
                <a href="<?= $sUrlEstou ?>Atividade"><i class="fa fa-tasks"></i> <span>Atividade</span></a>
            </li>

            <li class="submenu" entity="Aluno">
                <a href="<?= $sUrlEstou ?>Aluno"><i class="fa fa-user"></i> <span>Aluno</span></a>
            </li>
            
            <li class="submenu" entity="Pagina">
                <a href="<?= $sUrlEstou ?>Pagina"><i class="fa fa-columns"></i> <span>Página</span></a>
            </li>
        </ul>
    </li>
    <?
}?>