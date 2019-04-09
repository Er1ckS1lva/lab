<?php

include_once(dirname(__FILE__) . '/../actionparent/AcaoActionParent.php');

class AcaoAction extends AcaoActionParent {

    public function validate(&$request, $edicao = false) {
        # validação parent
        $validation = $this->validateParent($request, $edicao);
        if (!$validation) {
            return $validation;
        }

        return true;
    }

    public function carrega($request) {
        $id_modulo = $request->get("oModulo") ? $request->get("oModulo") : 1;
        $theOneClass = $request->get("class");

        $oAcaoAction = new AcaoAction($this->em); #teste, nao sei se pode em php
        $oAcaoRequest = new Request();

        $oEntidadeAction = new EntidadeAction($this->em);
        $oEntidadeRequest = new Request();

        $oModuloAction = new ModuloAction($this->em);
        $oModuloRequest = new Request();

        $classes = get_declared_classes();
        sort($classes); // ordena em ordem alfabética
        $saida = "";

        $arranjoAcao = array(); // para não repetir a ação ao gravar

        $metodos_nao_cadastrados = $metodos_cadastrados = 0;
        foreach ($classes as $class) {
            $pos = strpos($class, "Controller");
            if ($pos > 0 && $class != 'FrontController' && (strpos($class, "ControllerParent") === FALSE)) {
                $metodos = get_class_methods($class);
                sort($metodos); // ordena em ordem alfabética
                $classe = substr($class, 0, $pos);
                
                $metodosParent = get_class_methods("{$classe}ActionParent");
                if (class_exists("{$classe}Action") && in_array("getEntityName", $metodosParent)) {
                    eval("\$acao = new {$classe}Action(\$this->em);");
                    $nomeDescritivo = $acao->getEntityName();
                } else {
                    $nomeDescritivo = $classe;
                }
                
                if ($theOneClass && $theOneClass != $classe)
                    continue;
                if (strToLower($classe) != 'front') { // métodos da Front não precisa ser guardado, como view
                    $saida .= "<p><h4>Classe: {$classe}</h4>";
                    foreach ($metodos as $metodo) {
                        #métodos que não devem ser criados
                        if (
                                strstr(strToLower($metodo), '__construct') ||
                                strstr(strToLower($metodo), 'filterConditions') ||
                                strstr(strToLower($metodo), 'carrega') ||
                                ($classe == "Usuario" && strstr(strToLower($metodo), 'login')) ||
                                ($classe == "Usuario" && strstr(strToLower($metodo), 'loginSubmit')) ||
                                ($classe == "Usuario" && strstr(strToLower($metodo), 'logout'))
                        ) {
                            continue;
                        }
                        $saida .= "<div style='margin-left: 15px;'>"; #{$classe}.{$metodo}
                        $nome = substr($class, 0, $pos) . ".$metodo";

                        // ve os tipos conhecidos e poem na descricao
                        if (strstr(strToLower($nome), 'formsubmit')) {
                            $tipoModulo = "Cadastrar";
                            $descricao = "Envio de formulário de inserção de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'form')) {
                            $tipoModulo = "Cadastrar";
                            $descricao = "Formulário de inserção de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'editsubmit')) {
                            $tipoModulo = "Editar";
                            $descricao = "Envio de formulário de edição de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'edit')) {
                            $tipoModulo = "Editar";
                            $descricao = "Formulário de edição de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'admfilter')) {
                            $tipoModulo = "Gerenciar";
                            $descricao = "Filtro de pesquisa de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'adm')) {
                            $tipoModulo = "Gerenciar";
                            $descricao = "Pesquisa de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'view')) {
                            $tipoModulo = "Gerenciar";
                            $descricao = "Visualizar formulário de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'del')) {
                            $tipoModulo = "Excluir";
                            $descricao = "Exclusão de dados de $nomeDescritivo";
                        } elseif (strstr(strToLower($nome), 'suggest')) {
                            $tipoModulo = "Sugestão";
                            $descricao = "Caixa de sugestões de $nomeDescritivo";
                        } else {
                            $tipoModulo = "Outros";
                            $descricao = "Sem descrição disponível ($nomeDescritivo)";
                        }

                        $oEntidade = $oEntidadeAction->selectByNome($classe);
                        if (!$oEntidade) {
                            $oEntidadeRequest->set("nome", $classe);
                            $oEntidadeRequest->set("descricao", $nomeDescritivo);
                            $oEntidade = $oEntidadeAction->add($oEntidadeRequest, FALSE, TRUE);
                            if (!$oEntidade) { # se não conseguir criar, dá erro!
                                return new View("Não consegui criar a Entidade '{$classe}' :( .<br/>Descrição do Erro:" . $oEntidadeAction->getMsg(), null, 'print');
                            }
                        }

                        $descricaoModulo = "{$tipoModulo} {$nomeDescritivo}";
                        $oModulo = $oModuloAction->selectByNome($descricaoModulo);
                        if (!$oModulo) { # se não encontrar, cria
                            $oModuloRequest->set("nome", $descricaoModulo);
                            $oModuloRequest->set("Entidade", $oEntidade->getId());
                            if ($tipoModulo !== "Sugestão") { ### SUGGEST NÃO ENTRA MAIS!
                                $oModulo = $oModuloAction->add($oModuloRequest, FALSE, TRUE);
                                if (!$oModulo) { # se não conseguir criar, dá erro!
                                    return new View("Não consegui criar o Modulo '{$descricaoModulo}'.<br/>Descrição do Erro:" . $oModuloAction->getMsg(), null, 'print');
                                }
                            }
                        }

                        if ($oModulo) {
                            $oAcaoRequest->set("Modulo", $oModulo->getId());
                            $oAcaoRequest->set("nome", $nome);
                            $oAcaoRequest->set("descricao", $descricao);

                            $temp = explode(".", $nome); // não guarda as constructs, nem o suggest nem o carrega
                            if ($oAcaoAction->selectByModuloNome($oModulo->getId(), $nome)) {
                                $saida .= "<p><span class='label label-danger'>{$nome} ({$descricao})</span> já existe</p>";
                                $metodos_nao_cadastrados++;
                            } else {
                                if (!in_array($nome, $arranjoAcao) && $temp[1] != '__construct' && $temp[1] != 'carrega' && $temp[1] != 'suggest') {
                                    if ($oAcaoAction->add($oAcaoRequest, FALSE)) {
                                        $saida .= "<p><span class='label label-success'>{$nome} ({$descricao})</span></p>";
                                        $metodos_cadastrados++;
                                    } else {
                                        $saida .= "<p><span class='label label-danger'>{$nome} ($descricao)</span> erro: {$oAcaoAction->getMsg()}</p>";
                                        $metodos_nao_cadastrados++;
                                    }
                                } elseif ($temp[1] != '__construct' && $temp[1] != 'carrega') {
                                    $saida .= "<p><span class='label label-danger'>{$nome} ({$descricao})</span> é parent (não entra)</p>";
                                    $metodos_nao_cadastrados++; #falhou em cadastrar!
                                }
                            }

                            $arranjoAcao[] = $nome; // alimenta o arranjo para não repetir
                            $saida .= "</div>";
                        }
                    }
                    #$saida .= "</div>";
                    #$saida .= "<br><b><font color='brown'>Resumo da Classe $class: </font><br/>";
                    #$saida .= "<font color='green'>{$metodos_cadastrados} Métodos cadastrados</font> / <font color='red'>{$metodos_nao_cadastrados} Não Cadastrados</font></b><br>";
                    #$saida .= "<hr/>";
                    $saida .= "</p>";
                }
            }
        }
        $saida .= '<h1>Ações geradas com sucesso!</h1>' .
                "<p style='color:green;'>Inseridos: {$metodos_cadastrados}</p>" .
                "<p style='color:red;'>Não Inseridos: {$metodos_nao_cadastrados}</p>";
        return $saida;
    }

}

?>