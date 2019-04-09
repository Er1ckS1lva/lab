<html>
    <head>
        <!--CONFIGURAÇÃO HEAD-->
        <?php include dirname(__FILE__) . "/inc/head.php"; ?>
        <?php include dirname(__FILE__) . "/inc/config_js.php"; ?>

        <title>Atividade - Laboratório Virtual</title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include dirname(__FILE__) . "/inc/config_css.php"; ?>
    </head>


    <body>
        <script type="text/javascript">

        </script>
        <div class="geral">

            <?php include dirname(__FILE__) . "/inc/header.php"; ?>

            <!--<div id="">-->
            <?php
            $aAtividade = $response->get("aAtividade");
            $idAtividade = $response->get('idAtividade');

            if ($aAtividade) {
                ?>
                <div id="tabs-list" class="sw-main sw-theme-default">
                    <?php
                    $aConteudo = $response->get('aConteudo');
                    $aConteudoArquivo = $response->get('aConteudoArquivo');
                    $aConteudoFormulario = $response->get('aConteudoFormulario');
                    $qtd_ativi = count($aAtividade) - 1;
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
                                                    <?php if ($aConteudo[$oAtividade->getId()]) { ?>
                                                        <div class="tipo-atividade lacunas">
                                                            <div class="cycle-slideshow"
                                                                 data-cycle-prev=".prev"
                                                                 data-cycle-next=".next"
                                                                 data-cycle-fx="scrollHorz"
                                                                 data-cycle-timeout=0
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
                                                                                echo '<img class="img-fluid" src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '" />';
                                                                                break;

                                                                            case 'image/png':
                                                                                echo '<img class="img-fluid" src="data:' . $aConteudoArquivo[$oConteudo->getId()]->getTipo() . ';base64,' . base64_encode($aConteudoArquivo[$oConteudo->getId()]->getArquivo()) . '" />';
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
                                                                                <label class="radio">
                                                                                    <?php
                                                                                    foreach ($aFormularioOpcao as $key => $oFO) {
                                                                                        ?>
                                                                                        <input type="checkbox" name="formulario_opcao">
                                                                                        <i><?php echo $oFO->getValor(); ?></i>
                                                                                        <br/>
                                                                                    <?php }
                                                                                    ?>
                                                                                </label>
                                                                            <?php } else if ($aConteudoFormulario[$oConteudo->getId()]->getTipo() == "MEI") {
                                                                                ?>
                                                                                <label class="radio">
                                                                                    <?php foreach ($aFormularioOpcao as $key => $oFO) {
                                                                                        ?>
                                                                                        <input type="radio" name="formulario_opcao">
                                                                                        <i><?php echo $oFO->getValor(); ?></i>
                                                                                        <br/>
                                                                                    <?php }
                                                                                    ?>
                                                                                </label>
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
                                                                    <span class="prev"><a href=#><< Prev</a></span>
                                                                    <span class="next" style="margin-left:20px"><a href=#>Next >></a></span>
                                                                </div>
                                                            <?php } ?>

                                                            <div class="embed-responsive embed-responsive-16by9 mt-5">
                                                                <!--<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>-->
                                                            </div>
                                                        </div>
                                                    <?php }
                                                    ?>
                                                    <div class="d-flex flex-column flex-md-row justify-content-around mb-3">
                                                        <div class="controles text-center">
                                                            <div class="controles text-center mb-3">
                                                                <!--
                                                                        <h3>Controles</h3>
                                                                        <div class="controle-atividade d-flex justify-content-around">
                                                                            <div class="btn-record"><i class="fa fa-circle"></i></div>
                                                                            <div class="btn-play"><i class="fa fa-play"></i></div>
                                                                            <div class="btn-pause"><i class="fa fa-pause"></i></div>
                                                                            <div class="btn-stop"><i class="fa fa-stop"></i></div>
                                                                        </div>
                                                                -->
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
                                                    <div class="texto-atividade">
                                                        <?php echo $oAtividade->getDescricao(); ?>
                                                        <?php
                                                        $aOpcao = $response->get('aOpcao');
                                                        if ($aOpcao[$oAtividade->getId()]) {
                                                            foreach ($aOpcao[$oAtividade->getId()] as $k => $oOpcao) {
                                                                $alfabeto = range('A', 'Z');
                                                                ?>
                                                                <?php
                                                                echo $alfabeto[$k] . ") " . $oOpcao->getValor();
                                                                ?>
                                                                <br>
                                                                <?
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3 btns-right text-center">
                                                    <div class="mb-3">
                                                        <button class="btn btn-outline-danger btn-lg">Talk to Theresa or Marcus</button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button class="btn btn-outline-success btn-lg">Online dictionary</button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button class="btn btn-outline-info btn-lg">Library</button>
                                                    </div>
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
                    ?>
                    <ul class="nav nav-tabs step-anchor" id="myTab"  role="tablist">
                        <?php
                        foreach ($aAtividade as $key => $oAtividade) {
                            ?>
                            <li class="nav-item <?php echo $oAtividade->getId() == $idAtividade ? 'active' : ''; ?>" >
                                <a class="nav-link <?php echo $oAtividade->getId() == $idAtividade ? 'active' : ''; ?> " style="cursor: pointer;" 
                                   id="home-tab" data-toggle="tab" onclick="Reload(<?php echo $oAtividade->getId(); ?>)" 
                                   href="#atividade<?php echo $oAtividade->getId() ?>">
                                    Atividade <?php echo $key + 1 ?><br /><small><?php echo $oAtividade->getTitulo(); ?></small>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>


            <?php } else { ?>
                <br><h3><?php echo "Não há atividades para esse tema." ?></h3><br>
            <?php } ?>
        </div>

        <hr />


    </div>
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
                return "Você tem certeza que deseja sair da atividade?";
            };
        }

        $('a#href-logout').click(function (evt) {
            if (confirm("Você tem certeza que deseja sair do sistema (e da atividade)?")) {
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
