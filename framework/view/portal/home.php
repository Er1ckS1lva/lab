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
        <title>Home - Laboratório Virtual</title>
        <!--CONFIGURAÇÃO CSS-->
        <?php include './template_part/config_css.php'; ?>
    </head>

    <body>
        <div class="geral">
            
            <!--modal apresentação-->
              
            <?php include './template_part/modal-apresentacao.php'; ?>
            
            <?php include './template_part/header.php'; ?>
            
            <div class="conteudo">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <?php $section = true; $contagem = 0; ?>
                            <?php for ($i = 1; $i <= 20; $i++): ?>
                                <?php if ($section): $section = false; ?>
                                    <section class="my-2 d-flex flex-column flex-md-row justify-content-center">
                                    <?php endif; ?>
                                    <?php $contagem++ ?>
                                        <a href="atividade.php" onmouseover="reproduzir(this)">
                                            <div class="bloco-tema d-flex flex-column justify-content-center align-items-center text-center my-1 mx-2 shadow-sm <?php echo 'color-' . $i ?>">
                                                <i class="fa fa-book"></i>
                                                <span>Cognates and false cognates</span>
                                            </div>
                                        </a>
                                    <?php if ($contagem==4): $contagem = 0; $section = true; ?>
                                    </section>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php include './template_part/footer.php'; ?>
        
         

        <!--CONDIGURAÇÃO SCRIPS-->
        <?php include './template_part/config_js.php'; ?>
     </body>
</html>
