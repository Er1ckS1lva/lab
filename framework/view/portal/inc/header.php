<div class="cabecalho">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <header class="d-flex flex-column flex-md-row justify-content-between align-items-center my-3">
                    <div class="logo d-flex flex-column flex-md-row align-items-center">
                        <a href="<?php echo URL ?>"><img src="<?= URL_PORTAL ?>img/logo-small.png" alt="logo" class="" /></a>
                        <h6 class="link-quem-somos">
                            ELLA: English Learning Laboratory
                            <br>Instituto de Letras e Linguística
                            <br>Universidade Federal de Uberlândia
                        </h6>
                        <?php
                        $aPagina = $response->get("aPagina");
                        if ($aPagina) {
                            foreach ($aPagina as $key => $oPagina) {
                                ?>
                                <a target="<?php echo $oPagina->getTarget() == 'S' ? '_blank' : ''; ?>" href="<?php echo URL . "pagina/" . $oPagina->getId() ?>" class="link-quem-somos"><?php echo $oPagina->getTitulo(); ?></a>
                                <?
                            }
                        }
                        ?>
                    </div>
                    <?php if (isset($_SESSION['serAlunoSessao'])) {
                        ?><div class="usuario-logado">Bem vindo(a): <?php echo $_SESSION['alunoNome'] ?> | <a id="href-logout" data-toggle="tooltip" title="Sai do sistema" href="<?= URL ?>logout">Sair</a></div>
                    <?php } ?>
                </header>
            </div>
        </div>
    </div>

    <?php
    $aIdiomaHeader = $response->get("aIdiomaHeader");
    if ($aIdiomaHeader) {
        ?>
        <div class="container-fluid bg-menu d-flex justify-content-end align-items-center">
            <!--<a href="#menu-principal"><i class="fa fa-bars"></i></a>-->
            <!--        <div class="btn-group dropright" data-toggle="tooltip" data-placement="top" title="Mudar idioma">
                        <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-language" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-dark" href="#">PT_BR (Brasil)</a>
                            <a class="dropdown-item text-dark" href="#">EN_US (English)</a>
                            <a class="dropdown-item text-dark" href="#">ES_ES (España)</a>
                        </div>
                    </div>-->            
            <div>
                <?php foreach ($aIdiomaHeader as $oIdioma) { ?>
                    <?php
                    $aActiveSession = array("icon" => "", "class" => "");
                    if ($oIdioma->getId() == IdiomaAction::getIdiomaPadraoSession()) {
                        $aActiveSession = array("icon" => '<i class="fa fa-check-square-o"></i>', "class" => "active");
                    }
                    ?>
                    <button class="btn btn-outline-light <?php echo $aActiveSession["class"] ?>" onclick="setIdiomaPadraoSession(<?php echo $oIdioma->getId() ?>);"><?php echo $aActiveSession["icon"] ?> <?php echo $oIdioma->getSigla() ?> (<?php echo $oIdioma->getTitulo() ?>)</button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</div>

<!--<nav id="menu-principal">
    <ul>
        <li><a href="<?php echo URL ?>">Home</a></li>
<li><a href="/contact">Contact</a></li>
</ul>
</nav>-->