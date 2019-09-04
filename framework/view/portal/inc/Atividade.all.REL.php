<div>
    <?php
    if ($oAtividade && $oAtividade->getTipo() == "REL") {
        $oAtividadeAction = new AtividadeAction();
        $aColunaTmp = $oAtividadeAction->getColunas($oAtividade->getId());
//        Util::debug($aColunaTmp);
        if ($aColunaTmp) {
            $oAtividadeColunaArquivoAction = new AtividadeColunaArquivoAction();
            $aColuna = $aColunaTmp["coluna"];
            $aColunaCount = $aColunaTmp["count"];
            if (isset($aColuna[IdiomaAction::getIdIdioma()])) {
                $aColunaRandomA = $aColunaRandomB = array();
                $aColunaAux = array();
                foreach ($aColuna[IdiomaAction::getIdIdioma()] as $oColuna) {
                    $id_coluna = $oColuna["coluna"]["id"];
                    $aColunaAux[$id_coluna] = array(
                        "id" => $id_coluna,
                        "coluna1" => $oColuna["coluna"]["coluna1"],
                        "coluna2" => $oColuna["coluna"]["coluna2"],
                        "tipo1" => $oColuna["coluna"]["tipo1"],
                        "tipo2" => $oColuna["coluna"]["tipo2"],
                        "coluna1Text" => $oColuna["coluna"]["coluna1Text"],
                        "coluna2Text" => $oColuna["coluna"]["coluna2Text"],
                        "arquivo" => ($oColuna["arquivo"] ? $oColuna["arquivo"] : array())
                    );
                    $aColunaRandomA[$id_coluna] = $aColunaAux[$id_coluna]["coluna1"];
                    $aColunaRandomB[$id_coluna] = $aColunaAux[$id_coluna]["coluna2"];
                }
                $aIdColunaTmpA = array_flip($aColunaRandomA);
                $aIdColunaTmpB = array_flip($aColunaRandomB);
                $aIdColuna = array_flip($aColunaRandomA);
//                Util::debug($aColunaAux);
                shuffle($aColunaRandomA);
                shuffle($aColunaRandomB);

                $aSaida = array();
                foreach ($aColunaRandomA as $k => $v) {
                    $coluna = $aColunaAux[$aIdColuna[$v]];
                    switch ($coluna["tipo1"]) {
                        case "IMG":
                            $oArquivo = $oAtividadeColunaArquivoAction->select($coluna["arquivo"][1]["id"], array("arquivo"));
                            $colunaA = '<img class="img-fluid image_atividade" src="data:' . $coluna["arquivo"][1]["tipo"] . ';base64,' . base64_encode($oArquivo["arquivo"]) . '" />';
                            break;
                        case "VID":
                            $oArquivo = $oAtividadeColunaArquivoAction->select($coluna["arquivo"][1]["id"], array("arquivo"));
                            $colunaA = '<div content="Content-Type: video/mp4">
                                        <video width="400" height="200" controls="controls" poster="image" preload="metadata">
                                        <source src="data:' . $coluna["arquivo"][1]["tipo"] . ';base64,' . base64_encode($oArquivo["arquivo"]) . '"/>;
                                        </video>
                                        </div>';
                            break;
                        default:
                            $colunaA = $coluna["coluna1Text"];
                            break;
                    }
                    $aSaida[$k]["A"] = [
                        "ID" => $coluna['id'],
                        "coluna" => $colunaA
                    ];
                    $i++;
                }
                foreach ($aColunaRandomB as $k => $v) {
                    $coluna = $aColunaAux[$aIdColuna[$v]];
                    switch ($coluna["tipo2"]) {
                        case "IMG":
                            $oArquivo = $oAtividadeColunaArquivoAction->select($coluna["arquivo"][2]["id"], array("arquivo"));
                            $colunaB = '<img class = "img-fluid image_atividade" src = "data:' . $coluna["arquivo"][2]["tipo"] . ';base64,' . base64_encode($oArquivo["arquivo"]) . '" />';
                            break;
                        case "VID":
                            $oArquivo = $oAtividadeColunaArquivoAction->select($coluna["arquivo"][2]["id"], array("arquivo"));
                            $colunaB = '<div content="Content-Type: video/mp4">
                                        <video width="400" height="200" controls="controls" poster="image" preload="metadata">
                                        <source src="data:' . $coluna["arquivo"][2]["tipo"] . ';base64,' . base64_encode($oArquivo["arquivo"]) . '"/>;
                                        </video>
                                        </div>';
                            break;
                        default:
                            $colunaB = $coluna["coluna2Text"];
                            break;
                    }
                    $aSaida[$k]["B"] = [
                        "ID" => $coluna['id'],
                        "coluna" => $colunaB
                    ];
                }
                ?>
                <div class='div-resposta'>
                    <table class="table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center;">N°</th>
                                <th style="text-align: center;">Coluna A</th>
                                <th style="text-align: center;">Coluna B</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            sort($aColunaRandomB);
                            sort($aColunaRandomA);
                            foreach ($aSaida as $k => $val) {
                                $ID_A = $val['A']["ID"];
                                $ID_B = $val['B']["ID"];
                                ?>
                                <tr>
                                    <th><?php echo ($k + 1) ?></th>
                                    <td>
                                        <?php echo $val["A"]['coluna']?>
                                        <br/>
                                        <select class="colunaA" data-col="colunaA" name= "lado_<?php echo $ID ?>_A<?php echo $k + 1 ?>" id="lado_A<?php echo $k + 1 ?>" onchange="selecionaColuna(<?php echo $k + 1 ?>, $(this).val(), <?php echo $ID_A ?>);">
                                            <option value="">-Selecione-</option>
                                            <?php foreach ($aColunaRandomB as $v) { ?>
                                                <option value="<?php echo $v ?>">Coluna - B<?php echo $v ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php echo $val["B"]['coluna']?>
                                        <br/>
                                        <div style="text-align: center; font-weight: bold;">
                                            <input type="hidden" class="lado_B<?php echo $k + 1 ?> aResposta" name="<?php echo $ID_B ?>" value=""/>
                                            <span id="lado_<?php echo $k + 1 ?>" style="color: #D63031; display: inline"><?php echo Lang::ATIVIDADE_atividadeNoRelacionar ?></span>
                                            <span id="lado_B<?php echo $k + 1 ?>" style="color: #0984E3; display: none"><?php echo Lang::ATIVIDADE_atividadeRelacionar ?> <b id="escolha"></b></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <button onclick="enviarRespostaAtividade($(this).parent('.div-resposta'), 'REL', <?php echo $oAtividade->getId(); ?>);" class="btn btn-info btn-sm btn-enviar-resposta"><?php echo Lang::ATIVIDADE_enviar ?></button>
                    <img style="display: none" class="img-resposta-ok" src="<?php echo URL_PORTAL ?>img/check_verde.jpeg" width="33" height="33" />
                </div>

                <script type="text/javascript">
                    function selecionaColuna(ladoA, value, id) {
                        // limpando o lado B caso esteja selecionado e o Lado A ao qual estava relacionado
                        var ladoASelect = $("#lado_B" + value).children().html();
                        if (ladoASelect) {
                            $("#lado_" + ladoASelect).val('');

                            ladoASelect = ladoASelect.substring(1, 2);

                            $("#escolha" + ladoASelect).html('');
                            $("#escolha" + ladoASelect).parent().hide();
                            $("#escolha" + ladoASelect).parent().siblings().show();
                            $("#escolha" + ladoASelect).attr('id', "escolha");
                        }
                        // limpar primeiro
                        $("#escolha" + ladoA).html('');
                        $("#escolha" + ladoA).parent().hide();
                        $("#escolha" + ladoA).parent().siblings().show();
                        $("#escolha" + ladoA).attr('id', "escolha");
                        if (value) {
                            $("#escolha" + ladoA).html('');
                            $("#lado_B" + value).find('#escolha').html("A" + ladoA);
                            $("#lado_B" + value).find('#escolha').attr('id', "escolha" + ladoA);
                            $("#lado_B" + value).show();
//                            $("input[name*='lado_B" + value + "']").val(id);
                            $(".lado_B" + value).val(id);
                            $("#lado_" + value).hide();
                        }
                    }
                </script>

            <?php } else { ?>
                <h2><?php echo Lang::ATIVIDADE_nenhum ?></h2>
                <?php
            }
        } else {
            ?>
            <h2><?php echo Lang::ATIVIDADE_nenhum ?></h2>
            <?php
        }
    }
    ?>
</div>