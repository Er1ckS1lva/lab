<?php

include_once(dirname(__FILE__) . '/../actionparent/PerfilActionParent.php');

class PerfilAction extends PerfilActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    protected function addTransaction($oPerfil, $request) {
        try {
            $oPermissaoAction = new PermissaoAction($this->em);
            $aModulo = $request->get("aModulo");
            if ($aModulo) {
                foreach ($aModulo as $oModulo) {
                    $request_permissao = new Request(FALSE);
                    $request_permissao->set("Perfil", $oPerfil->getId());
                    $request_permissao->set("Modulo", $oModulo);
                    $oPermissaoAction->add($request_permissao, FALSE, FALSE);
                }
            }

            $oPerfilModuloMenuAction = new PerfilModuloMenuAction($this->em);
            $aModuloMenu = $request->get("aModuloMenu");
            if ($aModuloMenu) {
                foreach ($aModuloMenu as $oModuloMenu) {
                    $request_module = new Request(FALSE);
                    $request_module->set("Perfil", $oPerfil->getId());
                    $request_module->set("ModuloMenu", $oModuloMenu);
                    $oPerfilModuloMenuAction->add($request_module, FALSE, FALSE);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function editTransaction($oPerfil, $request) {
        try {
            $qb = $this->em->createQueryBuilder();
            $where = QueryHelper::getAndEquals(array('o.Perfil' => $oPerfil->getId()), $qb);
            $query = $qb->delete()->from("Permissao", "o")->where($where)->getQuery()->execute();           

            $qb = $this->em->createQueryBuilder();
            $where = QueryHelper::getAndEquals(array('o.Perfil' => $oPerfil->getId()), $qb);
            $query = $qb->delete()->from("PerfilModuloMenu", "o")->where($where)->getQuery()->execute();

            $this->addTransaction($oPerfil, $request);
        } catch (Exception $e) {
            throw $e;
        }
    }
	
	public function validateDel($id, $isSingleDel = true) {
        if(!is_array($id)){
			$id = array($id);
		}
		
		$oUsuarioAction = new UsuarioAction();
		$total = $oUsuarioAction->totalRegistros("o.Perfil IN (".implode(",",$id).")");
		if ($total > 0) {
			throw new Exception("<i class='fa fa-warning'></i> Impossível remover pois há Usuário utilizando este item!");
			return false;
		}		
		return true;        
    }

}

?>