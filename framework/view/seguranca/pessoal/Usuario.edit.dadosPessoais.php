<? $o = $response->get("object"); ?>

<!-- para js -->
<script type="text/javascript" src="<?= URL ?>framework/view/seguranca/js/Usuario.js"></script>

<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-user"></i> </span>
            <h2>Meus dados</h2>
        </header>
        <div>
            <!-- CONTEUDO DO WIDGET-->
            <div class="widget-body no-padding">
                <form class="smart-form" method="post" action="<?= URL ?>index.php?action=Usuario.dadosPessoaisSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
                    <header>
                        Preencha os campos
                    </header>
                    <fieldset>
						<div class="row">
							<section class="col col-6">
								<label class="label" for="nome">Nome</label>
								<label class="input">
									<input class="form-control"  type="text" id="nome" name="nome" maxlength='45' mask='' validate='S' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getNome()) ?>'/>
								</label>
							</section>
							<section class="col col-6">
								<label class="label" for="email">Email</label>
								<label class="input">
									<input class="form-control"  type="text" id="email" name="email" maxlength='200' mask='' validate='S' tabindex='<?= ( ++$tabindex) ?>' value='<?= ($o->getEmail()) ?>'/>
								</label>
							</section>
						</div>
						
                        <section>
                            <label class="label" for="foto">Foto</label>
                            <label class="input">
                                <?= InterfaceHTML::imageCrop("foto", "Usuario/foto", ( ++$tabindex), "4/4", "160", "160", "{$o->getId()}_t") ?>
                            </label>
                        </section>
                    </fieldset>
                    <footer>
                        <button class="btn btn-primary" onclick="UsuarioEditAlertHandler(this, false);" tabindex="<?= ++$tabindex ?>" ><i class="fa fa-check fa-white"></i> Salvar Alterações</button>
                    </footer>
                </form>
            </div>
        </div>
    </div>
</article>