<?php

class BreadcrumbUtil extends BreadcrumbUtilParent {
    #Modelo, após o uso, pode deletar.
//        if (
//                strtoupper($classe) == "CLIENTEUNIDADE" && isset($_REQUEST['Cliente'])
//        ) {
//            $this->concatenaLink = false;
//            $niveis = "N";
//            
//            $oClienteAction = new ClienteAction();
//            $oCliente = $oClienteAction->select($_REQUEST['Cliente']);
//            #primeiro o processo
//            $aLinksMigalha["Cliente"] = "Unidades do Cliente ({$oCliente->getNome()})";
//
//            $titulo = $titulo ? $titulo : "{$entityName}";
//            $aLinksMigalha[""] = "{$titulo} <span id='contadorResultadoLista'></span>";
//        }

    protected function manualBreadcrumb(&$aLinksMigalha, &$niveis) {
		$classe = $this->classe;
		$metodo = $this->metodo;
		/*
		# EX: 
        if (strtoupper($classe) == "") {
            $niveis = "N";
			$this->concatenaLink = false;			
			$aLinksMigalha["{$classe}/admFilter/?tipo={$tipo}"] = "";
			if (strtoupper($metodo) == "FORM") {
				$aLinksMigalha[] = "Cadastrar";
			}
			if (strtoupper($metodo) == "EDIT") {
				$aLinksMigalha[] = "Editar";
			}
        }
		*/
		
		/*
		# EX2:
		if (($classe) == "Usuario" && $metodo == "home") {
            $niveis = "PRINT";
            $aLinksMigalha[] = "<a href='" . URL_APP . PATH_GESTOR . "'>Início</a>";
            $aLinksMigalha[] = "<a href='" . URL_APP . "' target='_blank'>Site</a>";
        }
		*/
    }

}

?>