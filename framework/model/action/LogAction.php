<?php

include_once(dirname(__FILE__) . '/../actionparent/LogActionParent.php');

class LogAction extends LogActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    public function register($operacao = "O", $descricao = "Operação sem descrição", $commitable = false) {
        $oUsuario = UtilAuth::recuperaObjetoUsuario($this->em);

        $ip = $_SERVER['REMOTE_ADDR'];
        $nomeHost = $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
        $request = new Request();
        $request->set("Usuario", $oUsuario->getId());
        $request->set("login", $oUsuario->getLogin());
        $request->set("dataHora", date("Y-m-d H:i:s"));
        $request->set("acao", $request->get("action"));
        $request->set("operacao", $operacao);
        $request->set("descricao", $descricao);
        $request->set("ip", $ip);
        $request->set("nomeHost", $nomeHost);

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->add($request, false, false);
            if ($commitable) {
                $this->em->commit();
            }
        } catch (Exception $e) {
            if ($commitable === false) {
                throw $e;
            }
            $this->setMsg($e);
            $this->em->rollback();
            return false;
        }
        return true;
    }

    public function ultimoLogin($Usuario) {
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Usuario' => $Usuario, 'o.operacao' => "'A'"), $qb);
        $query = $qb->select('o')
                ->from('Log', 'o')
                ->where($where)
                ->orderBy("o.id", "desc")
                ->setMaxResults(2);

//        $oLog = $query->getQuery()->getOneOrNullResult(); # penultimo agora...
        $oLog = $query->getQuery()->getResult();
        return isset($oLog[1])? $oLog[1]: $oLog[0];
    }

}

?>