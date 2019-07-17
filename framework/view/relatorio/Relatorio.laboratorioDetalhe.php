<?php
$object = $response->get("object");
?>

<section id="widget-grid" class="">

    <div class="row">
        <article class="col-sm-12">
            <div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-check-square-o txt-color-darken"></i> </span>
                    <h2><?php echo $object["titulo"] ?></h2>

                    <ul class="nav nav-tabs pull-right in" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#s1">
                                <i class="fa fa-eye-slash"></i> <span class="hidden-mobile hidden-tablet">Detalhes</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#div_alunos" onclick="alternaAbaDetalhe('div_alunos', '<?php echo $object["ID"] ?>');">
                                <i class="fa fa-users"></i> <span class="hidden-mobile hidden-tablet">Alunos</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#div_avaliacao" onclick="alternaAbaDetalhe('div_avaliacao', '<?php echo $object["ID"] ?>');">
                                <i class="fa fa-star"></i> <span class="hidden-mobile hidden-tablet">Avaliação</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#div_tema" onclick="alternaAbaDetalhe('div_tema', '<?php echo $object["ID"] ?>');">
                                <i class="fa fa-th-list"></i> <span class="hidden-mobile hidden-tablet">Tema/Atividade</span>
                            </a>
                        </li>
                    </ul>

                </header>

                <div class="no-padding">
                    <div class="widget-body">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="s1">
                                <?php include "Relatorio.laboratorioDetalhe.detalhe.php" ?>
                            </div>

                            <div class="tab-pane fade" id="div_alunos">
                            </div>
                            
                            <div class="tab-pane fade" id="div_avaliacao">
                            </div>
                            
                            <div class="tab-pane fade" id="div_tema">
                            </div>
                        </div>             
                    </div>
                </div>
            </div>
        </article>
    </div>

</section>