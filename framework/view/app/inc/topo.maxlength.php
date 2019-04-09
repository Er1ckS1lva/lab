<?php
# esta pagina visa sobescrever os maxlengths por entidade do formulario

function preparaMaxlengthScriptTopo($sEntidade) {
    $aMax = array();
    if (class_exists("{$sEntidade}Action")) {
        eval("\$actionMax= new {$sEntidade}Action();");
        if (method_exists($actionMax, "maxlengthFields")) # caso nao possua validação - ex: Relatorio
            $aMax = $actionMax->maxlengthFields();
    }

    $aRet = array();
    if ($aMax) {
        foreach ($aMax as $i => $v) {
            $aRet[] = "$i.$v";
        }
    }

    return $aRet;
}
?>

<script type="text/javascript">
    function maxLengthScriptTopo(sMax, frm) {
        if (!frm)
            frm = $("#frm");

        if (frm.length) { // verifica se tem o formulário
            var aMax = sMax.split(",");
            for (var i = 0; i < aMax.length; i++) {
                var tmp = aMax[i].split(".");
                var name = tmp[0];
                var max = tmp[1];
                if ($("[name='" + name + "']").length && max) { // se existir o campo e o maxlength poem o max
                    if (!$("[name='" + name + "']").attr("maxlength")) { // ate a seguinte data (20-10-17) esta OK se tiver maxlength então senao tiver esta ok (se for o caso se colocou é porque quer utilizar a que esta)
                        $("[name='" + name + "']").attr("maxlength", max);
                        //$("[name='" + name + "']").attr("rel", "PASSEI SIM");
                    }
                }
            }
        }
    }
</script>