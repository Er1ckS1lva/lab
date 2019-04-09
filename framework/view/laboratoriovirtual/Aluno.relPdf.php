<?
if ($response->get("total") == 0) {
    include IGENIAL_DIR_BIBVIEW . '/empty.php';
} else {
    $objects = $response->get("objects");
    ?>
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                <h2>Alunos</h2>
            </header>
            <div>
                <!-- widget content -->
                <div class="widget-body no-padding">
                    <form id="resultados" method="post" autocomplete="off" enctype='multipart/form-data' >
                        <table class="table table-bordered table-striped with-check table-hover">
                            <thead>
                                <tr>
                                    <th><a href="?order=nome<?= $allFilters ?>">Nome</a></th>
<th><a href="?order=email<?= $allFilters ?>">Email</a></th>
<th><a href="?order=senha<?= $allFilters ?>">Senha</a></th>
<th><a href="?order=dtCadastro<?= $allFilters ?>">Data de Cadastro</a></th>
<th><a href="?order=recuperaSenhaData<?= $allFilters ?>">Data de recuperação de senha</a></th>
<th><a href="?order=recuperaSenhaHash<?= $allFilters ?>">Hash de recuperaração senha</a></th>
<th><a href="?order=criarContaHash<?= $allFilters ?>">Hash de criação de conta</a></th>
<th><a href="?order=ativo<?= $allFilters ?>">Ativo</a></th>
<th><a href="?order=login<?= $allFilters ?>">Login</a></th>
<th><a href="?order=aceiteTermo<?= $allFilters ?>">Aceite Termo</a></th>
<th><a href="?order=dataNascimento<?= $allFilters ?>">Data de Nascimento</a></th>
<th><a href="?order=sexo<?= $allFilters ?>">Sexo</a></th>
<th><a href="?order=moderado<?= $allFilters ?>">Moderado</a></th>
<th><a href="?order=cpf<?= $allFilters ?>">CPF</a></th>
<th><a href="?order=cidade<?= $allFilters ?>">Cidade</a></th>
<th><a href="?order=estado<?= $allFilters ?>">Estado</a></th>
<th><a href="?order=nacionalidade<?= $allFilters ?>">Nacionalidade</a></th>
<th><a href="?order=instituicaoEnsino<?= $allFilters ?>">Instituição de Ensino</a></th>
<th><a href="?order=curso<?= $allFilters ?>">Curso</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach ($objects as $o) { ?>
                                    <tr>
                                        <td><?=$o->getNome()?></td>
<td><?=$o->getEmail()?></td>
<td><?=$o->getSenha()?></td>
<td><?=Util::convertDataOut($o->getDtCadastro(),1)?></td>
<td><?=Util::convertDataOut($o->getRecuperaSenhaData(),1)?></td>
<td><?=$o->getRecuperaSenhaHash()?></td>
<td><?=$o->getCriarContaHash()?></td>
<td><?= AlunoAction::getValueForAtivo($o->getAtivo()); ?></td>
<td><?=$o->getLogin()?></td>
<td><?= AlunoAction::getValueForAceiteTermo($o->getAceiteTermo()); ?></td>
<td><?=Util::convertDataOut($o->getDataNascimento())?></td>
<td><?= AlunoAction::getValueForSexo($o->getSexo()); ?></td>
<td><?= AlunoAction::getValueForModerado($o->getModerado()); ?></td>
<td><?=$o->getCpf()?></td>
<td><?=$o->getCidade()?></td>
<td><?=$o->getEstado()?></td>
<td><?=$o->getNacionalidade()?></td>
<td><?=$o->getInstituicaoEnsino()?></td>
<td><?=$o->getCurso()?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>							

                    </form>
                </div>
            </div>
        </div>
    </article>
    <?
}?>