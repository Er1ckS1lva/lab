<script type="text/javascript">
    $(document).ready(function() {
//         alert('<?= $sHrefForm ?>');
<?php
# Form
if (!UtilAuth::temPermissaoRequest($_REQUEST["action"], "Form")) {
    ?>
            $("a").each(function(index, domElem) {
                var link = $(this).attr("href");
                if (link == '<?= $sHrefForm ?>') {
                    $(this).remove();
                }
            });
<?php } ?>

<?php
# Edit
if (!UtilAuth::temPermissaoRequest($_REQUEST["action"], "Edit")) {
    ?>
            $(".edicao").remove();
<?php } ?>

<?php
# Del
if (!UtilAuth::temPermissaoRequest($_REQUEST["action"], "Del")) {
    ?>
            $(".delecao").remove();
            $("a").each(function(index, domElem) {
                var link = $(this).attr("href");
                if (link == '<?= $sHrefDel ?>') {
                    $(this).remove();
                }
            });
<?php } ?>

<?php
# tira o bloco de acao
if (!UtilAuth::temPermissaoRequest($_REQUEST["action"], "Edit") && !UtilAuth::temPermissaoRequest($_REQUEST["action"], "Del")) {
    ?>
            $(".acao").remove();
<?php } ?>
    });
</script>