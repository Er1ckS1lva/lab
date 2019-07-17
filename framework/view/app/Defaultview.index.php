<?
$_oUsuarioAutenticado = UtilAuth::recuperaObjetoUsuario();
$oLogAction = new LogAction();
$oUltimo = $oLogAction->ultimoLogin($_oUsuarioAutenticado->getId());
$hora = (int) date("H");
if ($hora >= 6 && $hora < 12) {
    $saudacao = "Bom dia ";
} else if ($hora >= 12 && $hora < 18) {
    $saudacao = "Boa tarde ";
} else if (($hora >= 18 && $hora <= 23) || ($hora >= 0 && $hora < 6)) {
    $saudacao = "Boa noite ";
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><?= $saudacao ?><?= $_oUsuarioAutenticado->getNome() ?></h1>
        <h2 class="page-title txt-color-blueDark">
            <?
            # senao foi setado é porque não tem permissão na View
            if (isset($this->aModules[URL_APP . $this->module . "/"])) {
                ?>
                Você esta no módulo: 
                <br/>
                <?
                $sModuloEstouDefault = $this->aModules[URL_APP . $this->module . "/"];
                ?>
                <i class="fa fa-lg fa-fw <?= $sModuloEstouDefault["icon"] ?>"></i> 
                <span class="<?= $sModuloEstouDefault["class"] ?>" style="color: white;"><?= $sModuloEstouDefault["descricao"] ?></span>
            <? } else { ?>
                <span>Você não tem permissão para acessar esta página.</span>
                <script>
                    $(document).ready(function() {
                        eqRedirectTimeout(URL_APP + "?MESSAGE_CODE=NP&MESSAGE_TYPE=3");
                    });
                </script>
            <? } ?>
        </h2>
    </div>
</div>

<?
if (isset($sModuloEstouDefault)) {
    $include_widgets = $this->dir . "/" . $this->module . "/widgets.php";
    if (file_exists($include_widgets)) {
        include $include_widgets;
    }
}
?>