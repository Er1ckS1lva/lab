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
                <th>Tema</th>
                <th>Escala de Nota</th>
                <th>Média de Nota</th>
                <th>Média do Tema</th>
        </thead>
        <tbody>
            <? foreach ($objects as $o) { ?>
                <tr>
                    <td><?= $o['tema'] ?></td>
                    <td><?= $o['escala_nota'] ?></td>
                    <td><?= $o['media'] ?></td>
                    <td><?= $o['media_tema'] ?></td>

                </tr>
            <? } ?>
        </tbody>
    </table>
    <?
}?>