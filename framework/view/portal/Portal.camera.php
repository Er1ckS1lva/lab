<head>
    <style>
        #fotos div {
            position: relative;
            float: left;
            width: 180px;
            padding: 5px;
        }

        .topright {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 13px;
            cursor: pointer;
            background: 0 0;
            border: 0;
            background-color: rgba(60, 60, 60, 0.09);
        }

        .topright:focus, .topright:hover {
            background-color: rgba(60, 60, 60, 0.4);
            text-decoration: none;
            cursor: pointer;
        }

        .my-span {
            color: #d21414a3;
        }

        .img-photo { 
            width: 100%;
            height: auto;
        }
    </style>

<div class="camera-portal">
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
    <div id='botao' class="controle-microfone" style="padding-top: 3px;">
        <button class="btn btn-default btn-camera" type=button onclick="take_snapshot()"><i class="fa fa-camera"></i></button>
    </div>
</div>
<div id="results">
    <strong><?php echo str_replace("%TOTAL%", "5", Lang::CONTA_fotosNecessarias) ?>: </strong><br> 
    <div id='fotos'></div>
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
            var count = $('[name^="afoto[]"]').length;

            if (count < 5) {
                var blobReal = data_uri_ext;

                var block = blobReal.split(";");
// Get the content type of the image
                var contentType = block[0].split(":")[1];// In this case "image/gif"
// get the real base64 content of the file
                var realData = block[1].split(",")[1];

                var blob = b64toBlob(realData, contentType);

                var file = new File([blob], 'foto.jpeg', {type: 'image/jpeg'});

                var input = document.createElement("INPUT");
                input.id = 'pre_' + count;
                input.type = 'file';
                input.files = createFileList(file);
                input.name = 'afotoUpload[]';
                input.hidden = true;

                var myContainer = document.getElementById("fotos");
                myContainer.appendChild(input);

                $("#fotos").append('<div class="pre_' + count + '">' +
                        '<img class="img-photo" name="afoto[]" src="' + data_uri + '" width="1000" height="300">' +
                        $(input).html() +
                        '<button onclick="$(this).parent().closest(\'div\').remove(); excluiFotoReload($(this))" class="topright"><i class="fa fa-times my-span" aria-hidden="true"></i></button>' +
                        '</div>');
            } else {
                alert('Máximo de fotos atingido!');
            }
        });
    }

    function createFileList(a) {
        a = [].slice.call(Array.isArray(a) ? a : arguments);
        for (var c, b = c = a.length, d = !0; b-- && d; )
            d = a[b] instanceof File;
        if (!d)
            throw new TypeError('<?php echo Lang::ATIVIDADE_cameraError ?>');
        for (b = (new ClipboardEvent('')).clipboardData || new DataTransfer; c--; )
            b.items.add(a[c]);
        return b.files;
    }

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }


</script>