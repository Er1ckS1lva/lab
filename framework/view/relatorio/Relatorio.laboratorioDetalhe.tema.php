<?php
$object = $response->get("object");
$objects = $response->get("objects");
$aAtividadeTema = $response->get("aAtividadeTema");
?>

<div class="widget-body-toolbar bg-color-white">
    Alunos
</div>
<div class="padding-10">
    <form method="post" autocomplete="off" enctype='multipart/form-data' class="smart-form" onsubmit="return false;">
        <input type="hidden" name="id" value="<?php echo $object["ID"] ?>"/>
        <section>
            <label class="label"for="titulo">Título</label>
            <label class="input">
                <input class='form-control input-sm' type='text' id='titulo' name='titulo' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('titulo') ?>'/>
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

            <button type="submit" class="btn btn-primary" onclick="alternaAbaDetalhe('div_tema', '<?php echo $object["ID"] ?>', this);"><i class="fa fa-search"></i> Pesquisar</button>
        </footer>
        <input type="hidden" id="__gen_currpage_del_handler__" value="<?php echo $delHandlerCurrPage ?>" />
        <input type="hidden" id="__gen_order_del_handler__" value="<?php echo "{$orderPageLinks}{$orderPageConditions}" ?>" />
    </form>
    <hr/>

    <?php if ($objects) { ?>
        <? foreach ($objects as $k => $o) { ?>
            <table class="table table-bordered table-striped with-check table-hover">
                <thead>
                    <tr>
                        <th colspan="2" style="font-size: 16px;"><?php echo ($k + 1) . "°" ?> Tema: <?= $o["titulo"] ?></th>
                    </tr>
                    <tr>
                        <th>ID: <?= $o["ID"] ?></th>
                        <th>Título: <?= $o["titulo"] ?></th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <th colspan="2" style="text-align: center;">
                            <?php if ($aAtividadeTema[$o["ID"]]) { ?>
                                Lista de <?php echo count($aAtividadeTema[$o["ID"]]) ?> atividade(s)
                            <?php } else { ?>
                                <label style="font-weight: bold;"> Nenhuma atividade para este tema.</label>
                            <?php } ?>
                        </th>
                    </tr>
                    <?php if ($aAtividadeTema[$o["ID"]]) { ?>
                        <tr>
                            <td colspan="2">
                                <table class="table table-bordered table-striped with-check table-hover">
                                    <thead>
                                        <tr>
                                            <th>Atividade</th>
                                            <th>Tipo</th>
                                            <th>Quantidade de Alunos</th>
                                            <th>Quantidade de Acesso</th>
                                            <th>Média de Acesso</th>
                                            <th>Primeiro Acesso</th>
                                            <th>Último Acesso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($aAtividadeTema[$o["ID"]] as $oAtividade) { ?>
                                            <tr>
                                                <td><?php echo $oAtividade["titulo"] ?></td>
                                                <td><?php echo $oAtividade["tipo"] ?></td>
                                                <td><?php echo $oAtividade["quantidade"] ?></td>
                                                <td><?php echo $oAtividade["acessos"] ?></td>
                                                <td><?php echo $oAtividade["medias_acesso"] ?></td>
                                                <td><?php echo $oAtividade["primeiro_acesso"] ?></td>
                                                <td><?php echo $oAtividade["ultimo_acesso"] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>                            
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr/>
        <? } ?>
        <?php
    } else {
        include IGENIAL_DIR_BIBVIEW . '/empty.php';
    }
    ?>

</div>