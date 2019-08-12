/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $('.dropdown-toggle').dropdown();

    $('#apresentacao').modal();
//    $('#exampleModal').modal();

    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
        //alert("You are on step "+stepNumber+" now");
        if (stepPosition === 'first') {
            $("#prev-btn").addClass('disabled');
        } else if (stepPosition === 'final') {
            $("#next-btn").addClass('disabled');
        } else {
            $("#prev-btn").removeClass('disabled');
            $("#next-btn").removeClass('disabled');
        }
    });

    // Toolbar extra buttons
    var btnFinish = $('<button></button>').text('Finish')
            .addClass('btn btn-info')
            .on('click', function () {
                $(location).attr('href', 'http://localhost/laboratoriovirtual_ufu/dsn/atividade.php');
            });
    var btnCancel = $('<button></button>').text('Cancel')
            .addClass('btn btn-danger')
            .on('click', function () {
                $('#smartwizard').smartWizard("reset");
            });


    // Smart Wizard
    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'default',
        transitionEffect: 'fade',
        showStepURLhash: true,
        toolbarSettings: {toolbarPosition: 'both',
            toolbarButtonPosition: 'end',
            toolbarExtraButtons: [btnFinish, btnCancel]
        }
    });


    $("#smartwizard-atividade").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPositionActivit) {
        //alert("You are on step "+stepNumber+" now");
        if (stepPositionActivit === 'first') {
            $("#prev-btn").addClass('disabled');
        } else if (stepPositionActivit === 'final') {
            $("#next-btn").addClass('disabled');
        } else {
            $("#prev-btn").removeClass('disabled');
            $("#next-btn").removeClass('disabled');
        }
    });

    // Toolbar extra buttons
    var btnFinishActivit = $('<button></button>').text('Finish')
            .addClass('btn btn-info')
            .on('click', function () {
                $(location).attr('href', '/laboratoriovirtual_ufu/dsn/home.php');
            });
    var btnCancelActivit = $('<button></button>').text('Cancel')
            .addClass('btn btn-danger')
            .on('click', function () {
                $('#smartwizard-atividade').smartWizard("reset");
            });



    // Smart Wizard
    $('#smartwizard-atividade').smartWizard({
        selected: 0,
        theme: 'default',
        transitionEffect: 'fade',
        showStepURLhash: true,
        toolbarSettings: {toolbarPosition: 'both',
            toolbarButtonPosition: 'end',
            toolbarExtraButtons: [btnFinishActivit, btnCancelActivit]
        }
    });

    $('nav#menu-principal').mmenu({
        "extensions": [
            "pagedim-black",
            "theme-dark"
        ],
        "counters": true
    });

    $('.owl-carousel').owlCarousel({
        loop: false,
        margin: 15,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1200: {
                items: 5
            },
            1920: {
                items: 5
            }
        }
    });
});

function reproduzir() {
    var audio = new Audio('audio/owl.mp3');
//    audio.play();
}

function setIdiomaPadraoSession(idioma) {
    $.ajax({
        url: URL_PORTAL + "?action=Portal.setIdiomaPadraoSession&idioma=" + idioma,
        success: function (msg) {
            if (msg == "OK") {
                window.location.reload();
            } else {
                alert(msg);
            }
        }
    });
}