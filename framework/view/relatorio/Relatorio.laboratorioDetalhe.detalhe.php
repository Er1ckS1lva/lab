<?php
$object = $response->get("object");
?>

<div class="widget-body-toolbar bg-color-white">
    Detalhes
</div>

<div class="padding-10">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2" style="text-align: center;">Detalhe do Curso</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    ID:
                </td>
                <td>
                    <?php echo $object["ID"] ?>
                </td>
            </tr>
            <tr>
                <td>
                    Título:
                </td>
                <td>
                    <?php echo $object["titulo"] ?>
                </td>
            </tr>                                            
        </tbody>
    </table>
    
    <hr/>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2" style="text-align: center;">Resumo de Registro</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    N° de Participantes:
                </td>
                <td>
                    <?php echo $object["participantes"] ?>
                </td>
            </tr>
            <tr>
                <td>
                    N° de Temas:
                </td>
                <td>
                    <?php echo $object["temas"] ?>
                </td>
            </tr>
            <tr>
                <td>
                    Quanti. de Acesso:
                </td>
                <td>
                    <?php echo $object["acessos"] ?>
                </td>
            </tr>
            <tr>
                <td>
                    Média de Acesso por Participante:
                </td>
                <td>
                    <?php echo $object["medias_acesso"] ?>
                </td>
            </tr>
            <tr>
                <td>
                    Primeiro Acesso:
                </td>
                <td>
                    <?php echo $object["primeiro_acesso"] ? Util::transformaData($object["primeiro_acesso"], 'mysql2normal', true) : NULL ?>
                </td>
            </tr>
            <tr>
                <td>
                    Último Acesso:
                </td>
                <td>
                    <?php echo $object["ultimo_acesso"] ? Util::transformaData($object["ultimo_acesso"], 'mysql2normal', true) : NULL ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>