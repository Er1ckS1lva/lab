<div class="cabecalho">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <header class="d-flex flex-column flex-md-row justify-content-between align-items-center my-3">
                    <div class="logo d-flex flex-column flex-md-row align-items-center">
                        <a href="<?php echo URL ?>"><img src="<?php echo URL_PORTAL ?>img/logo-small.png" alt="logo ufu" class="" width="200" height="46" /></a>
                        <a href="<?php echo URL ?>"><img src="<?php echo URL_PORTAL ?>img/ILEEL.png" alt="logo ileel" class="" width="" height="57" style=" margin-left: 35px;" /></a>
                        <a href="<?php echo URL ?>"><img src="<?php echo URL_PORTAL ?>img/ELLA PNG.png" alt="logo ella" class=""  width="200" height="46" /></a>
                        <h6 class="link-quem-somos">
                            ELLA: English Language Learning Laboratory
                            <br/>Instituto de Letras e Linguística
                            <br/>Universidade Federal de Uberlândia
                        </h6>                        
                    </div>
                    <?php if (isset($_SESSION['serAlunoSessao'])) {
                        ?><div class="usuario-logado"><?php echo Lang::GERAL_bemVindo ?>: <?php echo $_SESSION['alunoNome'] ?> | <a id="href-logout" data-toggle="tooltip" href="<?php echo URL ?>logout"><?php echo Lang::GERAL_sair ?></a></div>
                    <?php } ?>
                </header>
            </div>
        </div>

        <div class="row">
            <?php
            $aPagina = $response->get("aPagina");
            if ($aPagina) {
                ?>
                <div class="col container-fluid bg-menu d-flex justify-content-begin align-items-center">
                    <div class="btn-group dropleft" data-toggle="tooltip" data-placement="top" title="">
                        <?php foreach ($aPagina as $key => $oPagina) { ?>
                            <a target="<?php echo $oPagina->getTarget() == 'S' ? '_blank' : ''; ?>" href="<?php echo URL . "pagina/" . $oPagina->getId() ?>" class="link-quem-somos"><?php echo $oPagina->getTitulo(); ?></a>
                        <? } ?>
                    </div>
                </div>
            <?php } ?>
            <?php
            $aIdiomaHeader = $response->get("aIdiomaHeader");
            if ($aIdiomaHeader) {
                ?>
                <div class="col container-fluid bg-menu d-flex justify-content-end align-items-center">
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
    </div>
</div>

<!--<nav id="menu-principal">
    <ul>
        <li><a href="<?php echo URL ?>">Home</a></li>
<li><a href="/contact">Contact</a></li>
</ul>
</nav>-->

<?php if ($_REQUEST["error_message"]) { ?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-12 text-center">
        <div class="mb-12" onclick="$(this).remove()">
            <div class="btn btn-outline-danger btn-lg">&times; <?php echo $_REQUEST["error_message"] ?></div>            
        </div>
    </div>
<?php } ?>
