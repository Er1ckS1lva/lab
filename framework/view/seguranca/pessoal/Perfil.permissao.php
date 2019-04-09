<?
// include "/pessoal/perfil.permissao.php"; # Perfil.form e Perfil.edit
$aModulo = array();
if (($response->get("object"))) {
    $oPermissaoAction = new PermissaoAction();
    $aPermissao = $oPermissaoAction->collection(null, "o.Perfil = {$o->getId()}", "Modulo ASC");
    if ($aPermissao)
        foreach ($aPermissao as $oPermissao) {
            $aModulo[] = $oPermissao->getModulo();
        }
}
?>

<header>
    Permissões
</header>
<fieldset>
    <?= InterfaceHTML::selectMultiple("aModulo", ++$tabindex, "Modulo", "id", "nome", $aModulo) ?>
</fieldset>