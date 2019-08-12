<? $o = $response->get("object"); ?>
<div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-file-text-o"></i> </span>
                <h2>Tema</h2>
            </header>
            <div>
                <!-- CONTEUDO DO WIDGET-->
                <div class="widget-body no-padding">
                    <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Tema.editSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                        <header>
                            Geral
                        </header>
                        <fieldset>
                            <input type="hidden" id="id" name="id" value='<?= ($o->getId()) ?>'/>
                            <section>
                                <label class="label" for="Laboratorio">Laboratório</label>
                                <label class="input">
                                    <suggest id='Laboratorio' entity='Laboratorio' hasComboBox='true' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getLaboratorio()->getId()) ?>' />
                                </label>
                            </section>


                            <section>
                                <label class="label" for="titulo">Título</label>
                                <label class="input">
                                    <input class="form-control"  type="text" id="titulo" name="titulo" maxlength='45' mask='' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getTitulo()) ?>'/>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="descricao">Descrição</label>
                                <label class="input">
                                    <textarea class="ckeditor" id="descricao" name="descricao" tabindex='<?= ( ++$tabindex) ?>'><?= ($o->getDescricao()) ?></textarea>
                                </label>
                            </section>


                            <section>
                                <label class="label" for="">Imagem de Capa</label>
                                <label class="input">
                                    <div class="input input-file">
                                        <span class="button">
                                            <input type="file" id="file" name="imagemCapa"  onchange="$(this).closest('span.button').next('input').val(this.value);" tabindex='<?= ( ++$tabindex) ?>' />
                                            Selecionar
                                        </span>
                                        <input type="text" placeholder="Selecione a imagem" readonly="">
                                    </div>
                                </label>
                            </section>
                            <section>
                                <div>
                                    <?php if ($o->getImagemCapa() != '') { ?>
                                        <button type="button" class="btn btn-link" onclick="$('#img').slideToggle();">
                                            <i class="fa fa-picture-o"></i> Exibir/Ocultar imagem</button>
                                        <div id="img" style="display: none;">
                                            <img class="img-responsive" src="<?= MediaUtil::getLinkForFileNameById("Tema/imagemCapa", $o->getId()) ?>" />
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>


                            <section>
                                <label class="label" for="videoApresentacao">Video de Apresentação (somente mp4 de até <?php echo ini_get('upload_max_filesize');?>B)</label>
                                <label class="input">
                                    <div class="input input-file">
                                        <span class="button">
                                            <input type="file" id="videoApresentacao" name="videoApresentacao"  onchange="$(this).closest('span.button').next('input').val(this.value);" tabindex='<?= ( ++$tabindex) ?>' />
                                            Selecionar
                                        </span>
                                        <input type="text" placeholder="Selecione o vídeo" readonly="">
                                    </div>
                                </label>
                            </section>
                            <section>
                                <div>
                                    <?php if ($video = MediaUtil::getLinkForFileNameById("Tema/videoApresentacao", $o->getId())) { ?>
                                        <button type="button" class="btn btn-link" onclick="$('#video').slideToggle();">
                                            <i class="fa fa-video-camera"></i> Exibir/Ocultar vídeo salvo
                                        </button>
                                        <?= $video == "javascript: void(0);" ? "<label class='note'>Sem vídeo salvo.</label>" : "" ?>
                                        <div id="video" style="display: none;">
                                            <?php if ($video !== "javascript: void(0);") { ?>
                                                <label class="checkbox">
                                                    <input type="checkbox" name="exclui_video" value="1" class="" />
                                                    <i></i>Excluir este vídeo
                                                </label>
                                                <br/>                                            
                                                <video controls>
                                                    <source src="<?php echo $video ?>" type="video/mp4">
                                                    <source src="<?php echo $video ?>" type="video/ogg">
                                                    Seu browser não suporta tag de vídeo
                                                </video> 
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </section>


                            <section>
                                <label class="label" for="ordem">Ordem</label>
                                <label class="input">
                                    <input class="form-control" onkeyup="formatar(this, '9999999999')" type="text" id="ordem" name="ordem" maxlength='11' mask='inteiro' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getOrdem()) ?>'/>
                                </label>
                            </section>


                        </fieldset>

                        <div class="padding-10" >
                            <?php
                            $oIdiomaAction = new IdiomaAction();
                            $aIdioma = $oIdiomaAction->collection(null, null, 'padrao ASC');
                            if ($aIdioma) {
                                ?>
                                <ul id="myTab1" class="nav nav-tabs bordered">
                                    <?php
                                    foreach ($aIdioma as $k => $oIdioma) {
                                        $active = ($k == 0) ? 'active' : '';
                                        $id_idioma = $oIdioma->getId();
                                        ?>
                                        <li class="<?php echo $active ?>">
                                            <a style="color: #000!important" href="#aba-idioma-<?php echo $oIdioma->getId() ?>" data-toggle="tab">
                                                <?php echo $oIdioma->getSigla() ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <div id="myTabContent1" class="tab-content padding-10">
                                    <?php
                                    $titulo = $descricao = "";
                                    foreach ($aIdioma as $k => $oIdioma) {
                                        $id_idioma = $oIdioma->getId();
                                        $oTemaIdiomaAction = new TemaIdiomaAction();
                                        $oTemaIdioma = $oTemaIdiomaAction->select($o->getId(), $id_idioma);
                                        if ($oTemaIdioma) {
                                            $id_idioma = "{$id_idioma}#{$o->getId()}";
                                            $titulo = $oTemaIdioma->getTitulo();
                                            $descricao = $oTemaIdioma->getDescricao();
                                        }
                                        $active = ($k == 0) ? 'active' : '';
                                        ?>
                                        <div class="tab-pane fade in <?php echo $active ?>" id="aba-idioma-<?php echo $oIdioma->getId() ?>">


                                            <? // if ($oIdioma->getPadrao() == "1") { ?>
                                            <? if (true) { ?>
                                                <?
                                                ### obrigatorio ter pelo menos o padrão
                                                $aValidateNovo = array();
                                                $aValidateNovo[] = "titulo_" . $oIdioma->getId() . "";
                                                $aValidateNovo[] = "descricao_" . $oIdioma->getId() . "";
                                                ?>
                                                <script>
                                                    $(document).ready(function () {
                                                        validateScriptTopo('<?= join(",", $aValidateNovo) ?>');
                                                    });
                                                </script>
                                            <? } ?>


                                            <input type="hidden" value="<?php echo $id_idioma ?>" name="aIdioma[]" />
                                            <fieldset>
                                                <section>
                                                    <label class="label" for="titulo">Título</label>
                                                    <label class="input">
                                                        <input class="form-control" value="<?php echo $titulo ?>" type="text" id="titulo_<?php echo $oIdioma->getId() ?>" name="aTitulo[<?php echo $id_idioma ?>]" maxlength='255' mask='' tabindex='<?= ( ++$tabindex) ?>'/>
                                                    </label>
                                                </section>

                                                <section class="conteudo-noticia conteudo-interna">
                                                    <label class="label" for="descricao">Descrição</label>
                                                    <label class="input">
                                                        <textarea class="ckeditor" id="descricao_<?php echo $oIdioma->getId() ?>" name="aDescricao[<?php echo $id_idioma ?>]" tabindex='<?= ( ++$tabindex) ?>'><?php echo $descricao ?></textarea>
                                                    </label>
                                                </section>

                                            </fieldset>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <footer>
                            <button class="btn btn-primary" onclick="TemaEditHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="icon-check icon-white"></i> Salvar</button>
                            <button class="btn btn-primary" onclick="TemaEditHandler(this, true);" tabindex="<?= ++$tabindex ?>" ><i class="icon-share icon-white"></i> Salvar e Sair</button>
                            <button class="btn btn-warning" type="reset" tabindex="<?= ++$tabindex ?>" ><i class="icon-remove-circle icon-white"></i> Limpar</button>
                            <a data-toggle="modal" href="#confirmationModal" onclick="eqConfirm('Você deseja sair sem salvar?', 'eqRedirectTimeout(URL_APP + MODULO_NAME + \'/Tema/admFilter\')');"  tabindex="<?= ++$tabindex ?>" class="btn btn-danger"><i class="icon-share-alt icon-white"></i> Sair</a>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </article>
</div>