
function validaCrop(fieldName) {
    if (
            $('#x' + fieldName).val() != '' && $('#y' + fieldName).val() != '' &&
            $('#h' + fieldName).val() != '' && $('#w' + fieldName).val() != ''
            ) {
        $('#cropModal').modal('hide');
        return true;
    } else {
        eqDialog("Você precisa selecionar uma área na imagem para continuar!", "Atenção");
        return false;
    }
}


function CropClearCoords(fieldName) {
    $('#x' + fieldName).val(null);
    $('#y' + fieldName).val(null);
    $('#w' + fieldName).val(null);
    $('#h' + fieldName).val(null);
}

function CropImgSendHandler(elemento, aspectRatio, minWidth, minHeight) {
    if (aspectRatio == null) {
        aspectRatio = 4 / 3;
    }
    if (minWidth == null) {
        minWidth = 100;
    }
    if (minHeight == null) {
        minHeight = 100;
    }
    var fieldName = $(elemento).attr('name');
    var form = elemento.form;
    CropClearCoords(fieldName);
    var options = {
        url: URL + 'index.php?action=Crop.enviaImagem&minWidth=' + minWidth + '&minHeight=' + minHeight + '&fieldName=' + fieldName,
        target: '#cropModalBody',
        type: "POST",
        beforeSubmit: function() {
            $('#cropModalBody').html('<div class="modal-body"><i class="icon-camera"></i>&nbsp;Aguarde enquanto processamos sua imagem.</div>');
            $('#cropModal').modal('show');
        },
        success: function(serverResponse) {
            $('#cropModalBody').html(serverResponse);
            $('#crop').Jcrop({
                aspectRatio: aspectRatio,
                onChange: function (coord) {
                    $('#x' + fieldName).val(coord.x);
                    $('#y' + fieldName).val(coord.y);
                    $('#w' + fieldName).val(coord.w);
                    $('#h' + fieldName).val(coord.h);

                    if (parseInt(coord.w) > 0) {
                        var rx = $('#minWidth').val() / coord.w;
                        var ry = $('#minHeight').val() / coord.h;
                        jQuery('#CropImagemPreview').css({
                            width: Math.round(rx * $('#width').val()) + 'px',
                            height: Math.round(ry * $('#height').val()) + 'px',
                            marginLeft: '-' + Math.round(rx * coord.x) + 'px',
                            marginTop: '-' + Math.round(ry * coord.y) + 'px'
                        });
                    }
                },
                onSelect: function (coord) {
                    $('#x' + fieldName).val(coord.x);
                    $('#y' + fieldName).val(coord.y);
                    $('#w' + fieldName).val(coord.w);
                    $('#h' + fieldName).val(coord.h);

                    if (parseInt(coord.w) > 0) {
                        var rx = $('#minWidth').val() / coord.w;
                        var ry = $('#minHeight').val() / coord.h;
                        jQuery('#CropImagemPreview').css({
                            width: Math.round(rx * $('#width').val()) + 'px',
                            height: Math.round(ry * $('#height').val()) + 'px',
                            marginLeft: '-' + Math.round(rx * coord.x) + 'px',
                            marginTop: '-' + Math.round(ry * coord.y) + 'px'
                        });
                    }
                },
                minSize: [minWidth, minHeight],
                allowMove: true
            });
        },
        error: function() {
            alert("erro inesperado");
        }
    };
    $(form).ajaxSubmit(options);
}