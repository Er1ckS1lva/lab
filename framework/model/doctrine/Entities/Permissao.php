<?php

/**
 * @Entity 
 * @Table(name="permissao")
 */
class Permissao {
    /** 
    * @Id 
    * @manyToOne (targetEntity="Perfil")
    * @JoinColumn(name="id_perfil", referencedColumnName="id", columnDefinition="Perfil")
    **/
    protected $Perfil;
    /** 
    * @Id 
    * @manyToOne (targetEntity="Modulo")
    * @JoinColumn(name="id_modulo", referencedColumnName="id", columnDefinition="Módulo")
    **/
    protected $Modulo;


    public function getPerfil() {
        return $this->Perfil;
    }
    public function setPerfil($Perfil) {
        if($Perfil) {
        $this->Perfil = $Perfil;
        }
    }

    public function getModulo() {
        return $this->Modulo;
    }
    public function setModulo($Modulo) {
        if($Modulo) {
        $this->Modulo = $Modulo;
        }
    }



    public function toArray() {
        return PermissaoAction::toArray($this);
    }
}

?>