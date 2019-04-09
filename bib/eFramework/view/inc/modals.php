<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="myCropModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="$('#cropModal').modal('hide')">&times</button>
                <h4 class="modal-title" id="cropModalTitle">Recortando a imagem</h4>
            </div>
            <div class="modal-body" id="cropModalBody">
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="pictureModal" tabindex="-1" role="dialog" aria-labelledby="myPictureModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" style="width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="$('#pictureModal').modal('hide')">&times</button>
                <h4 class="modal-title" id="pictureModalTitle">Capturando imagem</h4>
            </div>
            <div class="modal-body" id="pictureModalBody">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info"><i class="fa fa-info-circle"></i> Nota: Se a camera não estiver sendo exibida, verifique se está pedindo permissão acima.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <h4>Camera</h4>
                        <div id="camera_live" style="width:320px; height:240px;"></div>
                    </div>

                    <div class="col-lg-6 text-center">
                        <h4>Prévia</h4>
                        <div id="camera_preview" style="width:320px; height:240px;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="WebCamSnap()"><i class="fa fa-camera"></i> Capturar</button>
                <a href="javascript:void(0)" class="btn btn-alert" data-dismiss="modal" onclick="$('#pictureModal').modal('hide')">Fechar</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="deleteActionModal" tabindex="-1" role="dialog" aria-labelledby="myDeleteModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="$('#deleteActionModal').modal('hide')">&times</button>
                <h4 class="modal-title">Confirmação</h4>
            </div>
            <div class="modal-body">
                Deseja realmente excluir o registro?
                <br/>
                <small>Nota: Essa ação não pode ser desfeita.</small>
            </div>
            <div class="modal-footer">
                <span id="target-botao-excluir">
                </span>
                <a href="javascript:void(0)" class="btn btn-primary" data-dismiss="modal" onclick="$('#deleteActionModal').modal('hide')">Não</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="deleteMultipleActionModal" tabindex="-1" role="dialog" aria-labelledby="myDeleteMultipleModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#deleteMultipleActionModal').modal('hide')">&times;</button>
                <h4 class="modal-title" class="modal-title">Confirmação</h4>
            </div>
            <div class="modal-body">
                Deseja realmente excluir o(s) registro(s) selecionado(s)?
                <br/>
                <small>Nota: Essa ação não pode ser desfeita.</small>
            </div>
            <div class="modal-footer">
                <span id="target-botao-excluir-multiplos">
                </span>
                <a href="javascript:void(0)" class="btn btn-primary" data-dismiss="modal" onclick="$('#deleteMultipleActionModal').modal('hide')">Não</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="myConfirmationModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#confirmationModal').modal('hide')">&times;</button>
                <h4 class="modal-title" class="modal-title">Confirmação</h4>
            </div>
            <div class="modal-body">
                <p id="confirmationModalBody"></p>
            </div>
            <div class="modal-footer">
                <span id="target-botao-confirmacao">
                </span>
                <span id="target-botao-negacao">
                    <a href="javascript:void(0)" class="btn btn-primary" data-dismiss="modal" onclick="$('#confirmationModal').modal('hide')">Não</a>
                </span>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myInformationModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="$('#alertModal').modal('hide')">&times</button>
                <h4 class="modal-title" id="alertModalTitle">Aviso</h4>
            </div>
            <div class="modal-body">
                <p id="alertModalBody"></p>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-primary" data-dismiss="modal" onclick="$('#alertModal').modal('hide')">Ok</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="myActionModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="$('#actionModal').modal('hide')">&times</button>
                <h4 class="modal-title" id="actionModalTitle">Notificação</h4>
            </div>
            <div class="modal-body">
                <p id="actionModalBody"></p>
            </div>
            <div class="modal-footer">
                <span id="target-botao-acao">
                </span>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="loadModal" tabindex="-1" role="dialog" aria-labelledby="myLoadModal" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="loadModalTitle">Carregando...</h4>
            </div>
            <div class="modal-body" style="min-height: 120px">
                <span class="fa fa-refresh fa-spin fa-5x pull-left"></span>
                <h2>Aguarde, carregando...</h2>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->