<?php
$object = $response->get("object");
$objects = $response->get("objects");
?>

<div class="widget-body-toolbar bg-color-white">
    Alunos
</div>
<div class="padding-10">
    <form method="post" autocomplete="off" enctype='multipart/form-data' class="smart-form" onsubmit="return false;">
        <input type="hidden" name="id" value="<?php echo $object["ID"] ?>"/>
        <div class="row">
            <section class="col col-10">
                <label class="label"for="nome">Nome</label>
                <label class="input">
                    <input class='form-control input-sm' type='text' id='nome' name='nome' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= $response->get('nome') ?>'/>
                </label>
            </section>
            <section class="col col-2">
                <label class="label" for="">&nbsp;</label>
                <label class="checkbox">
                    <input type="checkbox" name="sem" <?= $response->get('sem') ? 'checked="checked"' : '' ?>>
                    <i></i>Sem Acesso
                </label>
            </section>                                                                           
        </div>

        <footer>
            <div class="pull-left" style="padding-left: 2%;">
                <!--    <div class="widget-toolbar" role="menu"> 
                <?php echo $response->get("perPageLinks") ?>
        </div>-->
                <div class="widget-toolbar" role="menu"> 
                    <?php echo $response->get("paginationLinks") ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" onclick="alternaAbaDetalhe('div_alunos', '<?php echo $object["ID"] ?>', this);"><i class="fa fa-search"></i> Pesquisar</button>
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
                    <th>E-mail</th>
                    <th>Data de Matrícula</th>
                    <th>Quantidade de Acesso</th>
                    <th>Primeiro Acesso</th>
                    <th>Segundo Acesso</th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($objects as $k => $o) { ?>
                    <tr>
                        <td><?= $o["ID"] ?></td>
                        <td><?= $o["nome"] ?></td>
                        <td><?= $o["email"] ?></td>
                        <td><?= $o["dt_cadastro"] ?></td>
                        <td><?= $o["acessos"] ?></td>
                        <td><?= $o["primeiro_acesso"] ? Util::transformaData($o["primeiro_acesso"], 'mysql2normal', true) : NULL ?></td>
                        <td><?= $o["ultimo_acesso"] ? Util::transformaData($o["ultimo_acesso"], 'mysql2normal', true) : NULL ?></td>                    
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