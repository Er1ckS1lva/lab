<!-- HEADER -->
<style>
    .font-menu-size{
        font-size: 10.7px;
    }
</style>

<header id="header">
    <div id="logo-group">
        <!-- PLACE YOUR LOGO HERE -->
        <span id="logo"> <img src="<?php echo URL_WEBROOT; ?>img/logo.png" alt="<?= APPLICATION_NAME ?>"> </span>
        <!-- END LOGO PLACEHOLDER -->
    </div>

    <!-- projects dropdown -->
    <div id="project-context">

        <span class="label">Módulos:</span>
        <span id="project-selector" class="popover-trigger-element dropdown-toggle" data-toggle="dropdown">
            <? $bModuloEscolhido = false ?>
            <? foreach ($this->aModules as $sUrl => $sModulo) { ?>
                <? if (strToLower($this->module) == strToLower($sModulo["nome"])) { ?>
                    <i class="<?= $sModulo["icon"] ?>"></i> <?= $sModulo["descricao"] ?>
                    <?
                    $bModuloEscolhido = true;
                    break;
                }
            }
            ?>
            <? if (!$bModuloEscolhido) { ?>
                Selecione um Módulo 
            <? } ?>
            <i class="fa fa-angle-down"></i>
        </span>

        <!-- Suggestion: populate this list with fetch and push technique -->
        <ul class="dropdown-menu">
            <? foreach ($this->aModules as $sUrl => $sModulo) { ?>
                <li>
                    <a href="<?= $sUrl ?>" class="<?= (strToLower($this->module) == strToLower($sModulo["nome"])) ? $sModulo["class"] . ' txt-color-white' : '' ?>">
                        <i class="<?= $sModulo["icon"] ?>"></i> <?= $sModulo["descricao"] ?>
                    </a>
                </li>
            <? } ?>
        </ul>
        <!-- end dropdown-menu-->

    </div>
    <!-- end projects dropdown -->

    <!-- pulled right: nav area -->
    <div class="pull-right">
        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" title="Recolher Barra de Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
            <span> <a href="<?php echo URL_LOGOUT ?>" title="Sair"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->

        <!-- multiple lang dropdown : find all flags in the image folder -->
        <ul class="header-dropdown-list hidden-xs">
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Meu Perfil: <?= $_oUsuarioAutenticado->getPerfil()->getNome() ?>">
                    <?= $_oUsuarioAutenticado->getLogin() ?> <i class="fa fa-angle-down"></i> 
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a data-toggle="modal" href="#actionModal" onclick="eqDialogInclude('Usuario.dadosPessoais', 'Meus Dados', null, '90%');">
                            <i class="fa fa-user"></i> Meus Dados
                        </a>
                    </li>
                    <li>
                        <a data-toggle="modal" href="#actionModal" onclick="eqDialogInclude('Usuario.trocarSenha', 'Trocar Senha', null, '90%');">
                            <i class="fa fa-lock"></i> Trocar Senha
                        </a>
                    </li>
                    <li>
                        <a data-toggle="modal" href="#actionModal" onclick="eqDialogInclude('Usuario.meuPerfil', 'Meu Perfil', null, '90%');">
                            <i class="fa fa-eye"></i> Meu Perfil
                        </a>
                    </li>
                    <li id="logout">
                        <a href="<?= URL_LOGOUT ?>"><i class="fa fa-sign-out"></i> Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- end multiple lang -->


        <!-- RELÓGIO E DATA -->
        <form name="form_reloj" class="header-search pull-right">
            <input type="text" onfocus="window.document.form_reloj.reloj.blur()" style="background-color: transparent; border: none; color:#555;" readonly name="reloj">
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $("body").addClass("fixed-header"); // fixa o cabecalho
                mueveReloj();
            });
            function mueveReloj() {
                // momentoActual = new Date(<?= date("Y") ?>, <?= date("m") ?>, <?= date("d") ?>, <?= date("H") ?>, <?= date("i") ?>, <?= date("s") ?>);
                momentoActual = new Date();
                hora = momentoActual.getHours();
                minuto = momentoActual.getMinutes();
                segundo = momentoActual.getSeconds();

                str_segundo = new String(segundo);
                if (str_segundo.length == 1)
                    segundo = "0" + segundo;

                str_minuto = new String(minuto)
                if (str_minuto.length == 1)
                    minuto = "0" + minuto;

                str_hora = new String(hora)
                if (str_hora.length == 1)
                    hora = "0" + hora;

                horaImprimible = hora + " : " + minuto + " : " + segundo;

                document.form_reloj.reloj.value = "<?= date("d/m/Y") ?>";
                document.form_reloj.reloj.value += "   ";
                document.form_reloj.reloj.value += horaImprimible;

                setTimeout("mueveReloj()", 1000);
            }
        </script>
        <!-- ACABA RELÓGIO E DATA -->


    </div>
    <!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->

