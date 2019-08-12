<?php
$aAtividadeIdPaginador = $response->get("aAtividadeIdPaginador");
$qtd_paginador = count($aAtividadeIdPaginador) - 1;
$paginador = array_search($idAtividade, $aAtividadeIdPaginador);
//Util::Debug($aAtividadeIdPaginador, false);
//Util::Debug($paginador, false);
?>

<div class="btn-toolbar sw-toolbar sw-toolbar-top justify-content-end bloco-botao">
    <div class="btn-group mr-2 sw-btn-group" role="group">
        <a class="btn btn-info" href="<?php echo URL ?>"><i class="fa fa-home"></i> <?php echo Lang::ATIVIDADE_home ?></a>
    </div>
    <div class="btn-group mr-2 sw-btn-group" role="group">
        <a class="btn btn-secondary sw-btn-prev btnPrevious <?php echo $paginador == 0 ? 'disabled' : '' ?>" 
           href="<?php echo $paginador == 0 ?: URL . 'atividade/' . $oTema->getId() . '?idAtividade=' . $aAtividadeIdPaginador[$paginador - 1] ?>" type="button">
            <i class="fa fa-angle-double-left"></i> <?php echo Lang::ATIVIDADE_anterior ?>
        </a>
        <a class="btn btn-secondary sw-btn-next btnNext <?php echo $paginador == $qtd_paginador ? 'disabled' : '' ?> " 
           href="<?php echo $paginador == $qtd_paginador ?: URL . 'atividade/' . $oTema->getId() . '?idAtividade=' . $aAtividadeIdPaginador[$paginador + 1] ?>" type="button">
            <?php echo Lang::ATIVIDADE_posterior ?> <i class="fa fa-angle-double-right"></i>
        </a>
    </div>
    <!--    <div class="btn-group mr-2 sw-btn-group-extra" role="group">
            <a class="btn btn-info" href="<?php echo URL . 'atividade/' . $oTema->getId() ?>">Finish</a>
        </div>-->
</div>