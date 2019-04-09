<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= APPLICATION_NAME ?></title>
<script type="text/javascript">
    /* Algumas constantes em JS, evite sobrescrever essas que não estão em caixa alta */
    var URL = "<?= URL ?>";
    var URL_APP = "<?= URL_APP ?>"; // é o caminho usado nos redirects, configure de acordo com a aplicação
    var MODULO_NAME = "<?= isset($this) && is_object($this) ? $this->module : "" ?>"; // é o caminho usado nos redirects, configure de acordo com a aplicação
    var CAMPO_OBRIGATORIO = "<?= CAMPO_OBRIGATORIO ?>"; // Modelo de campo obritatório
    var eqGreen = 'green';
    var eqYellow = 'yellow';
    var eqRed = 'red';
    var eqBlue = 'blue';
</script>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- *********************** [START] SMART ADMIN INCLUDES *********************** -->
<!-- Basic Styles -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_WEBROOT; ?>/css/smart/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_WEBROOT; ?>/css/smart/font-awesome.min.css">

<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_WEBROOT; ?>/css/smart/smartadmin-production.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_WEBROOT; ?>/css/smart/smartadmin-skins.css">

<!-- FAVICONS -->
<link rel="shortcut icon" href="<?php echo URL_WEBROOT; ?>/img/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo URL_WEBROOT; ?>/img/favicon.ico" type="image/x-icon">

<!-- GOOGLE FONT -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_WEBROOT; ?>/css/smart/google-fonts.css">
<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700"> <!--ORIGINAL-->

<!-- Specifying a Webpage Icon for Web Clip 
                 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
<link rel="apple-touch-icon" href="<?php echo URL_WEBROOT; ?>/img/splash/sptouch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL_WEBROOT; ?>/img/splash/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL_WEBROOT; ?>/img/splash/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL_WEBROOT; ?>/img/splash/touch-icon-ipad-retina.png">

<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- Startup image for web apps -->
<link rel="apple-touch-startup-image" href="<?php echo URL_WEBROOT; ?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
<link rel="apple-touch-startup-image" href="<?php echo URL_WEBROOT; ?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
<link rel="apple-touch-startup-image" href="<?php echo URL_WEBROOT; ?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
<!-- *********************** [END] SMART ADMIN INCLUDES *********************** -->



<link href="<?= URL_WEBROOT ?>css/jquery/jquery.Jcrop.css" type="text/css" rel="stylesheet" />



<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/libs/jquery-2.0.2.min.js"></script>
<!-- mousetrap -->
<script src="<?php echo URL_WEBROOT; ?>js/mousetrap/mousetrap.min.js"></script>
<script src="<?php echo URL_WEBROOT; ?>js/mousetrap/mousetrap-global-bind.min.js"></script>

<style>
    .btn-default-hover{
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }
</style>

<style>
    /* BEGIN hack ie */
    input.form-control[type=file]{
        height: 40px !important;
    }
    /* END hack ie */
</style>