<!-- Left panel : Navigation area -->
<aside id="left-panel">
    <!-- User info -->
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
            <?php
            $img = MediaUtil::getLinkForFileNameById('Usuario/foto', "{$_oUsuarioAutenticado->getId()}_m");
            if ($img == "javascript: void(0);") {
                $img = MediaUtil::getLinkForFileNameById('Usuario/foto', "{$_oUsuarioAutenticado->getId()}");
            }
            ?>                            
            <a href="javascript:void(0);" id="show-shortcut">
                <img src="<?= $img ?>" alt="me" class="online" /> 
                <span>
                    <?= $_oUsuarioAutenticado->getPerfil()->getNome() ?>
                </span>
                <i class="fa fa-angle-down"></i>
            </a> 
        </span>
    </div>
    <!-- end user info -->
    <nav>
        <ul selectedEntity="<?= $this->classe ?>" selectedMethod="<?= $this->metodo ?>" id="menu_geral">
            <li>
                <a href="<?= URL_APP ?>admin" title="Painel"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Início</span></a>
            </li>
            <?
            if ($this->module && file_exists($this->dir . '/' . $this->module . '/inc/menu.php')) {
                include $this->dir . '/' . $this->module . '/inc/menu.php';
            } else {
                include $this->dir . '/app/inc/menu.php';
            }
            ?>
        </ul>
    </nav>
    <span class="minifyme" onclick="setCookieMenuSession()"> <i class="fa fa-arrow-circle-left hit"></i> </span>
    <!-- include no topo -->
</aside>


<script type="text/javascript">
    // para cookie menu - recolhido ou expandido
    // setCookieMenuSession()
    $(document).ready(function() {
        var cook = getCookie("class_body");
//        alert(cook);
        if (cook === "recolher") {
            $("body").addClass("minified");
        }
        else {
            $("body").removeClass("minified");
        }
    });
</script>


<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
Note: These tiles are completely responsive,
you can add as many as you like
-->
<div id="shortcut">
    <ul>
        <? foreach ($this->aModules as $sUrl => $sModulo) { ?>
            <li>
                <a href="<?= $sUrl ?>" class="jarvismetro-tile big-cubes <?= $sModulo["class"] ?> <?= (strToLower($this->module) == strToLower($sModulo["nome"])) ? "selected" : "" ?>"> 
                    <span class="iconbox">
                        <i class="<?= $sModulo["icon"] ?>  fa-4x"></i> 
                        <span class="text-center"><?= $sModulo["descricao"] ?></span>
                    </span> 
                </a>
            </li>
        <? } ?>
    </ul>
</div>
<!-- END SHORTCUT AREA -->
<?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/modals.php'; ?>



<?php
# SEGURANCA
# parte que esconde as opcoes da listagem caso nao tenha permissao
# ver View
$sHrefForm = URL_APP . "{$this->module}/{$this->classe}/form";
$sHrefDel = "#deleteMultipleActionModal";
?>

