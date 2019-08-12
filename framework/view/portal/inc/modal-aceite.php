<div class="modal" id="aceite" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Lang::GERAL_aceite ?></h5>
                <button type="button" id="noaceite" class="close" onclick="aceitaTermo(this); return false" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="aceite-modal-body" style="height: 400px; overflow-y: auto;">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-pt" role="tabpanel" aria-labelledby="pills-pt-tab">
                        <div class="text-center" style="margin: 30px;">
                            <?php
                            echo $oLaboratorio->getTermoUso();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="aceite" class="btn btn-primary" onclick="aceitaTermo(this); return false"><?php echo Lang::GERAL_aceite ?></button>
                <button type="button" id="noaceite" class="btn btn-secondary" data-dismiss="modal" onclick="aceitaTermo(this); return false"><?php echo Lang::GERAL_desaceite ?></button>
            </div>
        </div>
    </div>
</div>