<?php

include_once(dirname(__FILE__) . '/../actionparent/ConfiguracaoActionParent.php');

class ConfiguracaoAction extends ConfiguracaoActionParent {

    public function validate(&$request, $edicao = false) {
        $o = $this->recuperarConfiguracao();
        if ($o !== null) {
            # registro unico
            $edicao = true;
            $request->set("id", $o->getId());
        }

        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        if ($request->get("email")) {
            $aEmail = $request->get("email");
            unset($aEmail[0]); # modelo
            foreach ($aEmail as $i => $email) {
                if (!$email) {
                    unset($aEmail[$i]); # remove senao tiver nada
                } else {
                    if (!Util::validaEmail($email)) {
                        $this->setMsg("Por favor, informe um e-mail válido na linha: " . ($i));
                        return false;
                    }
                }
            }
            $request->set("email", join(",", $aEmail));
        }
        if ($request->get("telefone")) {
            $aTelefone = $request->get("telefone");
            unset($aTelefone[0]); # modelo
            foreach ($aTelefone as $i => $telefone) {
                if (!$telefone) {
                    unset($aTelefone[$i]); # remove senao tiver nada
                }
            }
            $request->set("telefone", join(",", $aTelefone));
        }
        if ($request->get("emailContato")) {
            $aEmailContato = $request->get("emailContato");
            unset($aEmailContato[0]); # modelo
            foreach ($aEmailContato as $i => $email) {
                if (!$email) {
                    unset($aEmailContato[$i]); # remove senao tiver nada
                } else {
                    if (!Util::validaEmail($email)) {
                        $this->setMsg("Por favor, informe um e-mail de contato válido na linha: " . ($i));
                        return false;
                    }
                }
            }
            $request->set("emailContato", join(",", $aEmailContato));
        }

        return true;
    }

    public function recuperarConfiguracao($fieldsToSelect = 'o') {
        $qb = $this->em->createQueryBuilder();
        #$where = QueryHelper::getAndEquals(array('o.id' => $id), $qb);
        $query = $qb->select($fieldsToSelect)
                ->from('Configuracao', 'o')
        ; #->where( $where );
        $oConfiguracao = $query->getQuery()->getOneOrNullResult();
        return $oConfiguracao;
    }

    public function add($request, $commitable = true, $returnObject = false, $doLog = true) {
        foreach ($request->getParameters() as $i => $v)
            $$i = $v;

        if (isset($id)) {
            # registro unico
            $oConfiguracao = $this->em->find('Configuracao', array('id' => $id));
        } else {
            $oConfiguracao = new Configuracao();
        }
        $oConfiguracao->setSistema($sistema);
        $oConfiguracao->setEmpresa($empresa);
        $oConfiguracao->setEndereco($endereco);
        $oConfiguracao->setLink($link);
        $oConfiguracao->setTwitter($twitter);
        $oConfiguracao->setFacebook($facebook);
        $oConfiguracao->setEmail($email);
        $oConfiguracao->setTelefone($telefone);
        $oConfiguracao->setEmailContato($emailContato);
        $oConfiguracao->setTituloContato($tituloContato);
        if (isset($relatorioLogo['error']) && $relatorioLogo['error'] == 0)
            $oConfiguracao->setRelatorioLogo($relatorioLogo['name']);
        $oConfiguracao->setRelatorioCabecalho($relatorioCabecalho);
        $oConfiguracao->setLogUsuario(UtilAuth::recuperaLoginUsuario($this->em));
        $oConfiguracao->setLogData(new DateTime('now'));

        try {
            if ($commitable) {
                $this->em->beginTransaction();
            }
            $this->em->persist($oConfiguracao);
            $this->em->flush($oConfiguracao);
            $this->addTransaction($oConfiguracao, $request);
            FileUtil::makeFileUpload('Configuracao/relatorioLogo', $oConfiguracao->getId(), 'relatorioLogo', false);

			if ($doLog) {
            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Adicionado Configuração com o índice '{$oConfiguracao->getId()}'", FALSE);
            ## LOG END ##
			}
			
            if ($commitable) {
                $this->em->commit();
            }
        } catch (Exception $e) {
            FileUtil::removeFile(dirname(__FILE__) . '/../../../upload/Configuracao', $oConfiguracao->getId());

            if ($commitable === false) {
                throw $e;
            }
            $this->setMsg($e);
            $this->em->rollback();
            return false;
        }
        if ($returnObject === true) {
            return $oConfiguracao;
        }
        return true;
    }

}

?>