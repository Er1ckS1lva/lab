<div class="modal" id="apresentacao" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Lang::GERAL_apresentacao ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                    <!--                    <li class="nav-item">
                                            <a class="nav-link active" id="pills-pt-tab" data-toggle="pill" href="#pills-pt" role="tab" aria-controls="pills-pt" aria-selected="true">Português</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-en-tab" data-toggle="pill" href="#pills-en" role="tab" aria-controls="pills-en" aria-selected="false">English</a>
                                        </li>-->

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-pt" role="tabpanel" aria-labelledby="pills-pt-tab">
                        <div class="text-center">
                            <?php
                            echo $oLaboratorio->getDescricao();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo Lang::GERAL_fechar ?></button>
            </div>
        </div>
    </div>
</div>

