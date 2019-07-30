<div id="div-opcao" class="remover_div" style="<?php echo $o && $o->getTipo() == 'PRC' ? '' : 'display: none' ?>">
    <header style="display: flex; justify-content: space-between; align-items: center">
        Opções
        <button onclick="AtividadeAdicionarOpcao()" type="button" class="btn btn-primary btn-sm pull-right" title="Clique para adicionar mais opção"><i class="fa fa-plus"></i></button>
    </header>
    <fieldset>
        <div id ="atividade-opcao" class="atividade-opcao">
            <div id="Atividade-opcao-model" style="display: none;">
                <div class="row">
                    <section class="col col-md-1">
                        <label class="label" for="corretaOpcao">Correta</label>
                        <label class="radio">
                            <input class="check" type="radio" name="corretaOpcao">
                            <i></i>
                        </label>
                    </section>

                    <section class="col col-md-5">
                        <label class="label" for="valorOpcao">Valor</label>
                        <label class="input">
                            <input class="form-control" type="text" id="titulo" name="valorOpcao[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                        </label>
                    </section>

                    <section class="col col-md-4">
                        <label class="label" for="valorFoneticoOpcao">Valor Fonético</label>
                        <label class="input">
                            <input class="form-control" type="text" id="titulo" name="valorFoneticoOpcao[]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                        </label>
                    </section>

                    <section class="col col-md-2">
                        <label class="label">&nbsp;</label>
                        <div class="input input-file">
                            <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
                        </div>
                    </section>
                </div>
            </div>
            <div id="Atividade-opcao-append">
                <?php
                $aOpcao = $response->get('aOpcao');
                if ($aOpcao) {
                    foreach ($aOpcao as $key => $oOpcao) {
                        ?>
                        <div class="row">
                            <section class="col col-md-1">
                                <label class="label" for="corretaOpcao">Correta</label>
                                <label class="radio">
                                    <input type="radio" name="corretaOpcao" <?php echo $oOpcao->getCorreta() == 'S' ? 'checked' : '' ?> value="<?php echo $oOpcao->getId() ?>">
                                    <i></i>
                                </label>
                            </section>

                            <section class="col col-md-5">
                                <label class="label" for="valorOpcao">Valor</label>
                                <label class="input">
                                    <input class="form-control" type="text" value="<?php echo $oOpcao->getValor(); ?>" id="valor" name="valorOpcaoEdit[<?php echo $oOpcao->getId(); ?>]" maxlength='50' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>

                            <section class="col col-md-4">
                                <label class="label" for="valorFoneticoOpcao">Valor Fonético</label>
                                <label class="input">
                                    <input class="form-control valorOpcao" type="text" value="<?php echo $oOpcao->getValorFonetico(); ?>" id="valorFonetico" name="valorFoneticoOpcaoEdit[<?php echo $oOpcao->getId(); ?>]" maxlength='100' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                </label>
                            </section>

                            <section class="col col-md-2">
                                <label class="label">&nbsp;</label>
                                <div class="input input-file">
                                    <button class="btn btn-danger btn-sm" onclick="$(this).closest('div.row').remove();"><i class="fa fa-trash"></i></button>
                                </div>
                            </section>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </fieldset>
</div>