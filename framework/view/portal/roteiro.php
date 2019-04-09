<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <!--CONFIGURAÇÃO HEAD-->
        <?php include './template_part/head.php'; ?>
        <title>Atividade - Laboratório Virtual</title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include './template_part/config_css.php'; ?>
    </head>

    <body>
        <div class="geral">

            <?php include './template_part/header.php'; ?>

<!--            <div class="progresso-atividade my-4">
                <div class="container-fluid">
                    <div class="row"> 
                        <div class="col">
                            <div class="d-flex flex-column">
                                <h6>Progresso da atividade</h6>
                                <div class="progress mb-1">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 100%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">90% Acertos</div>
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10% Erros</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            
            
            <div id="smartwizard">
                <ul>
                    <?php for($s=1;$s<10;$s++): ?>
                    <li><a href="#step-<?php echo $s; ?>">Step Title<br /><small>Step description</small></a></li>
                    <?php endfor; ?>
                </ul>

                <div>
                    
                    <?php for($step=1;$step<10;$step++): ?>
                    <div id="step-<?php echo $step; ?>" class="">
                        
                        <div class="pagina-atividade my-4">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <h1 class="titulo-atividade">Cognates and false cognates</h1>
                                        </div>
                                        <div class="d-flex flex-column flex-xl-row">
                                            <div class="d-flex flex-column flex-md-row justify-content-around mb-3 flex-grow-1">
                                                <div class="tipo-atividade mb-3">
                                                    <img src="img/peanuts.jpg" alt="nome da atividade" class="img-fluid" />
                                                </div>
                                                <div class="controles text-center mb-3">
                                                    <h3>Controles</h3>
                                                    <div class="controle-atividade d-flex justify-content-around">
                                                        <div class="btn-record"><i class="fa fa-circle"></i></div>
                                                        <div class="btn-play"><i class="fa fa-play"></i></div>
                                                        <div class="btn-pause"><i class="fa fa-pause"></i></div>
                                                        <div class="btn-stop"><i class="fa fa-stop"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="texto-atividade w-50">
                                                <h3>Instruções:</h3>
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec neque sed erat ultrices consequat. 
                                                Mauris ut ultrices libero. Nulla dui leo, posuere sed ultricies eu, iaculis sit amet nibh. Curabitur 
                                                nec sapien tellus. Nulla lobortis rhoncus nulla in rhoncus. Aliquam interdum sem id neque dapibus 
                                                tristique. Sed lobortis orci finibus posuere fermentum. Interdum et malesuada fames ac ante ipsum
                                                primis in faucibus. Vivamus faucibus, justo ut hendrerit finibus, nisi nulla varius nisl, et molestie 
                                                lacus lorem in risus. Nulla ipsum nisi, hendrerit quis leo et, fringilla dapibus orci. Vestibulum et
                                                nunc ligula. Aenean dignissim efficitur ultrices. In interdum metus ipsum, congue cursus libero auctor 
                                                ut. Aenean fringilla est sed turpis semper, sed viverra mi tincidunt. Fusce elementum erat vitae diam 
                                                tempus volutpat. Sed in neque augue.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <?php endfor; ?>
                    
                </div>
            </div>

            
<!--            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary tarefa-anterior disabled" type="button"><i class="fa fa-arrow-left"></i></button>
                            <button class="btn btn-primary proxima-tarefa" type="button"><i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>-->

        </div>
        <?php include './template_part/footer.php'; ?>

        <!--CONDIGURAÇÃO SCRIPS-->
        <?php include './template_part/config_js.php'; ?>
    </body>
</html>
