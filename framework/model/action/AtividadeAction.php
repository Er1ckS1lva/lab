<?php

include_once(dirname(__FILE__) . '/../actionparent/AtividadeActionParent.php');

class AtividadeAction extends AtividadeActionParent {

    public function validate(&$request, $edicao = false) {
//        Util::debug($request, false);
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }
        #validação dos idiomas
        $oIdiomaAction = new IdiomaAction();
        $aIdSigla = $oIdiomaAction->getIdSigla(null, null, 'padrao ASC');

        $id_ingles = $request->get('idiomaIngles');
        if ($request->get("tipo") === "REL") { // aColuna somente para o tipo REL
            $aColunaTmp = $_REQUEST["aColunaTmp"]; # $_REQUEST array para niveis
            $aColunaTmpFiles = $_FILES["aColunaTmp"]; # $_REQUEST array para niveis para arquivos
            $aColuna = array();
            foreach ($aColunaTmp as $id_idioma => $oColuna) {
                for ($i = 0; $i < count($oColuna["tipo1"]); $i++) {
                    $aColuna[$id_idioma]["coluna"][$i] = array(
                        "id" => ($oColuna["id"] ? $oColuna["id"][$i] : 0),
                        "Idioma" => $id_idioma,
                        "coluna1" => $i + 1,
                        "coluna2" => $i + 1,
                        "tipo1" => ($tipo1 = $oColuna["tipo1"][$i]),
                        "tipo2" => ($tipo2 = $oColuna["tipo2"][$i]),
                        "coluna1Text" => $oColuna["TEX1"][$i],
                        "coluna2Text" => $oColuna["TEX2"][$i],
                    );
                    # DUPLICAÇÃO PARA O INGLÊS
                    $aColuna[$id_ingles]["coluna"][$i] = array(
                        "id" => ($oColuna["id"] ? $oColuna["id"][$i] : 0),
                        "Idioma" => $id_ingles,
                        "coluna1" => $i + 1,
                        "coluna2" => $i + 1,
                        "tipo1" => ($tipo1 = $oColuna["tipo1"][$i]),
                        "tipo2" => ($tipo2 = $oColuna["tipo2"][$i]),
                        "coluna1Text" => $oColuna["TEX1"][$i],
                        "coluna2Text" => $oColuna["TEX2"][$i],
                    );


                    if ($tipo1 === "IMG") {
                        $aArquivo1 = array(
                            "id" => ($oColuna["IMG1ID"][$i] ? $oColuna["IMG1ID"][$i] : 0),
                            "name" => $aColunaTmpFiles["name"][$id_idioma]["IMG1"][$i],
                            "type" => $aColunaTmpFiles["type"][$id_idioma]["IMG1"][$i],
                            "tmp_name" => $aColunaTmpFiles["tmp_name"][$id_idioma]["IMG1"][$i],
                            "error" => $aColunaTmpFiles["error"][$id_idioma]["IMG1"][$i],
                            "size" => $aColunaTmpFiles["size"][$id_idioma]["IMG1"][$i],
                        );
                        $this->validaImagem($aArquivo1, !$edicao);
                        $aColuna[$id_idioma]["arquivo1"][$i] = $aArquivo1;
                        $aColuna[$id_ingles]["arquivo1"][$i] = $aArquivo1;
                    }
                    if ($tipo2 === "IMG") {
                        $aArquivo2 = array(
                            "id" => ($oColuna["IMG2ID"][$i] ? $oColuna["IMG2ID"][$i] : 0),
                            "name" => $aColunaTmpFiles["name"][$id_idioma]["IMG2"][$i],
                            "type" => $aColunaTmpFiles["type"][$id_idioma]["IMG2"][$i],
                            "tmp_name" => $aColunaTmpFiles["tmp_name"][$id_idioma]["IMG2"][$i],
                            "error" => $aColunaTmpFiles["error"][$id_idioma]["IMG2"][$i],
                            "size" => $aColunaTmpFiles["size"][$id_idioma]["IMG2"][$i],
                        );
                        $this->validaImagem($aArquivo2, !$edicao);
                        $aColuna[$id_idioma]["arquivo2"][$i] = $aArquivo2;
                        $aColuna[$id_ingles]["arquivo2"][$i] = $aArquivo2;
                    }
                    if ($tipo1 === "VID") {
                        $aArquivo1 = array(
                            "id" => ($oColuna["VID1ID"][$i] ? $oColuna["VID1ID"][$i] : 0),
                            "name" => $aColunaTmpFiles["name"][$id_idioma]["VID1"][$i],
                            "type" => $aColunaTmpFiles["type"][$id_idioma]["VID1"][$i],
                            "tmp_name" => $aColunaTmpFiles["tmp_name"][$id_idioma]["VID1"][$i],
                            "error" => $aColunaTmpFiles["error"][$id_idioma]["VID1"][$i],
                            "size" => $aColunaTmpFiles["size"][$id_idioma]["VID1"][$i],
                        );
                        $this->validaVideo($aArquivo1, !$edicao);
                        $aColuna[$id_idioma]["arquivo1"][$i] = $aArquivo1;
                        $aColuna[$id_ingles]["arquivo1"][$i] = $aArquivo1;
                    }
                    if ($tipo2 === "VID") {
                        $aArquivo2 = array(
                            "id" => ($oColuna["VID2ID"][$i] ? $oColuna["VID2ID"][$i] : 0),
                            "name" => $aColunaTmpFiles["name"][$id_idioma]["VID2"][$i],
                            "type" => $aColunaTmpFiles["type"][$id_idioma]["VID2"][$i],
                            "tmp_name" => $aColunaTmpFiles["tmp_name"][$id_idioma]["VID2"][$i],
                            "error" => $aColunaTmpFiles["error"][$id_idioma]["VID2"][$i],
                            "size" => $aColunaTmpFiles["size"][$id_idioma]["VID2"][$i],
                        );
                        $this->validaVideo($aArquivo2, !$edicao);
                        $aColuna[$id_idioma]["arquivo2"][$i] = $aArquivo2;
                        $aColuna[$id_ingles]["arquivo2"][$i] = $aArquivo2;
                    }
                }
            }
            foreach ($aColunaTmp as $id_idioma => $oColuna) {
                # há um array de coluna estava aqui por isso adicionei ele na linha abaixo (Tarefa http://redmine.equilibriumweb.com/redmine/issues/2807)
                if (count($aColuna[$id_idioma]['coluna']) < 2) {
                    throw new Exception("Por favor, informe ao menos 2 colunas para esse tipo do idioma: " . $aIdSigla[$id_idioma]);
                }
            }
            $request->set('aColuna', $aColuna);
        } else {
            $request->destroy('aColunaTmp');
            $request->destroy('aColuna');
        }


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