<?php
# remove dos menus do modulo
$aModulosHref = (UtilAuth::todasAcoes());
$aModuloHref = array();
$aAcaoPermissao = array();
foreach ($aModulosHref as $sClass => $aClass) {
    foreach ($aClass as $sMetodo) {
        if (class_exists("{$sClass}Action")) {
            eval("\$action= new {$sClass}Action();");
            if ($action->getModuleName() === $this->module) {
                $tmp = explode(".", $sMetodo);
                $sClasseUtilizada = $tmp[0];
                $sMetodoUtilizado = $tmp[1];
                if ($sMetodoUtilizado == "admFilter" || $sMetodoUtilizado == "adm") {
                    $aModuloHref[] = URL_APP . $action->getModuleName() . "/" . $sClass;
					$aAcaoPermissao[] = $sMetodo;
                }
                # Todos os metodos de visualização deve ter Adm e/ou AdmFilter (incluindo relatorios)
                # tem que estar para listagem do menu
                else if (strstr($sMetodoUtilizado, "AdmFilter") || strstr($sMetodoUtilizado, "Adm")) {
                    $aModuloHref[] = URL_APP . $action->getModuleName() . "/" . $sClass . "/" . $sMetodoUtilizado;
					$aAcaoPermissao[] = $sMetodo;
                } else if (strstr($sMetodoUtilizado, "admFilter") || strstr($sMetodoUtilizado, "adm")) {
                    $aModuloHref[] = URL_APP . $action->getModuleName() . "/" . $sClass . "/" . $sMetodoUtilizado;
					$aAcaoPermissao[] = $sMetodo;
                } else if (strstr(strtolower($sMetodoUtilizado), "admfilter") || strstr(strtolower($sMetodoUtilizado), "adm")) {
                    $aModuloHref[] = URL_APP . $action->getModuleName() . "/" . $sClass . "/" . $sMetodoUtilizado;
					$aAcaoPermissao[] = $sMetodo;
                }
            }
        }
    }
}

$aModuloHref = array_unique($aModuloHref);

# para reforço nas permissoes
if ($aAcaoPermissao) {
    $oUtilAuthPermissao = new UtilAuth();
    foreach ($aAcaoPermissao as $i => $oAcaoPermissao) {
        if (!$oUtilAuthPermissao->usuarioAutenticado($oAcaoPermissao)) {
            unset($aModuloHref[$i]);
        }
    }
}

?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_geral > li > ul > li > a").each(function(index, domElem) {
            var link = $(this).attr("href");
            link = link.toString().split("?"); // para permitir passar parametros no link
            link = link[0];
<? if ($aModuloHref) { ?>
                if (!in_array(link, [<?= '"' . join('","', $aModuloHref) . '"' ?>])) {
                    $(this).remove();
                }
<? } else { ?>
                $(this).remove();
<? } ?>
        });
    });
</script>


<?php
if ($this->metodo == "admFilter" OR $this->metodo == "adm") {
    include 'topo.adm.php';
}
?>

<?php
include 'topo.validation.php';
# VALIDACAO script - so copiar e escolher a classe
$aValidate = preparaValidaScriptTopo($this->classe);
if ($aValidate) {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            // valida na ordem e pelo 'name' que foi gerado - se for o caso pode montar array individualmente
            validateScriptTopo('<?= join(",", $aValidate) ?>');
        });
    </script>
    <?php
}
?>

<?php
include $this->dir . '/app/inc/topo.maxlength.php';
$aMax = preparaMaxlengthScriptTopo($this->classe);
if ($aMax) {
    ?>
    <script type="text/javascript">
		$(document).ready(function() {
			maxLengthScriptTopo('<?= join(",", $aMax) ?>');
		});
    </script>
    <?php
}
?>

<!--// RTA - todas as tabelas tem que ter div responsive para não explodir o espaço senão tiver -->
<script type="text/javascript">
    $(document).ready(function() {
        if ($("#resultados > table").length) {
            $('#resultados').addClass('overflow_table');
        }
    });
</script>

<link rel="stylesheet" href="<?php echo URL_SISTEMA ?>css/override.css">