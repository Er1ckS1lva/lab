<html>
    <head>
        <!--CONFIGURAÇÃO HEAD-->
        <?php include dirname(__FILE__) . "/inc/head.php"; ?>
        <?php include dirname(__FILE__) . "/inc/config_js.php"; ?>

        <title><?php echo Lang::GERAL_atividade ?> - <?php echo Lang::GERAL_tituloUfu ?></title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include dirname(__FILE__) . "/inc/config_css.php"; ?>
    </head>


    <body>        
        <div class="geral">

            <?php include dirname(__FILE__) . "/inc/header.php"; ?>

            <?php
            $oTema = $response->get("oTema");
            $oTemaIdioma = $response->get("oTemaIdioma");

            $aAtividade = $response->get("aAtividade");
            $idAtividade = $response->get('idAtividade');
            ?>

            <div id="tabs-list" class="sw-main sw-theme-default">
                <?php if ($idAtividade === 0) { ?>
                    <div class="tab-content">
                        <?php include dirname(__FILE__) . "/Atividade.all.paginador.php"; ?>
                        <div class="tab-pane <?php echo 0 == $idAtividade ? 'active' : ''; ?> " id="atividade0">
                            <div class="pagina-atividade my-4">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <?php if ($oTemaIdioma) { ?>
                                                    <h1 class="titulo-atividade"><?php echo $oTemaIdioma->getTitulo(); ?></h1>
                                                <?php } else { ?>
                                                    <h1 class="titulo-atividade"><?php echo $oTema->getTitulo(); ?></h1>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-3">
                                            <?php
                                            $video = MediaUtil::getLinkForFileNameById("Tema/videoApresentacao", $oTema->getId());
                                            if ($video !== "javascript: void(0);") {
                                                ?>
                                                <? #= $video ?>
                                                <video controls style="width: 100%">
                                                    <source src="<?php echo $video ?>" type="video/mp4">
                                                    <source src="<?php echo $video ?>" type="video/ogg">
                                                    <?php echo Lang::GERAL_video_not ?>
                                                </video> 
                                            <?php } ?>

                                            <?php
                                            if ($oTemaIdioma) {
                                                echo $oTemaIdioma->getDescricao();
                                            } else {
                                                echo $oTema->getDescricao();
                                            }
                                            ?>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3 btns-right text-center">
                                            <?php include dirname(__FILE__) . "/inc/buttons.php"; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include dirname(__FILE__) . "/Atividade.all.paginador.php"; ?>
                    </div>

                <?php } ?>
                <?php if ($aAtividade) { ?>

                    <?php
                    $aConteudo = $response->get('aConteudo');
                    $aConteudoArquivo = $response->get('aConteudoArquivo');
                    $aConteudoFormulario = $response->get('aConteudoFormulario');
                    foreach ($aAtividade as $key => $oAtividade) {
                        ?>
                        <?php
                        if ($oAtividade->getId() == $idAtividade) {
                            ?>
                            <div class="tab-content">
                                <?php include dirname(__FILE__) . "/Atividade.all.paginador.php"; ?>
                                <div class="tab-pane <?php echo $oAtividade->getId() == $idAtividade ? 'active' : ''; ?> " id="atividade<?php echo $oAtividade->getId() ?>">

                                    <div class="pagina-atividade my-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <h1 class="titulo-atividade"><?php echo $oAtividade->getTitulo(); ?></h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-3">
                                                    <div class="texto-atividade">
                                                        <?php echo $oAtividade->getDescricao(); ?>
                                                        <?php
                                                        $aOpcao = $response->get('aOpcao');
                                                        if ($aOpcao[$oAtividade->getId()]) {
                                                            $alfabeto = range('A', 'Z');
                                                            foreach ($aOpcao[$oAtividade->getId()] as $k => $oOpcao) {
                                                                echo $alfabeto[$k] . ") " . $oOpcao->getValor();
                                                                echo "<br>";
                                                            }
                                                        }
                                                        ?>
                                                    </div>

                                                    <?php include dirname(__FILE__) . "/inc/Atividade.all.rel.php"; ?>                                                    

                                                    <?php if ($aConteudo[$oAtividade->getId()]) { ?>
                                                        <div class="tipo-atividade lacunas">
                                                            <div class="cycle-slideshow"
                                                                 data-cycle-prev=".prev"
                                                                 data-cycle-next=".next"
                                                                 data-cycle-fx="scrollHorz"
                                                                 data-cycle-timeout="0"
                                                                 data-cycle-slides="> div"
                                                                 >   
                                                                     <?php
                                                                     #MÍDIAS EXIBIDAS PARA TODOS OS TIPOS #jpeg; #png; #ogg #mp3 # mp4

                                                                     foreach ($aConteudo[$oAtividade->getId()] as $k => $oConteudo) {
                                                                         ?>
                                                                    <div class="itens-slide" style="width: 100%; display: block">
                                                                        <?php
                                                                        switch ($aConteudoArquivo[$oConteudo->getId()]->getTipo()) {
                                                                            case 'video/mp4':
                                                                                echo '<div content="Content-Type: video/mp4">
                                                                                    <video width="700" height="450" controls="controls" poster="image" preload="metadata">
                                                                                    <source src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '"/>;
                                                                                    </video>
                                                                                    </div>';
                                                                                break;

                                                                            case 'image/jpeg':
                                                                                echo '<img class="img-fluid image_atividade" src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '" />';
                                                                                break;

                                                                            case 'image/png':
                                                                                echo '<img class="img-fluid image_atividade" src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '" />';
                                                                                break;

                                                                            case 'image/gif':
                                                                                echo '<img class="img-fluid image_atividade" src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '" />';
                                                                                break;

                                                                            case 'audio/mpeg':
                                                                                echo '<audio controls="controls" preload="metadata">'
                                                                                . '<source src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '">'
                                                                                . '</audio>';
                                                                                break;


                                                                            case 'audio/ogg':
                                                                                echo '<audio controls="controls" preload="metadata">'
                                                                                . '<source src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '">'
                                                                                . '</audio>';
                                                                                break;

                                                                            case 'audio/mp3':
                                                                                echo '<audio controls="controls" preload="metadata">'
                                                                                . '<source src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '">'
                                                                                . '</audio>';
                                                                                break;

                                                                            default:
                                                                                break;
                                                                        }
                                                                        ?>
                                                                        <div>
                                                                            <p><?php echo $aConteudoFormulario[$oConteudo->getId()]->getEnunciado(); ?> </p>
                                                                            <?php
                                                                            $oFormularioOpcaoAction = new FormularioOpcaoAction();
                                                                            $aFormularioOpcao = $oFormularioOpcaoAction->collection(null, "o.ConteudoFormulario = {$aConteudoFormulario[$oConteudo->getId()]->getId()}");
                                                                            if ($aConteudoFormulario[$oConteudo->getId()]->getTipo() == "MEV") {
                                                                                ?>
                                                                                <?php
                                                                                foreach ($aFormularioOpcao as $key => $oFO) {
                                                                                    ?>
                                                                                    <label class="radio">
                                                                                        <input type="checkbox" name="formulario_opcao">
                                                                                        <i><?php echo $oFO->getValor(); ?></i>
                                                                                    </label>
                                                                                    <br/>
                                                                                <?php }
                                                                                ?>
                                                                            <?php } else if ($aConteudoFormulario[$oConteudo->getId()]->getTipo() == "MEI") {
                                                                                ?>
                                                                                <?php
                                                                                if ($aFormularioOpcao)
                                                                                    foreach ($aFormularioOpcao as $key => $oFO) {
                                                                                        ?>
                                                                                        <label class="radio">
                                                                                            <input type="radio" name="formulario_opcao">
                                                                                            <i><?php echo $oFO->getValor(); ?></i>
                                                                                        </label>
                                                                                        <br/>
                                                                                    <?php }
                                                                                ?>
                                                                            <?php } else if ($aConteudoFormulario[$oConteudo->getId()]->getTipo() == "TXT") {
                                                                                ?>
                                                                                <label class="input">
                                                                                    <input type="text" maxlength="150" name="formulario_opcao">
                                                                                </label>
                                                                            <?php }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                ?>
                                                            </div>

                                                            <?php if (count($aConteudo[$oAtividade->getId()]) > 1) { ?>
                                                                <div class=center>
                                                                    <span class="prev"><a href=#><< <?php echo Lang::ATIVIDADE_anterior ?></a></span>
                                                                    <span class="next" style="margin-left:20px"><a href=#><?php echo Lang::ATIVIDADE_posterior ?> >></a></span>
                                                                </div>
                                                            <?php } ?>


                                                        </div>
                                                    <?php }
                                                    ?>
                                                    <div class="d-flex flex-column flex-md-row justify-content-around mb-3">
                                                        <div class="controles text-center">
                                                            <div class="controles text-center mb-3">
                                                                <?php
                                                                if ($oAtividade->getTipo() == "PRC" || $oAtividade->getTipo() == "RPT" || $oAtividade->getTipo() == "EMO") {
                                                                    ?>
                                                                    <?php include dirname(__FILE__) . "/Atividade.gravador.php"; ?>
                                                                <?php } elseif ($oAtividade->getTipo() == "EMI") {
                                                                    ?>
                                                                    <?php include dirname(__FILE__) . "/Atividade.camera.php"; ?>
                                                                <? }
                                                                ?>
                                                            </div>
                                                            <!--<input type="text" id="nomeatividade" name="nomeatividade" class="input-atividade" maxlength="1" />--> 
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3 btns-right text-center">
                                                    <?php include dirname(__FILE__) . "/inc/buttons.php"; ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php include dirname(__FILE__) . "/Atividade.all.paginador.php"; ?>
                            </div>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <br><h3><?php echo Lang::ATIVIDADE_nenhum ?></h3><br>
                <?php } ?>

                <ul class="nav nav-tabs step-anchor" id="myTab"  role="tablist">
                    <li class="nav-item <?php echo 0 == $idAtividade ? 'active' : ''; ?>" >
                        <a class="nav-link <?php echo 0 == $idAtividade ? 'active' : ''; ?> " style="cursor: pointer;" 
                           id="home-tab" data-toggle="tab" onclick="Reload(0)" 
                           href="#atividade0">
                            <?php echo LANG::ATIVIDADE_intro ?> <br /><small><?php echo $oTema->getTitulo(); ?></small>
                        </a>
                    </li>
                    <?php
                    if ($aAtividade) {
                        foreach ($aAtividade as $key => $oAtividade) {
                            ?>
                            <li class="nav-item <?php echo $oAtividade->getId() == $idAtividade ? 'active' : ''; ?>" >
                                <a class="nav-link <?php echo $oAtividade->getId() == $idAtividade ? 'active' : ''; ?> " style="cursor: pointer;" 
                                   id="home-tab" data-toggle="tab" onclick="Reload(<?php echo $oAtividade->getId(); ?>)" 
                                   href="#atividade<?php echo $oAtividade->getId() ?>">
                                    <?php echo Lang::GERAL_atividade ?> <?php echo $key + 1 ?><br /><small><?php echo $oAtividade->getTitulo(); ?></small>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>

            </div>            
        </div>

        <hr />

        <?php include dirname(__FILE__) . "/inc/footer.php"; ?>
        <script type="text/javascript">

            //            $(document).ready(function () {
<?php /*
  if ($_REQUEST['p'] == 'tab1') {
  ?>
  $('#tab1').click();
  <?php
  } */
?>
            //        $(document).ready(function () {
            //
            //            $('#tabs-list').click(function () {
            //                newurl = window.location.href.split("#")[0];
            //                window.location.href = newurl.split("?")[0] + "?idAtividade=1";
            //            });
            //        });

            // Seta uma função global que valida se o usuário tentar sair da página
            function setUpBeforeUnload() {
                window.onbeforeunload = function () {
                    return "<?php echo Lang::ATIVIDADE_sairAtividade ?>";
                };
            }

            $('a#href-logout').click(function (evt) {
                if (confirm("<?php echo Lang::ATIVIDADE_sairAtividadeSistema ?>")) {
                    window.location.href = "<?= URL ?>logout";
                }
            }).attr('href', "#");

            function Reload(idAtividade) {
                newurl = window.location.href.split("#")[0];
                window.location.href = newurl.split("?")[0] + "?idAtividade=" + idAtividade;
            }

            //        </script>

    </body>
</html>
