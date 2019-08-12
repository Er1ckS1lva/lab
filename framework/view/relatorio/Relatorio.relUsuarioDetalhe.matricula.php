<?php
$objects = $response->get("objects");
?>
<?
if (count($objects) == 0) {
    include IGENIAL_DIR_BIBVIEW . '/empty.php';
} else {
    ?>
    <table class="table table-bordered table-striped with-check table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tema</th>
                <th>Quantidade de Acesso</th>
                <th>Primeiro Acesso</th>
                <th>Último Acesso</th>
        </thead>
        <tbody>
            <? foreach ($objects as $o) { ?>
                <tr>
                    <td><?= $o['id'] ?></td>
                    <td><?= $o['tema'] ?></td>
                    <td><?= $o['qtd_acesso'] ?></td>
                    <td><?php echo $o['primeiro_acesso'] ? Util::transformaData($o["primeiro_acesso"], 'mysql2normal', true) : NULL; ?></td>
                    <td><?php echo $o['ultimo_acesso'] ? Util::transformaData($o["ultimo_acesso"], 'mysql2normal', true) : NULL; ?></td>

                </tr>
            <? } ?>
        </tbody>
    </table>
    <?
}?>