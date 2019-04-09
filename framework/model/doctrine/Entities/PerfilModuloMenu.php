<?php

/**
 * @Entity 
 * @Table(name="perfil_modulo_menu")
 */
class PerfilModuloMenu {
    /** 
    * @Id 
    * @manyToOne (targetEntity="Perfil")
    * @JoinColumn(name="id_perfil", referencedColumnName="id", columnDefinition="Perfil")
    **/
    protected $Perfil;
    /** 
    * @Id 
    * @manyToOne (targetEntity="ModuloMenu")
    * @JoinColumn(name="id_modulo_menu", referencedColumnName="id", columnDefinition="ModuloMenu")
    **/
    protected $ModuloMenu;


    public function getPerfil() {
        return $this->Perfil;
    }
    public function setPerfil($Perfil) {
        if($Perfil) {
        $this->Perfil = $Perfil;
        }
    }

    public function getModuloMenu() {
        return $this->ModuloMenu;
    }
    public function setModuloMenu($ModuloMenu) {
        if($ModuloMenu) {
        $this->ModuloMenu = $ModuloMenu;
        }
    }



    public function toArray() {
        return PerfilModuloMenuAction::toArray($this);
    }
}

?>