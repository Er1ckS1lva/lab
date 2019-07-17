<?php
$o = $response->get("objects");
?>
<script type="text/javascript">
    $(document).ready(function () {
        alternaUsuarioAbaDetalhe('div_matricula', '<?php echo $o["id"] ?>');
    });
</script>

<section id="widget-grid" class="">
    <div class="row">
        <article class="col-sm-12">
            <div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-check-square-o txt-color-darken"></i> </span>
                    <h2><?php echo 'Usuário' ?></h2>
                    <ul class="nav nav-tabs pull-right in" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#s1">
                                <i class="fa fa-eye-slash"></i> <span class="hidden-mobile hidden-tablet">Detalhes</span>
                            </a>
                        </li>
                    </ul>
                </header>

                <div class="no-padding">
                    <div class="widget-body">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="s1">
                                <div class="padding-10">
                                    <table class="" style="border: none">
                                        <tbody>
                                            <tr>
                                                <td width='170'>
                                                    ID:
                                                </td>
                                                <td>
                                                    <?php echo $o['id']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width='170'>
                                                    Nome:
                                                </td>
                                                <td>
                                                    <?php echo $o['nome']; ?>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td width='170'>
                                                    Número de Temas:
                                                </td>
                                                <td>
                                                    <?php echo $o['qtd_tema']; ?>
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td width='170'>
                                                    Número de Atividades:
                                                </td>
                                                <td>
                                                    <?php echo $o['qtd_atividade']; ?>
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td width='170'>
                                                    Quantidade de Acesso:
                                                </td>
                                                <td>
                                                    <?php echo $o['qtd_acesso']; ?>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td width='170'>
                                                    Primeiro Acesso:
                                                </td>
                                                <td>
                                                    <?php echo $o['primeiro_acesso'] ? Util::transformaData($o["primeiro_acesso"], 'mysql2normal', true) : NULL; ?>
                                                </td>
                                            </tr>   
                                            <tr>
                                                <td width='170'>
                                                    Último Acesso:
                                                </td>
                                                <td>
                                                    <?php echo $o['ultimo_acesso'] ? Util::transformaData($o["ultimo_acesso"], 'mysql2normal', true) : NULL; ?>
                                                </td>
                                            </tr>   
                                        </tbody>
                                    </table>
                                </div>
                                <div class="widget-body padding-10">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="hr2">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#div_matricula" onclick="alternaUsuarioAbaDetalhe('div_matricula', '<?php echo $o["id"] ?>');">Matrícula</a>
                                                </li>
                                                <li class="">
                                                    <a data-toggle="tab" href="#div_avaliacao" onclick="alternaUsuarioAbaDetalhe('div_avaliacao', '<?php echo $o["id"] ?>');">Avaliação</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content padding-10">
                                                <div class="tab-pane active" id="div_matricula">
                                                    <!--                                                    <form class="navbar-form navbar-left" role="search">
                                                                                                            <div class="form-group">
                                                                                                                <input class="form-control" placeholder="Pesquisar" type="text">
                                                                                                            </div>
                                                                                                            <button class="btn btn-default" type="submit" onclick="">
                                                                                                                <i class="fa fa-search"></i>
                                                                                                            </button>
                                                                                                        </form>-->
                                                </div>
                                                <div class="tab-pane" id="div_avaliacao">

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>             
                    </div>
                </div>
            </div>
        </article>
    </div>

</section>