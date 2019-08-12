<?php
$object = $response->get("object");
$aAvaliacao = $response->get("aAvaliacao");
$objects = $response->get("objects");
$aAvaliacaoAluno = $response->get("aAvaliacaoAluno");
?>

<div class="widget-body-toolbar bg-color-white">
    Avaliação
</div>
<div class="padding-10">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="5" style="text-align: center;">Lista de Atividades</th>
            </tr>
            <tr>
                <th>Título</th>
                <th>Escala %</th>
                <th>Média %</th>
                <th>N° de Aluno Avaliado</th>
                <th>Tipo de Atividade</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($aAvaliacao) {
                foreach ($aAvaliacao as $oAvaliacao) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $oAvaliacao["titulo"] ?>
                        </td>                
                        <td>
                            <?php echo $oAvaliacao["escala"] ?>
                        </td>                
                        <td>
                            <?php echo $oAvaliacao["media"] ? $oAvaliacao["media"] : "0" ?>
                        </td>                
                        <td>
                            <?php echo $oAvaliacao["alunos"] ?>
                        </td>                
                        <td>
                            <?php echo AtividadeAction::getValueForTipo($oAvaliacao["tipo"]) ?>
                        </td>                
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <th colspan="5" style="text-align: center;">Nenhum Tema Encontrado</th>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <hr/>

    <form method="post" autocomplete="off" enctype='multipart/form-data' class="smart-form" onsubmit="return false;">
        <input type="hidden" name="id" value="<?php echo $object["ID"] ?>"/>
        <section>
            <label class="label"for="nome">Nome</label>
            <label class="input">
                <input class='form-control input-sm' type='text' id='nome' name='nome' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('nome') ?>'/>
            </label>
        </section>

        <footer>
            <div class="pull-left" style="padding-left: 2%;">
                <!--    <div class="widget-toolbar" role="menu"> 
                <?php echo $response->get("perPageLinks") ?>
        </div>-->
                <div class="widget-toolbar" role="menu"> 
                    <?php echo $response->get("paginationLinks") ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" onclick="alternaAbaDetalhe('div_avaliacao', '<?php echo $object["ID"] ?>', this);"><i class="fa fa-search"></i> Pesquisar</button>
        </footer>
        <input type="hidden" id="__gen_currpage_del_handler__" value="<?php echo $delHandlerCurrPage ?>" />
        <input type="hidden" id="__gen_order_del_handler__" value="<?php echo "{$orderPageLinks}{$orderPageConditions}" ?>" />
    </form>
    <hr/>

    <?php if ($objects) { ?>
        <table class="table table-bordered table-striped with-check table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>

                    <?php
                    if ($aAvaliacao) {
                        foreach ($aAvaliacao as $oAvaliacao) {
                            ?>
                            <th>
                                <?php echo $oAvaliacao["titulo"] ?> %
                            </th>                            
                            <?php
                        }
                    } else {
                        ?>
                        <th colspan="1" style="text-align: center;">Nenhum Atividade Encontrada</th>
                    <?php } ?>

                </tr>
            </thead>
            <tbody>
                <? foreach ($objects as $k => $o) { ?>
                    <tr>
                        <td><?= $o["ID"] ?></td>
                        <td><?= $o["nome"] ?></td>

                        <?php
                        if ($aAvaliacao) {
                            foreach ($aAvaliacao as $oAvaliacao) {
                                ?>
                                <td>
                                    <?php echo $aAvaliacaoAluno[$oAvaliacao["ID"]][$o["ID"]] ?>
                                </td>                            
                                <?php
                            }
                        } else {
                            ?>
                            <th colspan="1" style="text-align: center;">Nenhum Atividade Encontrada</th>
                        <?php } ?>

                    </tr>
                <? } ?>
            </tbody>
        </table>
        <?php
    } else {
        include IGENIAL_DIR_BIBVIEW . '/empty.php';
    }
    ?>

</div>