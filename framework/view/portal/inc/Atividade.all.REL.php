<div>
    <?php
    if ($oAtividade && $oAtividade->getTipo() == "REL") {
        $oAtividadeAction = new AtividadeAction();
        $aColunaTmp = $oAtividadeAction->getColunas($oAtividade->getId());
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
                $aIdColuna = array_flip($aColunaRandomA);
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
                    $aSaida[$k]["A"] = $colunaA;
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
                    $aSaida[$k]["B"] = $colunaB;
                }
                ?>
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
                            ?>
                            <tr>
                                <th><?php echo ($k + 1) ?></th>
                                <td>
                                    <?php echo $val["A"] ?>
                                    <br/>
                                    <select id="lado_A<?php echo $k ?>" onchange="selecionaColuna('#lado_B<?php echo $k ?>', $(this).val());">
                                        <option>-Selecione-</option>
                                        <?php foreach ($aColunaRandomB as $v) { ?>
                                            <option value="<?php echo $v ?>">Coluna - B<?php echo $v ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <?php echo $val["B"] ?>
                                    <br/>
                                    <select id="lado_B<?php echo $k ?>" onchange="selecionaColuna('#lado_A<?php echo $k ?>', $(this).val());">
                                        <option>-Selecione-</option>
                                        <?php foreach ($aColunaRandomA as $v) { ?>
                                            <option value="<?php echo $v ?>">Coluna - A<?php echo $v ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <script type="text/javascript">
                    function selecionaColuna(elem, value) {
//                        alert(elem + "/" + value);
                        $(elem).val(value);
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