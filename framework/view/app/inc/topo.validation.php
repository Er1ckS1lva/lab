<?

# esta funcao pega a entidade e verifica os campos que serão validados no php (ver xml)

function preparaValidaScriptTopo($sEntidade) {
    $aValidate = array();
    if (class_exists("{$sEntidade}Action")) {
        eval("\$actionValidate= new {$sEntidade}Action();");
        if (method_exists($actionValidate, "validateFields")) # caso nao possua validação - ex: Relatorio
            $aValidate = explode(",", $actionValidate->validateFields());
    }
    return $aValidate;
}
?>

<script type="text/javascript">
    function validateScriptTopo(sValidate, method_form, frm) {
        if (!method_form)
            method_form = "post";

        if (!frm)
            frm = $("#frm");

        if (frm.length) {
            var method = ($(frm).attr("method")).toString().toLowerCase();
            var aValidate = sValidate.split(",");
            if (method == method_form) {
                var aNames = new Array();
                var aMessages = new Array();
                for (var i = 0; i < aValidate.length; i++) {
                    var name = aValidate[i];
                    var validate = null;
                    if ($("[name='" + name + "']").length) {
                        validate = $("[name='" + name + "']");
                    } else if ($("#" + name).length) {
                        // para caso suggest - sempre tem o id
                        validate = $("#" + name);
                        name = name + "Suggest";
                    }

                    if (validate && validate.length) {
                        if (name && name != "" && name != null && name != undefined) {
                            var validate_text = $(validate).attr('i-validate-text') ? $(validate).attr('i-validate-text') : 'Este campo é obrigatório!';
                            // adiciona o *
                            $(validate).closest("section").find('label.label').prepend(CAMPO_OBRIGATORIO + " ");
                            aNames.push("'" + name + "': {required: true}");
                            // mensagem estatica mas ta bom! - talvez colocar chave nome do campo e descricao em $action->validateFields()
                            aMessages.push("'" + name + "': {required: " + "'" + validate_text + "'" + "}");
                        }
                    }
                }
//                alert(aNames);

                // validacao javascript - se precisar rebuscar usar regras mais especificas do smart (ex: email, confirm password...)
                if (aNames && aMessages) {
                    eval("var rules = {" + aNames.join(",") + "}");
                    eval("var messages = {" + aMessages.join(",") + "}");
                    $(frm).validate({
                        // Rules for form validation
                        rules: rules,
                        // Messages for form validation
                        messages: messages,
                        // Do not change code below
                        errorPlacement: function(error, element) {
                            error.insertAfter(element.parent());
                        }
                    });
                }
            }
        }
    }
</script>
<?

/*
 * COMO ADICIONAR VALIDAÇÂO DINAMICA:
 * 1- Criar um array com validaçao em alguma parte do formulário
 * 2- Pode chamar a validação padrao que tem em cada classe validateFields()
 * 3- Chamar via javascript e concatenar o array php por ,

  <?
  # validacao script - so copiar e escolher a classe
  $aValidateNovo = preparaValidaScriptTopo("Produto");
  $aValidateNovo[] = "OutroCampo"; # name
  # nao precisa checkar se existe pois esta validacao é explicita
  ?>
  <script type="text/javascript">
  $(document).ready(function() {
  validateScriptTopo('<?= join(",", $aValidateNovo) ?>','post','#form');
  });
  </script>

 */
?>