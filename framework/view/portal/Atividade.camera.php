<div id="my_camera"></div>
<style type="text/css">
    .btn-camera {
        width: 46px;
        height: 46px;
        border-radius: 30px;
    }

</style>
<script language="JavaScript">
    Webcam.set({
        width: 300,
        height: 220,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#my_camera');
</script>

<!-- A button for taking snaps -->
<div id='botao' class="controle-microfone d-flex justify-content-around">
    <button class="btn btn-default btn-camera" type=button onClick="take_snapshot()"><i class="fa fa-camera"></i></button>
</div>
<div id="results">
    <?php
    $oAlunoAtividade = $response->get("oAlunoAtividade");
    if ($oAlunoAtividade) {
        ?>
        <strong>Foto atual: </strong><br> 
        <?php
        echo '<img class="img-fluid" src="data:' . $oAlunoAtividade->getTipo() . ';base64,' . base64_encode($oAlunoAtividade->getArquivo()) . '" />';
    }
    ?>
</div>
<div id="note">

</div>


<!-- Code to handle taking the snapshot and displaying it locally -->
<script language="JavaScript">
    function take_snapshot() {
        // take snapshot and get image data
        data_uri_ext = '';
        Webcam.snap(function (data_uri) {
            data_uri_ext = data_uri;
            // display results in page
            document.getElementById('results').innerHTML =
                    '<h4>Esta é sua foto</h4>' +
                    '<img src="' + data_uri + '"/>';
        });
        var tipoAtividade = "<?= $oAtividade->getTipo() ?>";
        var url_processa = "<?= URL ?>" + "?action=Atividade.processaGravacao&tipo=" + tipoAtividade + "&id_atividade=" + <?php echo $oAtividade->getId(); ?> + "&fname=photo.jpeg";

        let emocao = "";

        Webcam.upload(data_uri_ext, url_processa, function (code, text) {
            var json = JSON.parse(text);
            alert(json);
            switch (json.emotionDetection) {
                case 'angry':
                    emocao = '😡';
                    break;
                case 'happiness':
                    emocao = '😁';
                    break;
                case 'sadness':
                    emocao = '😥';
                    break;
                case 'surprised':
                    emocao = '😱';
                    break;
            }

            note.innerHTML = "";
            var scoreLabel = document.createElement('div');
            scoreLabel.innerHTML = 'Emoção: ' + text.emotionDetection + "<br>" + emocao;
            note.appendChild(scoreLabel);
        });
    }
</script>