        // validando ao menos uma correta para os tipos: 
        $tituloConteudo = $edicao ? $request->get('tituloConteudoEdit') : $request->get('tituloConteudo');
        $tipoConteudo = $edicao ? $request->get('tipoConteudoEdit') : $request->get('tipoConteudo');
        $aCorretas = array();
        $bValidaCorretas = false;
        if ($tituloConteudo) {
            $opcaoConteudoCorreta = $request->get('opcaoConteudoCorreta');
            foreach ($tituloConteudo as $key => $tc) {
                if (in_array($tipoConteudo[$key], array("MEI", "MEV"))) {
                    $bValidaCorretas = true;
                    $i = $tc - 1;
                    foreach ($opcaoConteudoCorreta[$i] as $k => $v) {
                        $aCorretas[$key][] = $v;
                    }
                }
            }
        }
        if ($bValidaCorretas) {
            if (count(array_keys($aCorretas)) != count($tituloConteudo)) {
                $aDiff = array_diff(array_keys($tituloConteudo), array_keys($aCorretas));
                foreach ($aDiff as $k => $v) {
                    throw new Exception("Por favor, informe ao menos uma opção correta na posição " . ($k + 1) . "° para aos tipos de Múltipla escolhas!");
                }
            }
        }

        return true;
    }

    protected function addTransaction($oAtividade, $request) {
        $oConteudoAction = new ConteudoAction($this->em);
        $oConteudoArquivoAction = new ConteudoArquivoAction($this->em);

        # adição de opções (tipo de atividade: Preenchimento de balões em branco)
        $aValorOpcao = $request->get('valorOpcao');
        if ($oAtividade->getTipo() == "PRC" && $aValorOpcao) {
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

        # adição de colunas (tipo de atividade: Relacionar Colunas)
        $aColuna = $request->get('aColuna');
        if ($aColuna) {
            #duplicação de array para o idioma inglês Tarefa #2880


            $oAtividadeColunaAction = new AtividadeColunaAction($this->em);
            $oAtividadeColunaArquivoAction = new AtividadeColunaArquivoAction($this->em);
            foreach ($aColuna as $id_idioma => $oColuna) {
                foreach ($oColuna["coluna"] as $i => $coluna) {
                    $aArquivo = array();
                    $request_coluna = new Request(FALSE);
                    $request_coluna->set("Atividade", $oAtividade->getId());
                    foreach ($coluna as $k => $v) {
                        $request_coluna->set($k, $v);
                    }
                    if (in_array($request_coluna->get("tipo1"), array("IMG", "VID"))) {
                        $request_coluna->set("coluna1Text", null);
                        $arquivo1 = isset($oColuna["arquivo1"]) ? $oColuna["arquivo1"][$i] : array();
                        if ($arquivo1)
                            $aArquivo[] = array_merge($arquivo1, array("coluna" => 1));
                    }
                    if (in_array($request_coluna->get("tipo2"), array("IMG", "VID"))) {
                        $request_coluna->set("coluna2Text", null);
                        $arquivo2 = isset($oColuna["arquivo2"]) ? $oColuna["arquivo2"][$i] : array();
                        if ($arquivo2)
                            $aArquivo[] = array_merge($arquivo2, array("coluna" => 2));
                    }
                    if ($request_coluna->get("id")) {
                        $oColunaSave = $oAtividadeColunaAction->edit($request_coluna, false, true);
                    } else {
                        $oColunaSave = $oAtividadeColunaAction->add($request_coluna, false, true);
                    }
                    # parte arquivo
                    if ($aArquivo) {
                        foreach ($aArquivo as $arquivo) {
                            if ($arquivo["error"] == 0) {
                                $request_coluna_arquivo = new Request(FALSE);
                                $request_coluna_arquivo->set("AtividadeColuna", $oColunaSave->getId());
                                $request_coluna_arquivo->set("coluna", $arquivo["coluna"]);
                                $request_coluna_arquivo->set("nome", $arquivo["name"]);
                                $request_coluna_arquivo->set("tipo", $arquivo["type"]);

                                # salva o arquivo no banco
                                $request_coluna_arquivo->set("arquivo", file_get_contents($arquivo['tmp_name']));
                                if ($arquivo["id"]) {
                                    $request_coluna_arquivo->set("id", $arquivo["id"]);
                                    $oColunaArquivoSave = $oAtividadeColunaArquivoAction->edit($request_coluna_arquivo, false, true);
                                } else {
                                    $oColunaArquivoSave = $oAtividadeColunaArquivoAction->add($request_coluna_arquivo, false, true);
                                }
                            }
                        }
                    }
                }
            }
        }


        # adição de conteudo (Arquivo de multimidia)
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
                        if (!file_get_contents($arquivoConteudo['tmp_name'][$key])) {
                            throw new Exception("Por favor, informe o arquivo do conteúdo : " . $key);
                        }
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
            # valor das opções
            $valorConteudo = $request->get('valorConteudo');
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

//                        # editar FormularioOpcao
                        if ($valorConteudo) {
                            $aIdOpcaoForm = $oFormularioOpcaoAction->collection(array('id'), "o.ConteudoFormulario = {$oConteudoFormulario->getId()}");
                            $opcaoConteudoCorreta = $request->get('opcaoConteudoCorreta');
                            foreach ($valorConteudo[$key] as $keyVC => $oVC) {
                                $request_form_opcao = new Request(FALSE);
                                $request_form_opcao->set('id', $aIdOpcaoForm[$keyVC]['id']);
                                $request_form_opcao->set('ConteudoFormulario', $oConteudoFormulario->getId());
                                $request_form_opcao->set('valor', $oVC);

                                $request_form_opcao->set('correta', in_array($keyVC, $opcaoConteudoCorreta[$key]) ? "S" : "N");
                                $oFormularioOpcaoAction->edit($request_form_opcao, false, true);
                            }
                        }
                    }

//                   
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

        $oAlunoAtividadeEnviosAction = new AlunoAtividadeEnviosAction($this->em, true);
        $oAlunoAtividadeEnviosAction->add($request_at, true);
    }

    public function filterConditions(&$request, &$response, &$orderPageConditions, $alias = "o", $conditions = array()) {
        $request->set("TemaSuggest", false);
        return parent::filterConditions($request, $response, $orderPageConditions, $alias, $conditions);
    }

    protected function delTransaction($id) {
        return true; // deleção lógica pode deixar
        //
        // apaga os idiomas
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $id), $qb);
        $qb->delete()->from("AtividadeIdioma", "o")->where($where)->getQuery()->execute();

        // apaga as opções
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $id), $qb);
        $qb->delete()->from("AtividadeOpcao", "o")->where($where)->getQuery()->execute();

        // apaga os arquivos das colunas
