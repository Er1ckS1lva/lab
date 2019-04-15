<?php

/**
  Antonio Pena
 */
class BreadcrumbUtilParent {

    var $migalhas = array();
    var $url_raiz;
    var $nome;
    var $classe;
    var $metodo;
    var $classe_css;
    var $concatenaLink = true; # sempre monta a partir de cata ultimo link relatado, se for falso, sempre deve receber a url a partir da raiz informada no construtor

    function __construct($url_raiz, $modulo, $classe, $metodo, $nome = NULL) {
        $this->nome = $nome;
        $this->url_raiz = "{$url_raiz}" . ($modulo ? "{$modulo}/" : "");
        $this->classe = Util::recuperaNomeEntidade($classe);
        eval("\$controller = new {$classe}Controller(null,null);");
        $this->metodo = Util::recuperaNomeMetodo($controller, $metodo);
        if (!$this->migalhas) {
            $host = BreadcrumbUtil::getHost();
            $migalhas = array();
            if ($host)
                foreach ($host as $h) {
                    if ($h && $h != 'laboratoriovirtual_ufu' && $h != 'clientes' && $h != $modulo) {
                        $migalhas[$h] = ucfirst($h);
                    }
                }
            $this->migalhas = $migalhas;
        }
    }

    function create($write = true) {
        $migalha = array_values($this->migalhas);
        $classe = $this->classe;
        $link_metodo = $metodo = $this->metodo;
        if (count($migalha) > 2) {
            $this->removeLast(); // tira o id, modificado, só remove se for número
            $indice = $migalha[2];
            $link_metodo = $metodo . "/{$indice}";
        }

        if (class_exists("{$classe}Action")) {
            eval("\$o = new {$classe}Action();");
            $entityName = $classe;
            if ($o) {
                $entityName = $o->getEntityName();
            }
            switch (strtoupper($metodo)) {
                case 'FORM':
                    $niveis = 2;
                    $titulo = "Cadastrar {$entityName}";
                    break;
                case 'EDIT':
                    $niveis = 2;
                    $titulo = "Editar {$entityName}";
                    break;
                case 'VIEW':
                    $niveis = 2;
                    $titulo = "Visualizar {$entityName}";
                    break;
                case 'PERMISSAO':
                    $niveis = 2;
                    $titulo = "Permissão";
                    break;
                case 'HOME':
                    $niveis = 0;
                    break;
                case 'ADMFILTER':
                case 'ADM':
                    $niveis = 1;
                    break;
                default:
                    if ($this->nome) {
                        $niveis = 2;
                        $titulo = $this->nome;
                    } else {
                        $niveis = 1;
                    }
                    break;
            }
        }
        $aLinksMigalha = array();
        $this->manualBreadcrumb($aLinksMigalha, $niveis);

        $current_home = "";
        switch ($niveis) {
            case "N":
                $this->migalhas = $aLinksMigalha;
                break;
            case 0:
                $this->migalhas = null;
                $current_home = "current";
                break;
            case 1:
                $this->migalhas = array(
                    ($classe . "/{$metodo}") => "{$entityName} <span id='contadorResultadoLista'></span>"
                );
                break;
            case 2:
                $this->migalhas = array(
                    $classe => "{$entityName}",
                    $link_metodo => $titulo
                );
                break;
        }

        $marcador = '';


        $count = count($this->migalhas);
        $i = 1;
        $pao = array();
        $URL_RAIZ = $this->url_raiz;
        if (isset($this->migalhas)) {
            if ($niveis !== "N") {
                $pao[] = "<li><a href='" . URL . "admin' title='Ir para a tela inicial' >Início</a></li> ";

                # BEGIN adicionado modulo
                $oModuloMenuAction = new ModuloMenuAction();
                if (isset($_REQUEST["module"]) && $_REQUEST["module"]) {
                    $oModulo = $oModuloMenuAction->selectByNome($_REQUEST["module"], array("descricao"));
                    $pao[] = "<li><a href='" . $URL_RAIZ . "' class='{$current_home}' title='Ir para {$oModulo["descricao"]}' >" . ($oModulo["descricao"]) . "</a></li> ";
                }
                # END adicionado modulo
            }

            foreach ($this->migalhas as $link => $chamada) {
                if ($this->concatenaLink) {
                    $URL_RAIZ .= "{$link}/"; // concatena os niveis
                    $href = $URL_RAIZ;
                } else {
                    $href = $URL_RAIZ . $link; // não concatena, escreve a partir da raiz + o informado
                }
                if ($i == 1 && $i == $count) { // primeiro
                    $first = '<li><a class="" >' . $chamada . '</a></li> ';
                    if ($i != $count)
                        $first .= $marcador . ' '; // senao for primeiro e ultimo
                    $pao[] = $first;
                }
                else if ($i == $count) { // ultimo
                    $pao[] = '<li><a class="current">' . $chamada . '</a></li> ';
                } else {
                    $pao[] = '<li><a href="' . $href . '" class="">' . $chamada . '</a></li> ' . $marcador . ' ';
                }
                $i++;
            }
        }
        if ($write) {
            foreach ($pao as $migalha) {
                echo $migalha;
            }
        } else {
            return $pao;
        }
    }

    function set($link, $chamada) {
        $this->migalhas[$link] = $chamada;
    }

    function setArray($array) {
        foreach ($array as $link => $chamada) {
            $this->set($link, $chamada);
        }
    }

    function unsetCrumb($link) {
        unset($this->migalhas[$link]);
    }

    function unsetCrumbArray($array) {
        foreach ($array as $link) {
            $this->unsetCrumb($link);
        }
    }

    function get($link) {
        return $this->migalhas[$link];
    }

    function getKey($link) {
        return $this->migalhas[$link];
    }

    function getArray() {
        return $this->migalhas;
    }

    function total() {
        return count($this->migalhas);
    }

    function setMarcador($marcador) {
        $this->marcador = $marcador;
    }

    function getHost() {
        $host = $_SERVER['REQUEST_URI'];
        $host = explode("?", $host);
        $host = explode("/", $host[0]);
        if ($host[count($host) - 1] == "") {
            unset($host[count($host) - 1]);
        }
        return $host;
    }

    function getLink() {
        $link = $_SERVER['REQUEST_URI'];
        $link = explode("?", $link);
        $link = explode("/", $link[0]);
        if ($link[count($link) - 1] == "") {
            unset($link[count($link) - 1]);
        }
        return $link;
    }

    function removeFirst() {
        $migalhas = ($this->migalhas);
        foreach ($migalhas as $link => $chamada) {
            BreadcrumbUtil::unsetCrumb($link);
            break;
        }
    }

    function removeLast() {
        $migalhas = ($this->migalhas);
        $migalhas = array_reverse($migalhas, true);
        foreach ($migalhas as $link => $chamada) {
            BreadcrumbUtil::unsetCrumb($link);
            break;
        }
    }

    function insertFirst($link, $chamada) {
        array_unshift($this->migalhas, $chamada);
        $reindex = BreadcrumbUtil::reindex($this->migalhas, $link, 0);
        $this->migalhas = $reindex;
    }

    // igual ao set
    function insertLast($link, $chamada) {
        $this->migalhas[$link] = $chamada;
    }

    function reindex($array, $new_key, $key) {
        $reindex = array();
        foreach ($array as $i => $v) {
            if ($i == $key) {
                $reindex[$new_key] = $v;
                continue;
            }
            $reindex[$i] = $v;
        }
        return $reindex;
    }

}

?>