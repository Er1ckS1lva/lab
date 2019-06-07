<?php

include_once(dirname(__FILE__) . '/../actionparent/AtividadeActionParent.php');

class AtividadeAction extends AtividadeActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }
        #validação dos idiomas
        $oIdiomaAction = new IdiomaAction();
        $aIdSigla = $oIdiomaAction->getIdSigla(null, null, 'padrao ASC');

        $aTitulo = $request->get("aTitulo");
        $aDescricao = $request->get("aDescricao");
        foreach ($aTitulo as $nIdIdioma => $oTitulo) {
            if (!$oTitulo) {
                throw new Exception("Por favor, informe o título do idioma: " . $aIdSigla[$nIdIdioma]);
            }
        }
        foreach ($aDescricao as $nIdIdioma => $oDescricao) {
            if (!$oDescricao) {
                throw new Exception("Por favor, informe o título do idioma: " . $aIdSigla[$nIdIdioma]);
            }
        }
        return true;
    }

    protected function addTransaction($oAtividade, $request) {

        $oConteudoAction = new ConteudoAction($this->em);
        $oConteudoArquivoAction = new ConteudoArquivoAction($this->em);

        # adição de opções
        $aValorOpcao = $request->get('valorOpcao');
        if ($aValorOpcao) {
            $aFoneticoOpcao = $request->get('valorFoneticoOpcao');
            $correta = $request->get('corretaOpcao');
            $oAtividadeOpcaoAction = new AtividadeOpcaoAction($this->em);

            foreach ($aValorOpcao as $key => $oValor) {
                try {
                    if ($oValor) {
                        $request_opcao = new Request(FALSE);
                        $request_opcao->set('Atividade', $oAtividade);
                        $request_opcao->set('valor', $oValor);
                        $request_opcao->set('valorFonetico', $aFoneticoOpcao[$key]);
                        $request_opcao->set('correta', $correta == $key ? "S" : "N");
                        $oAtividadeOpcaoAction->add($request_opcao, false, true);
                    }
                } catch (Exception $exc) {
                    throw $exc;
                }
            }
        }

        # adição de conteudo
        $tituloConteudo = $request->get('tituloConteudo');
        $arquivoConteudo = $request->get('arquivoConteudo');
        if ($tituloConteudo) {
            $oConteudoFormularioAction = new ConteudoFormularioAction($this->em);
            $oFormularioOpcaoAction = new FormularioOpcaoAction($this->em);

            $tipoConteudo = $request->get('tipoConteudo');
            $enunciadoConteudo = $request->get('enunciadoConteudo');
            $valorConteudo = $request->get('valorConteudo');

            foreach ($tituloConteudo as $key => $tc) {
                try {
                    if ($tc) {
                        # inserir Conteudo 
                        $request_conteudo = new Request(FALSE);
                        $request_conteudo->set('Atividade', $oAtividade);
                        $request_conteudo->set('titulo', $tc);
                        $oConteudo = $oConteudoAction->add($request_conteudo, false, true);

                        # inserir ConteudoArquivo
                        $request_arquivo = new Request(FALSE);
                        $request_arquivo->set('arquivo', file_get_contents($arquivoConteudo['tmp_name'][$key]));
                        $request_arquivo->set('nome', $arquivoConteudo['name'][$key]);
                        $request_arquivo->set('tipo', $arquivoConteudo['type'][$key]);
                        $request_arquivo->set('Conteudo', $oConteudo);
                        $oConteudoArquivoAction->add($request_arquivo, false);

                        # inserir ConteudoFormulario
                        $request_formulario = new Request(FALSE);
                        $request_formulario->set('Conteudo', $oConteudo);
                        $request_formulario->set('tipo', $tipoConteudo[$key]);
                        $request_formulario->set('enunciado', $enunciadoConteudo[$key]);
                        $oConteudoFormulario = $oConteudoFormularioAction->add($request_formulario, false, true);

                        # inserir FormularioOpcao
                        if ($valorConteudo) {
                            $opcaoConteudoCorreta = $request->get('opcaoConteudoCorreta');
                            foreach ($valorConteudo[$key] as $keyVC => $oVC) {
                                $request_form_opcao = new Request(FALSE);
                                $request_form_opcao->set('ConteudoFormulario', $oConteudoFormulario->getId());
                                $request_form_opcao->set('valor', $oVC);

                                $request_form_opcao->set('correta', in_array($keyVC, $opcaoConteudoCorreta[$key]) ? "S" : "N");
                                $oFormularioOpcaoAction->add($request_form_opcao, false, true);
                            }
                        }
                    }
                } catch (Exception $exc) {
                    throw $exc;
                }
            }
        }
        # adição de idioma
        $aIdioma = $request->get("aIdioma");
        if ($aIdioma) {
            $aTitulo = $request->get("aTitulo");
            $aDescricao = $request->get("aDescricao");

            $oAtividadeIdiomaAction = new AtividadeIdiomaAction($this->em);
            $rAtividadeIdioma = new Request(FALSE);
            $rAtividadeIdioma->set("Atividade", $oAtividade->getId());
            foreach ($aIdioma as $id_idioma) {
                if (!isset($aTitulo[$id_idioma]) || strlen($aTitulo[$id_idioma]) == 0)
                    continue;
                $rAtividadeIdioma->set("Idioma", $id_idioma);
                $rAtividadeIdioma->set("titulo", $aTitulo[$id_idioma]);
                $rAtividadeIdioma->set("descricao", $aDescricao[$id_idioma]);

                if (strpos($id_idioma, "#") === FALSE) {
                    $oAtividadeIdiomaAction->add($rAtividadeIdioma, false, false);
                } else {
                    $rAtividadeIdioma->set("Idioma", substr($id_idioma, 0, strpos($id_idioma, "#")));
                    $oAtividadeIdiomaAction->edit($rAtividadeIdioma, false, false);
                }
            }
        }
    }

    protected function editTransaction($oAtividade, $request) {
//        Util::debug($request, false);
        $oConteudoAction = new ConteudoAction($this->em);
        $tituloConteudoEdit = $request->get('tituloConteudoEdit') ? $request->get('tituloConteudoEdit') : array();

        #se houver edits/ para saber quem foi excluido na edição;
        $aIdConteudo = $oConteudoAction->collection(array('id'), "o.Atividade = {$oAtividade->getId()}");
        if ($aIdConteudo) {
            $oConteudoFormularioAction = new ConteudoFormularioAction($this->em);
            $oFormularioOpcaoAction = new FormularioOpcaoAction($this->em);
            $oConteudoArquivoAction = new ConteudoArquivoAction($this->em);

            $arquivoConteudoEdit = $request->get('arquivoConteudoEdit');
            $tipoConteudoEdit = $request->get('tipoConteudoEdit');
            $enunciadoConteudoEdit = $request->get('enunciadoConteudoEdit');

            $aIdFormulario = $request->get("aIdFormulario"); # para pegar o id

            foreach ($aIdConteudo as $key => $aId) {
                #excluir/editar conteudo e seus arquivos 
                if (!key_exists($aId['id'], $tituloConteudoEdit)) {
                    $oConteudoAction->delPhysical($aId['id'], false);
                } else {
                    # editar conteudo
                    $request_conteudo = new Request(FALSE);
                    $request_conteudo->set('id', (int) $aId['id']);
                    $request_conteudo->set('Atividade', $oAtividade);
                    $request_conteudo->set('titulo', $tituloConteudoEdit[$aId['id']]);
                    $oConteudo = $oConteudoAction->edit($request_conteudo, false, true);

                    # editar ConteudoArquivo
                    $request_arquivo = new Request(FALSE);
                    # so insere arquivo se houver upload, se n houver, não edita nada, apenas mantém o registro atual
                    if ($arquivoConteudoEdit['error'][$aId['id']] == 0) {
                        $request_arquivo->set('arquivo', file_get_contents($arquivoConteudoEdit['tmp_name'][$aId['id']]));
                        $request_arquivo->set('nome', $arquivoConteudoEdit['name'][$aId['id']]);
                        $request_arquivo->set('tipo', $arquivoConteudoEdit['type'][$aId['id']]);
                        $request_arquivo->set('Conteudo', $oConteudo->getId());
                        $oConteudoArquivoAction->edit($request_arquivo, false);
                    }

                    # editar conteudoFormulario
                    $request_formulario = new Request(FALSE);

                    # para pegar o id do conteudo formulario
                    $id_conteudo_formulario = isset($aIdFormulario[$key]) ? $aIdFormulario[$key] : null;
                    if ($id_conteudo_formulario) {
                        $request_formulario->set('id', $id_conteudo_formulario);
                        $request_formulario->set('Conteudo', $oConteudo->getId());
                        $request_formulario->set('tipo', $tipoConteudoEdit[$aId['id']]);
                        $request_formulario->set('enunciado', $enunciadoConteudoEdit[$aId['id']]);
                        $oConteudoFormulario = $oConteudoFormularioAction->edit($request_formulario, false, true);
                    }
                }
            }
        }

        # edição de opções
        $oAtividadeOpcaoAction = new AtividadeOpcaoAction($this->em);
        $valorOpcaoEdit = $request->get('valorOpcaoEdit') ? $request->get('valorOpcaoEdit') : array();
        $valorFoneticoOpcaoEdit = $request->get('valorFoneticoOpcaoEdit') ? $request->get('valorFoneticoOpcaoEdit') : array();
        $correta = $request->get('corretaOpcao');

        #se houver edits/ para saber quem foi excluido na edição;
        $aIdOpcao = $oAtividadeOpcaoAction->collection(array('id'), "o.Atividade = {$oAtividade->getId()}");
        if ($aIdOpcao) {
            foreach ($aIdOpcao as $key => $aId) {
                #excluir/editar conteudo e seus arquivos 
                if (!key_exists($aId['id'], $valorOpcaoEdit)) {
                    $oAtividadeOpcaoAction->delPhysical($aId['id'], false);
                } else {
                    $request_opcao = new Request(FALSE);
                    $request_opcao->set('id', (int) $aId['id']);
                    $request_opcao->set('Atividade', $oAtividade);
                    $request_opcao->set('valor', $valorOpcaoEdit[$aId['id']]);
                    $request_opcao->set('valorFonetico', $valorFoneticoOpcaoEdit[$aId['id']]);
                    $request_opcao->set('correta', $correta == $aId['id'] ? "S" : "N");
                    $oAtividadeOpcaoAction->edit($request_opcao, false, true);
                }
            }
        }
        $this->addTransaction($oAtividade, $request);
    }

    public function saveGravacao($request, $score = false) {
        $audio = $request->get('data');
        $oAlunoAtividadeAction = new AlunoAtividadeAction($this->em);
        $oAluno = unserialize($_SESSION['serAlunoSessao']);
        $oAlunoAtividade = $oAlunoAtividadeAction->select($oAluno->getId(), $request->get('id_atividade'));
        $request_at = new Request(FALSE);
        $arquivotmp = file_get_contents($audio['tmp_name']);
        $request_at->set('arquivo', $arquivotmp);
        $request_at->set('nome', $request->get('fname'));
        $request_at->set('tipo', $audio['type']);
        $request_at->set('score', '90');
        $request_at->set('Aluno', $oAluno->getId());
        $request_at->set('Atividade', $request->get('id_atividade'));
        if (!$oAlunoAtividade) {
            $oAlunoAtividadeAction->add($request_at, true);
        } else {
            #salva apenas o score maior ou igual, se não, permanece o anterior 
            if ($score >= $oAlunoAtividade->getScore())
                $oAlunoAtividadeAction->edit($request_at, true);
        }

        $oAlunoAtividadeEnviosAction = new AlunoAtividadeenviosAction($this->em, true);
        $oAlunoAtividadeEnviosAction->add($request_at, true);
    }

    public function alteraTipo($id, $tipo) {
        $oAtividade = $this->em->find('Atividade', array('id' => $id));
        $oAtividade->setTipo($tipo);
        try {
            $this->em->beginTransaction();

            $this->em->persist($oAtividade);
            $this->em->flush($oAtividade);

            ## LOG BEGIN ##
            $oLog = new LogAction($this->em);
            $oLog->register("O", "Editada Atividade com o índice {$id} - Tipo: {$tipo}", FALSE);
            ## LOG END ##

            $this->em->commit();
        } catch (Exception $e) {
            throw $e;
            $this->setMsg($e);
            $this->em->rollback();
            return false;
        }

        return true;
    }

    public function filterConditions(&$request, &$response, &$orderPageConditions, $alias = "o", $conditions = array()) {
        $request->set("TemaSuggest", false);
        return parent::filterConditions($request, $response, $orderPageConditions, $alias, $conditions);
    }

    protected function delTransaction($id) {
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $id), $qb);
        $qb->delete()->from("AtividadeIdioma", "o")->where($where)->getQuery()->execute();
    }

}

?>