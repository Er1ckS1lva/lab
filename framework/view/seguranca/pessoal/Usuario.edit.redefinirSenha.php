<? $o = $response->get("object"); ?>

<!-- para js -->
<script type="text/javascript" src="<?= URL ?>framework/view/seguranca/js/Usuario.js"></script>

<div class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
			<header>
				<span class="widget-icon"> <i class="fa fa-lock"></i> </span>
				<h2>Redefinir senha</h2>
			</header>
			<div>
				<!-- CONTEUDO DO WIDGET-->
				<div class="widget-body no-padding">
					<form class="smart-form" method="post" action="<?= URL ?>index.php?action=Usuario.redefinirSenhaSubmit" id="frm" name="frm" onsubmit="return false;" autocomplete="off" enctype='multipart/form-data' >
						<header>
							Preencha os campos
						</header>
						<fieldset>
							<section>
                                <label class="label" for="">Usuário</label>
                                <label class="input">
                                    <?= $o->getLogin() ?> (<?= $o->getNome() ?>)
                                    <input type="hidden" name="id" value='<?= $o->getId() ?>'/>
                                </label>
                            </section>
							<section>
								<label class="label" for="novaSenha">Nova Senha</label>
								<label class="input">
									<input class="form-control" type="password" id="novaSenha" name="novaSenha" maxlength='200' mask='' validate='S' tabindex='' value=''/>
								</label>
							</section>
							<section>
								<label class="label" for="novaSenhaConf">Repita a Nova Senha</label>
								<label class="input">
									<input class="form-control" type="password" id="novaSenhaConf" name="novaSenhaConf" maxlength='200' mask='' validate='S' tabindex='' value=''/>
								</label>
							</section>
						</fieldset>
						<footer>
							<button class="btn btn-primary" onclick="UsuarioEditAlertHandler(this, false);" tabindex="" ><i class="fa fa-check fa-white"></i> Salvar Alterações</button>
						</footer>
					</form>
				</div>
			</div>
		</div>
	</article>
</div>