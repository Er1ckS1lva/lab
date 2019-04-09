<div class="btn-toolbar sw-toolbar sw-toolbar-top justify-content-end bloco-botao">
    <div class="btn-group mr-2 sw-btn-group" role="group">
        <a class="btn btn-info" href="<?php echo URL ?>"><i class="fa fa-home"></i> Home</a>
    </div>
    <div class="btn-group mr-2 sw-btn-group" role="group">
        <a class="btn btn-secondary sw-btn-prev btnPrevious <?php echo $key == 0 ? 'disabled' : '' ?>" 
           href="<?php echo $key == 0 ?: URL . 'atividade/' . $oAtividade->getTema()->getId() . '?idAtividade=' . $aAtividade[$key - 1]->getId(); ?>" type="button">
            <i class="fa fa-angle-double-left"></i> Previous
        </a>
        <a class="btn btn-secondary sw-btn-next btnNext <?php echo $key == $qtd_ativi ? 'disabled' : '' ?> " 
           href="<?php echo $key == $qtd_ativi ?: URL . 'atividade/' . $oAtividade->getTema()->getId() . '?idAtividade=' . $aAtividade[$key + 1]->getId(); ?>" type="button">
            Next <i class="fa fa-angle-double-right"></i>
        </a>
    </div>
<!--    <div class="btn-group mr-2 sw-btn-group-extra" role="group">
        <a class="btn btn-info" href="<?php echo URL . 'atividade/' . $oAtividade->getTema()->getId() ?>">Finish</a>
    </div>-->
</div>