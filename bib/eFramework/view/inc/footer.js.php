<!--================================================== -->	
<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/pace/pace.min.js"></script>


<script src="<?php echo URL_WEBROOT; ?>js/smart/libs/jquery-ui-1.10.3.min.js"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->
<!-- BOOTSTRAP JS -->		
<script src="<?php echo URL_WEBROOT; ?>js/smart/bootstrap/bootstrap.min.js"></script>
<!-- CUSTOM NOTIFICATION -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/notification/SmartNotification.min.js"></script>
<!-- JARVIS WIDGETS -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/smartwidgets/jarvis.widget.min.js"></script>
<!-- JQUERY VALIDATE -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/jquery-validate/jquery.validate.min.js"></script>
<!-- JQUERY MASKED INPUT -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/masked-input/jquery.maskedinput.min.js"></script>
<!-- JQUERY SELECT2 INPUT -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/select2/select2.min.js"></script>
<!-- browser msie issue fix -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/msie-fix/jquery.mb.browser.min.js"></script>
<!-- FastClick: For mobile devices -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/fastclick/fastclick.js"></script>

<!--<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/jquery-form/jquery-form.min.js"></script>-->
<!--[if IE 7]>
        
        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
        
<![endif]-->


<!-- Utility  & Crop -->
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/jquery/jquery.maskMoney.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/eq.blackcat.modal.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/eq.blackcat.util.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/eq.blackcat.default.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/jquery/jquery.form.js"></script>
<!--<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/jquery/jquery.maskedInput.js"></script>-->

<!-- Eq UI -->
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/jquery/ui/i18n/jquery.ui.datepicker-pt-BR.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/EqUi/EqUi.autocomplete.js"></script>

<!-- Datatable - descomente o que precisar, comentado para não sobrecarregar -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/datatables/jquery.dataTables-cust.js"></script>
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/datatables/media/js/TableTools.min.js"></script>
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/datatables/DT_bootstrap.js"></script>
<!--<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/datatables/ColReorder.min.js"></script>
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/datatables/FixedColumns.min.js"></script>
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/datatables/ColVis.min.js"></script>
<script src="<?php echo URL_WEBROOT; ?>js/smart/plugin/datatables/ZeroClipboard.js"></script>-->
<script type="text/javascript">
    var IS_MODULE_INDEX = <?php echo defined("IS_MODULE_INDEX") ? IS_MODULE_INDEX : 0 ?>;
    $(document).ready(function() {
        eqSetUpPage();
<?php
if (isset($_REQUEST['MESSAGE_TYPE']) && isset($_REQUEST['MESSAGE_CODE'])) {
    eval("\$MESSAGE_TYPE = MESSAGE_TYPE_{$_REQUEST['MESSAGE_TYPE']};");
    eval("\$MESSAGE_CODE = MESSAGE_CODE_{$_REQUEST['MESSAGE_CODE']};");
    echo "eqMessage(\"$MESSAGE_TYPE\",\"{$MESSAGE_CODE}\")";
}
?>
    });
</script>

<!-- MAIN APP JS FILE -->
<script src="<?php echo URL_WEBROOT; ?>js/smart/app.js"></script>

<script type="text/javascript">
    runAllForms();

    $(function() {
        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                }
            },
            // Messages for form validation
            messages: {
                email: {
                    required: 'Please enter your email address',
                    email: 'Please enter a VALID email address'
                },
                password: {
                    required: 'Please enter your password'
                }
            },
            // Do not change code below
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent());
            }
        });
    });
</script>

<!-- PLUGINS JQUERY & OUTROS -->

<!--<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/mousetrap/mousetrap.min.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/mousetrap/mousetrap-global-bind.min.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/jquery/jquery.treeview.js"></script>-->

<!-- Eq Ajax -->
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/eq.blackcat.login.js"></script>


<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/jquery/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="<?php echo URL_WEBROOT ?>js/eq.blackcat.crop.js"></script>

<?php
include_once IGENIAL_ROOT_DIR . '/ext/header.php';
?>