<?
// include "/pessoal/perfil.almoxarifado.php"; # Perfil.form e Perfil.edit
$aModuloMenu = array();
if (($response->get("object"))) {
    $oPerfilModuloMenuAction = new PerfilModuloMenuAction();
    $aPerfilModuloMenu = $oPerfilModuloMenuAction->collection(null, "o.Perfil = {$o->getId()} AND u.logDel='N'", "ModuloMenu ASC");
    if ($aPerfilModuloMenu)
        foreach ($aPerfilModuloMenu as $oPerfilModuloMenu) {
            $aModuloMenu[] = $oPerfilModuloMenu->getModuloMenu();
        }
}
?>

<header>
    Módulo
</header>
<fieldset>
    <?= InterfaceHTML::selectMultiple("aModuloMenu", ++$tabindex, "ModuloMenu", "id", "descricao", $aModuloMenu) ?>
</fieldset>