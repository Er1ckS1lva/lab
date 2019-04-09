<div class="modal-body">
    <div class="row">
        <div class="col-lg-8" style="text-align: center">
            <h2>Original</h2>
            <img src="<?= URL ?>index.php?action=Crop.imagem" id="crop" alt=""/>
        </div>
        <div class="col-lg-4">
            <h2>Miniatura</h2>
            <center>
                <div style="width:<?= ($response->get("minWidth")) ?>px;height:<?= ($response->get("minHeight")) ?>px;overflow:hidden;" id="divPreview">
                    <img id="CropImagemPreview" src="<?= URL ?>index.php?action=Crop.imagem" style=""/>
                </div>
            </center>
        </div>
    </div>
    <input type="hidden" id="width" value="<?= $response->get('width') ?>"/>
    <input type="hidden" id="height" value="<?= $response->get('height') ?>"/>

    <input type="hidden" id="minWidth" value="<?= $response->get('minWidth') ?>"/>
    <input type="hidden" id="minHeight" value="<?= $response->get('minHeight') ?>"/>
</div>

<div class="modal-footer">
    <input class="btn btn-default" type="button" value="Finalizar Corte" onclick="validaCrop('<?= ($response->get("fieldName")) ?>')"/>
</div>