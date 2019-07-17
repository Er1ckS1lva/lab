<h3><?php echo Lang::ATIVIDADE_recursoGravador?></h3>
<style type="text/css">
    .btn-micro {
        width: 46px;
        height: 46px;
        border-radius: 30px;
    }

</style>

<div id='botao' class="controle-microfone d-flex justify-content-around">
    <button id='start' class="btn btn-default btn-micro"><i class="fa fa-microphone"></i></button>
</div>
<br>
<br>
<div id="recordingslist"></div>
<div class="note">
    <?php
    $oAlunoAtividade = $response->get("oAlunoAtividade");
    if ($oAlunoAtividade) {
        ?>
        <strong>Gravação atual: </strong><br> 
        <?php
        echo '<audio controls="controls" preload="metadata">'
        . '<source src="data:' . $oAlunoAtividade->getTipo() . ';base64,' . base64_encode($oAlunoAtividade->getArquivo()) . '">'
        . '</audio>';
    }
    ?>
</div>
<br>

<script type="text/javascript" src="<?= URL_PORTAL ?>js/opus_recorder/recorder.min.js"></script>
<script type="text/javascript">
    function screenLogger(text, data) {
        alert(text + " " + data);
    }

    if (!Recorder.isRecordingSupported()) {
        screenLogger("<?php echo Lang::ATIVIDADE_recursoGravacao ?>");
    } else {
        start.disabled = false;
        var recorder = new Recorder({
            monitorGain: 0,
            recordingGain: 1,
            numberOfChannels: 1,
            wavBitDepth: 16,
            encoderPath: URL_PORTAL + "js/opus_recorder/waveWorker.min.js"
        });


        start.addEventListener("click", function _comece() {
            recorder.start().catch(function (e) {
                screenLogger('<?php echo ATIVIDADE_recursoErro ?> ', e.message);
            });
        });

        recorder.onstart = function () {
            botao.innerHTML = '<button id="stopButton" class="btn btn-default btn-micro"><i class="fa fa-stop"></i></button>';
            stopButton.addEventListener("click", function () {
                recorder.stop();
            });
        };

        recorder.onstop = function () {
            botao.innerHTML = '<button id="start" class="btn btn-default btn-micro"><i class="fa fa-microphone"></i></button>';
            start.addEventListener("click", function () {
                recorder.start().catch(function (e) {
                    screenLogger('<?php echo ATIVIDADE_recursoErro ?> ', e.message);
                });
            });
        };

        recorder.onstreamerror = function (e) {
            screenLogger('<?php echo ATIVIDADE_recursoErro ?> ' + e.message);
        };
        recorder.ondataavailable = function (typedArray) {
            var tipoAtividade = "<?= $oAtividade->getTipo() ?>";
            var dataBlob = new Blob([typedArray], {type: 'audio/wav'});
            var fileName = new Date().toISOString() + ".wav";
            var url = window.URL.createObjectURL(dataBlob);

            var fd = new FormData();
            fd.append('fname', 'audio.wav');
            fd.append('data', dataBlob);
            fd.append('id_atividade', "<?php echo $oAtividade->getId(); ?>");
            $.ajax({
                url: "<?= URL ?>" + "?action=Atividade.processaGravacao&tipo=" + tipoAtividade,
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function (json) {
                    URL = "<?= URL ?>";
                    recordingslist.innerHTML = "";

                    var audio = document.createElement('audio');
                    audio.controls = true;
                    audio.src = url;
                    var div = document.createElement('div');
                    div.appendChild(audio);
                    var scoreLabel = document.createElement('div');
                    let emocao = "";
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
                    scoreLabel.innerHTML = '<?php echo Lang::ATIVIDADE_audioEmotion ?>: ' + json.emotionDetection + "<br>" + emocao;
                    div.appendChild(scoreLabel);
                    if (tipoAtividade == "EMO") {
                    } else {
                        var scoreLabel = document.createElement('div');
                        scoreLabel.innerHTML = '<?php echo Lang::ATIVIDADE_audioScore ?>: ' + json.score;

                        var transcriLabel = document.createElement('div');
                        transcriLabel.innerHTML = '<?php echo Lang::ATIVIDADE_audioTranscricao ?>: ' + json.transcricao;

                        var msgLabel = document.createElement('div');
                        if (json.mensagem != '') {
                            msgLabel.innerHTML = '<?php echo Lang::ATIVIDADE_audioMensagem ?>: ' + json.mensagem;
                        }
                        div.appendChild(scoreLabel);
                        div.appendChild(transcriLabel);
                        div.appendChild(msgLabel);
                    }

                    recordingslist.appendChild(div);
                },
                error: function () {
                    alert("<?php echo Lang::ATIVIDADE_recursoErroAudio ?>");
                }
            });
        };
    }

</script>