//        $qb = $this->em->createQueryBuilder();
//        $where = QueryHelper::getAndEquals(array('u.Atividade' => $id), $qb);
//        $qb->delete()->from("AtividadeColunaArquivo", "o")->leftJoin('o.AtividadeColuna', 'u')->where($where)->getQuery()->execute();

        $oAtividadeColunaAction = new AtividadeColunaAction($this->em);
        $aAtividadeColuna = $oAtividadeColunaAction->collection(array("id"), "o.Atividade = '{$id}'");
        if ($aAtividadeColuna) {
            $oAtividadeColunaArquivoAction = new AtividadeColunaArquivoAction($this->em);
            foreach ($aAtividadeColuna as $oAtividadeColuna) {
                $oAtividadeColunaArquivoAction->delPhysicalByAtividadeColuna($oAtividadeColuna["id"], false);
            }
        }

        // apaga as colunas
        $qb = $this->em->createQueryBuilder();
        $where = QueryHelper::getAndEquals(array('o.Atividade' => $id), $qb);
        $qb->delete()->from("AtividadeColuna", "o")->where($where)->getQuery()->execute();
    }

    function validaImagem($arquivo, $bValida = true) {
        if ($bValida) {
            if ($arquivo['error'] != 0 && $arquivo['size'] <= 0) {
                throw new Exception("Por favor, informe o arquivo!");
            } elseif ($arquivo['error'] === 0 && $arquivo['size'] > 0) {
                $filename = basename($arquivo['name']);
                $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $extensions = array('jpeg', 'jpg', 'gif', 'png');
                $mimes = array('image/jpeg', 'image/gif', 'image/png', 'image/x-png', 'image/pjpeg');
                $fileMaxSizeMB = (int) ini_get('upload_max_filesize');
                $fileMaxSize = $fileMaxSizeMB * 1024 * 1024;
                if ($arquivo["size"] > $fileMaxSize) {
                    throw new Exception("Atenção: Somente arquivos de imagem com no máximo {$fileMaxSizeMB}MB são aceitos para upload!");
                }
                if (!in_array($ext, $extensions) || !in_array($arquivo['type'], $mimes)) {
                    throw new Exception("Atenção: Somente arquivos de imagem com a extensão " . join(', ', $extensions) . " são aceitos para upload!");
                }
            }
        }
        return true;
    }

    function validaVideo($arquivo, $bValida = true) {
        if ($bValida) {
            if ($arquivo['error'] != 0 && $arquivo['size'] <= 0) {
                throw new Exception("Por favor, informe o arquivo!");
            } elseif ($arquivo['error'] === 0 && $arquivo['size'] > 0) {
                $filename = basename($arquivo['name']);
                $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                $extensions = array('mp4');
                $mimes = array('video/mp4');
                $fileMaxSizeMB = (int) ini_get('upload_max_filesize');
                $fileMaxSize = $fileMaxSizeMB * 1024 * 1024;
                if ($arquivo["size"] > $fileMaxSize) {
                    throw new Exception("Atenção: Somente arquivos de vídeo com no máximo {$fileMaxSizeMB}MB são aceitos para upload!");
                }
                if (!in_array($ext, $extensions) || !in_array($arquivo['type'], $mimes)) {
                    throw new Exception("Atenção: Somente arquivos de vídeo com a extensão " . join(', ', $extensions) . " são aceitos para upload!");
                }
            }
        }
        return true;
    }

    function getColunas($id) {
        $aColuna = array();
        $oAtividadeColunaAction = new AtividadeColunaAction();
        $aAtividadeColuna = $oAtividadeColunaAction->collection(null, "o.Atividade='{$id}'");
        $oAtividadeColunaArquivoAction = new AtividadeColunaArquivoAction();
        $nColunaCount = 0;
        if ($aAtividadeColuna) {
            foreach ($aAtividadeColuna as $oAtividadeColuna) {
                $aColuna[$oAtividadeColuna->getIdioma()->getId()][$oAtividadeColuna->getId()]["coluna"] = $oAtividadeColunaAction->toArray($oAtividadeColuna);
                $aAtividadeColunaArquivo = $oAtividadeColunaArquivoAction->collection(array("id", "coluna", "nome", "tipo"), "o.AtividadeColuna = '{$oAtividadeColuna->getId()}'");
                if ($aAtividadeColunaArquivo) {
                    foreach ($aAtividadeColunaArquivo as $oAtividadeColunaArquivo) {
                        $aColuna[$oAtividadeColuna->getIdioma()->getId()][$oAtividadeColuna->getId()]["arquivo"][$oAtividadeColunaArquivo["coluna"]] = $oAtividadeColunaArquivo;
                    }
                }
                $nColunaCount++;
            }
        }
        return array_merge(array("coluna" => $aColuna), array("count" => ($aColuna ? round($nColunaCount / count(array_keys($aColuna))) : 0)));
    }

    function verificarResposta($dados, $tipo, $id) {
        if ($tipo == "PRC") {
            $aCorreta = $this->getCorreta($id);
            if ($dados == $aCorreta) {
                return true;
            } else {
                throw new Exception("Resposta Errada!");
            }
        } else if ($tipo == "REL") {
            $colunaA;
            $colunaB;
            foreach ($dados as $oDado) {
                $explode = explode('_', $oDado);
                $colunaA[] = $explode[0];
                $colunaB[] = $explode[1];
            }

            # Se for igual estão corretas, não é necessário verificar no banco
            if ($colunaA == $colunaB) {
                return true;
            } else {
                throw new Exception("Resposta errada");
            }
        }
    }

    function getCorreta($id) {
        $sql = "SELECT fo.id FROM atividade_opcao fo"
                . " WHERE fo.id_atividade = {$id}"
                . " AND fo.correta = 'S'";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $aCorreta = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $aCorreta;
    }

    function saveResposta($dados, $tipo, $id) {
        $oAlunoAtividadeTipoEnviosAction = new AlunoAtividadeTipoEnviosAction($this->em, true);
        $oAlunoAtividadeTipoAction = new AlunoAtividadeTipoEnviosAction($this->em, true);
        $oAluno = unserialize($_SESSION['serAlunoSessao']);
        $oAlunoAtividade = $oAlunoAtividadeTipoAction->select($oAluno->getId(), $id);
        $request_at = new Request();
        $request_at->set('Aluno', $oAluno->getId());
        $request_at->set('Atividade', (int) $id);
        $request_at->set('valor', join(';', $dados));
        $request_at->set('tipo', $tipo);
        if (!$oAlunoAtividade)
            $oAlunoAtividadeTipoEnviosAction->add($request_at, true);
        else
            $oAlunoAtividadeTipoAction->edit($request_at, true);
        return true;
    }

}

?>