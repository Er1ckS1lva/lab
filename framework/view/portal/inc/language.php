<?php

// include i18n class and initialize it
require_once dirname(__FILE__) . "/../i18n/i18n.class.php";


#se algum idioma não cadastrado na classe i18n com seu devido dicionário for forçado o padrão será setado (Padrão: Inglês)
$idiomas = array('pt-br', 'en-us');
if (isset($_SESSION['lang'])) {
    if (!in_array($_SESSION['lang'], $idiomas)) {
        $_SESSION['lang'] = 'en-us';
    }
}
//se não tiver linguagem setada, definir inglês
else {
    $_SESSION['lang'] = 'en-us';
}

$i18n = new i18n(dirname(__FILE__) . "/../i18n/lang/lang_{LANGUAGE}.ini", dirname(__FILE__) . "/../i18n/langcache/", $_SESSION['lang'], "Lang");
// Parameters: language file path, cache dir, default language (all optional)
// init object: load language files, parse them if not cached, and so on.
$i18n->init();
//exit();
?>