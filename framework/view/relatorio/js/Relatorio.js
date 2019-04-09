function RelatorioCarregaHora(valueInicial) {
    $isDisabled = true;
    $('#horaFinal option').each(function () {
        if (this.value == valueInicial) {
            $isDisabled = false;
        }
        if ($isDisabled) {
            $(this).attr("disabled", true);
        } else {
            $(this).removeAttr("disabled");
        }

    });
}
