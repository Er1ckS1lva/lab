<?php

class View extends ViewParent {

    protected $aModules;

    public function __construct($name, $response, $method = 'include') {
        $this->aModules = $this->aModules = $this->recuperaModulos();
        return parent::__construct($name, $response, $method);
    }

    public static function recuperaModulos() {
        # array com modulos onde chave é a url unica e os atributos podem ser acrescidos
        $aModulos = array();

        $_oUsuarioAutenticado = UtilAuth::recuperaObjetoUsuario();
        if ($_oUsuarioAutenticado) {
            # somente modulos que ele pode enxergar
            $aModuloMenuPerfil = UtilAuth::recuperaModulosMenusPerfil($_oUsuarioAutenticado->getPerfil()->getId());

            # seta os valores dos modulos e verifica se ele pode enxergar
            $aModuloMenu = UtilAuth::recuperaModulosMenus();
            foreach ($aModuloMenu as $oModuloMenu) {
                $sUrlModulo = constant("URL_MODULO_" . strtoupper($oModuloMenu->getNome()));
                if (in_array($sUrlModulo, $aModuloMenuPerfil)) {
                    $aModulos[$sUrlModulo]["nome"] = $oModuloMenu->getNome();
                    $aModulos[$sUrlModulo]["descricao"] = $oModuloMenu->getDescricao();
                    $aModulos[$sUrlModulo]["class"] = $oModuloMenu->getClass() . " font-menu-size"; # font-menu size tamanho da fonte, procurar css - app/inc/topo.php
                    $aModulos[$sUrlModulo]["icon"] = $oModuloMenu->getIcon();
                }
            }

            # retorna na ordem que foi escrita
        }
        return $aModulos;
    }

}
