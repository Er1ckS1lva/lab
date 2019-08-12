<div class="row" rel="<?php echo $nCount ? "div_coluna_{$nCount}" : "" ?>">

    <?php if ($oColuna) { ?>
        <input type="hidden" name="aColunaTmp[<?php echo $id_idioma ?>][id][]" value="<?php echo $oColuna["coluna"]["id"] ?>">
    <?php } ?>

    <div class="panel panel-default conteudo-model">
        <div class="panel-heading">
            <h4 class="panel-title">
                Colunas <span class="numero_coluna"><?php echo $nCount ?></span>
                <div class="input input-file" style="float:right; top:-5px;">
                    <button class="btn btn-danger btn-sm" onclick="AtividadeDelColuna(this);"><i class="fa fa-trash"></i></button>
                </div>
            </h4>
        </div>
        <section class="col col-md-6">
            <fieldset>
                <legend>Coluna A</legend>
                <section class="col col-md-6">
                    <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Tipo</label>
                    <label class="input">
                        <?php
                        if ($oColuna) {
                            echo AtividadeColunaAction::getComboBoxForTipo1($oColuna["coluna"]["tipo1"], ($tabindex++), "-Selecione-", "onchange='AtividadeColunaTipo(this);'", "aColunaTmp[{$id_idioma}][tipo1][]");
                        } else {
                            echo AtividadeColunaAction::getComboBoxForTipo1(null, ($tabindex++), "-Selecione-", "onchange='AtividadeColunaTipo(this);'", 'aColunaTmp_tipo1');
                        }
                        ?>
                    </label>
                </section>
                <section class="col col-md-6" id="tipos">
                    <div id="div-TEX" class="escondeTipo" style="<?php echo $oColuna["coluna"]["tipo1"] == "TEX" ? "" : "display:none;" ?>" >
                        <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Texto</label>
                        <label class="input">
                            <?php if ($oColuna) { ?>
                                <textarea class="form-control" name="aColunaTmp[<?php echo $id_idioma ?>][TEX1][]" /><?php echo $oColuna["coluna"]["coluna1Text"] ?></textarea>
                            <?php } else { ?>
                                <textarea id="aColunaTmp_TEX1" class="form-control" /></textarea>
                            <?php } ?>
                        </label>
                    </div>
                    <div id="div-IMG" class="escondeTipo" style="<?php echo $oColuna["coluna"]["tipo1"] == "IMG" ? "" : "display:none;" ?>" >
                        <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Imagem</label>                        
                        <?php if ($oColuna) { ?>
                            <label class="input">
                                <input type="file" class="form-control" name="aColunaTmp[<?php echo $id_idioma ?>][IMG1][]" />
                            </label>
                            <?php
                            $file = $oColuna["arquivo"][1];
                            if (isset($file)) {
                                $oArquivo = $file;
                                echo "<a target='_blank' href='" . URL_APP . $this->module . "/Atividade/conteudoDownload/{$file["id"]}?classe=AtividadeColunaArquivo" . "'>{$oArquivo["nome"]}</a>";
                            }
                            ?>
                            <input type="hidden" name="aColunaTmp[<?php echo $id_idioma ?>][IMG1ID][]" value="<?php echo isset($file["id"]) ? $file["id"] : 0 ?>">
                        <?php } else { ?>
                            <label class="input">
                                <input type="file" id="aColunaTmp_IMG1" class="form-control" />
                            </label>
                        <?php } ?>
                    </div>
                    <div id="div-VID" class="escondeTipo" style="<?php echo $oColuna["coluna"]["tipo1"] == "VID" ? "" : "display:none;" ?>" >
                        <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Vídeo</label>                        
                        <?php if ($oColuna) { ?>
                            <label class="input">
                                <input type="file" class="form-control" name="aColunaTmp[<?php echo $id_idioma ?>][VID1][]" />
                            </label>
                            <?php
                            $file = $oColuna["arquivo"][1];
                            if (isset($file)) {
                                $oArquivo = $file;
                                echo "<a target='_blank' href='" . URL_APP . $this->module . "/Atividade/conteudoDownload/{$file["id"]}?classe=AtividadeColunaArquivo" . "'>{$oArquivo["nome"]}</a>";
                            }
                            ?>
                            <input type="hidden" name="aColunaTmp[<?php echo $id_idioma ?>][VID1ID][]" value="<?php echo isset($file["id"]) ? $file["id"] : 0 ?>">
                        <?php } else { ?>
                            <label class="input">
                                <input type="file" id="aColunaTmp_VID1" class="form-control" />
                            </label>
                        <?php } ?>
                    </div>
                </section>
            </fieldset>
        </section>
        <section class="col col-md-6">
            <fieldset>
                <legend>Coluna B</legend>
                <section class="col col-md-6">
                    <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Tipo</label>
                    <label class="input">
                        <?php
                        if ($oColuna) {
                            echo AtividadeColunaAction::getComboBoxForTipo2($oColuna["coluna"]["tipo2"], ($tabindex++), "-Selecione-", "onchange='AtividadeColunaTipo(this);'", "aColunaTmp[{$id_idioma}][tipo2][]");
                        } else {
                            echo AtividadeColunaAction::getComboBoxForTipo2(null, ($tabindex++), "-Selecione-", "onchange='AtividadeColunaTipo(this);'", 'aColunaTmp_tipo2');
                        }
                        ?>
                    </label>
                </section>
                <section class="col col-md-6" id="tipos">
                    <div id="div-TEX" class="escondeTipo" style="<?php echo $oColuna["coluna"]["tipo2"] == "TEX" ? "" : "display:none;" ?>" >
                        <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Texto</label>
                        <label class="input">
                            <?php if ($oColuna) { ?>
                                <textarea class="form-control" name="aColunaTmp[<?php echo $id_idioma ?>][TEX2][]" /><?php echo $oColuna["coluna"]["coluna2Text"] ?></textarea>
                            <?php } else { ?>
                                <textarea id="aColunaTmp_TEX2" class="form-control" /></textarea>
                            <?php } ?>
                        </label>
                    </div>
                    <div id="div-IMG" class="escondeTipo" style="<?php echo $oColuna["coluna"]["tipo2"] == "IMG" ? "" : "display:none;" ?>" >
                        <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Imagem</label>
                        <?php if ($oColuna) { ?>
                            <label class="input">
                                <input type="file" class="form-control" name="aColunaTmp[<?php echo $id_idioma ?>][IMG2][]" />
                            </label>
                            <?php
                            $file = $oColuna["arquivo"][2];
                            if (isset($file)) {
                                $oArquivo = $file;
                                echo "<a target='_blank' href='" . URL_APP . $this->module . "/Atividade/conteudoDownload/{$file["id"]}?classe=AtividadeColunaArquivo" . "'>{$oArquivo["nome"]}</a>";
                            }
                            ?>
                            <input type="hidden" name="aColunaTmp[<?php echo $id_idioma ?>][IMG2ID][]" value="<?php echo isset($file["id"]) ? $file["id"] : 0 ?>">
                        <?php } else { ?>
                            <label class="input">
                                <input type="file" id="aColunaTmp_IMG2" class="form-control" />
                            </label>
                        <?php } ?>
                    </div>
                    <div id="div-VID" class="escondeTipo" style="<?php echo $oColuna["coluna"]["tipo2"] == "VID" ? "" : "display:none;" ?>" >
                        <label class="label"><?php echo CAMPO_OBRIGATORIO ?> Vídeo</label>
                        <?php if ($oColuna) { ?>
                            <label class="input">
                                <input type="file" class="form-control" name="aColunaTmp[<?php echo $id_idioma ?>][VID2][]" />
                            </label>
                            <?php
                            $file = $oColuna["arquivo"][2];
                            if (isset($file)) {
                                $oArquivo = $file;
                                echo "<a target='_blank' href='" . URL_APP . $this->module . "/Atividade/conteudoDownload/{$file["id"]}?classe=AtividadeColunaArquivo" . "'>{$oArquivo["nome"]}</a>";
                            }
                            ?>
                            <input type="hidden" name="aColunaTmp[<?php echo $id_idioma ?>][VID2ID][]" value="<?php echo isset($file["id"]) ? $file["id"] : 0 ?>">
                        <?php } else { ?>
                            <label class="input">
                                <input type="file" id="aColunaTmp_VID2" class="form-control" />
                            </label>
                        <?php } ?>
                    </div>
                </section>
            </fieldset>
        </section>            
    </div>
</div>