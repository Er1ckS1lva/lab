<?php

class PagingParent {

    private $elements;
    private $perPage;
    private $pageNumber;

    public function __construct($e, $pageNumber, $perPage = 10) {
        $this->elements = (is_array($e)) ? $e : array();
        $this->perPage = $perPage;
        $this->pageNumber = ($pageNumber < 1) ? 1 : (($pageNumber > $this->totalPages()) ? $this->totalPages() : (int) $pageNumber);
    }

    public static function getPageLinks($modulo, $classe, $metodo = 'admFilter', $totalResults, $gapPerPage = 5, $pageNumber, $parametros, $porPagina) {
        $totalPages = ceil($totalResults / $gapPerPage);
        $links_total = self::getPageCountAndTotal(($pageNumber + 1), $totalResults, $gapPerPage);
        $links = array();
        if ($totalPages > 1) {
            $url = URL . "{$modulo}/{$classe}/{$metodo}?{$parametros}&porPagina={$porPagina}"; # MODULARIZADO
            #$url = URL_APP . "{$classe}/{$metodo}?{$parametros}&porPagina={$porPagina}"; # NÃO MODULARIZADO
            $gap = ceil(($pageNumber + 1) / $gapPerPage);
            $begin = ($gap * $gapPerPage - $gapPerPage) + 1;
            if ($pageNumber > 0) {
                $p = 0;
                $links[] = "<li><a href=\"{$url}&page={$p}\">Primeira</a></li>";
            } else {
                $links[] = "<li class='disabled'><a>Primeira</a></li>";
            }
            if ($pageNumber > 0) { #novo, este vai pra página anterior
                $p = $pageNumber - 1;
                $links[] = "<li><a href=\"{$url}&page={$p}\">&larr;</a>";
            } else {
                $links[] = "<li class='disabled'><a>&larr;</a></li>";
            }
            for ($i = $begin; $i < ($begin + $gapPerPage); $i++) {
                if ($i > $totalPages)
                    break;
                $links[] = ($i != ($pageNumber + 1)) ? "<li><a href=\"{$url}&page=" . ($i - 1) . "\">$i</a></li>" : "<li class=\"active\"><a style='z-index:0;'>$i</a></li>"; # hack zindex
            }
            if (($pageNumber + 1) < $totalPages) { #novo, este vai pra próxima anterior
                $p = $pageNumber + 1;
                $links[] = "<li><a href=\"{$url}&page={$p}\">&rarr;</a></li>";
            } else {
                $links[] = "<li class='disabled'><a>&rarr;</a></li>";
            }
            if (($pageNumber + 1) < $totalPages) {
                $links[] = "<li><a href=\"{$url}&page=" . ($totalPages - 1) . "\">Última</a></li>";
            } else {
                $links[] = "<li class='disabled'><a>Última</a></li>";
            }
        } else {
            
        }
        $links = join("\n", $links);
        $links_pagination = "<ul class=\"pagination pagination-xs\">" .
                $links_total .
                $links .
                "</ul>"
        #"{$quantidadePorPagina}" 
        ;
        return $links_pagination;
    }

    public static function getPageCountAndTotal($pageNumber, $totalResults, $gapPerPage = 10) {
        $totalPages = ceil($totalResults / $gapPerPage);
        $beginFormula = (($pageNumber - 1) * $gapPerPage);
        $begin = $beginFormula + 1;
        $end = ($beginFormula + $gapPerPage > $totalResults) ? $totalResults : ($beginFormula + $gapPerPage );
        if ($totalResults > 1) {
            return "<li><a>Registros {$begin} a {$end} de {$totalResults}</a></li>";
        } else {
            return "<li><a>Exibindo registro {$begin} de {$totalResults}</a></li>";
        }
    }

    public static function quantidadePorPagina($modulo, $classe, $metodo, $pageNumber, $parametros, $porPagina) {
        $url = URL_APP . "{$modulo}/{$classe}/{$metodo}?{$parametros}"; #Modularizado
        #$url = URL_APP . "{$classe}/{$metodo}?{$parametros}"; #Não Modularizado
        $html =
                '<span id="quantidadePorPagina">' .
                "<select id=\"porPagina\" name=\"porPagina\" onchange=\"eqAlternaPorPagina(this, '{$url}', '{$parametros}')\" style='color: black;'>" .
                "<option " . ($porPagina == 10 ? "selected" : "") . " value='10'>Exibir 10 registros</option>" .
                "<option " . ($porPagina == 20 ? "selected" : "") . " value='20'>Exibir 20 registros</option>" .
                "<option " . ($porPagina == 50 ? "selected" : "") . " value='50'>Exibir 50 registros</option>" .
                "<option " . ($porPagina == 100 ? "selected" : "") . " value='100'>Exibir 100 registros</option>";
        #$html .= "<option " . ($porPagina == "T" ? "selected" : "") . " value='T'>Exibir Todos</option>";
        $html .='</select>' .
                '</span>'
        ;
        return $html;
    }
	
	###
	# EX: getPageLinksPages && quantidadePorPaginaField
	// $this->response->set("paginationLinksEntrada", Paging::getPageLinksPages("porPaginaEntrada", "pageEntrada", RelatorioAlmoxarifadoAction::getModuleName(), "RelatorioAlmoxarifado", "entradaSaidaProdutoAdmFilter", count($objectsEntrada), $resultsPerPage, $pageEntrada, "{$orderPageConditionsEntrada}{$orderPageLinksEntrada}", $this->request->get("porPaginaEntrada")));
	//	$this->response->set("perPageLinksEntrada", Paging::quantidadePorPaginaField("porPaginaEntrada", RelatorioAlmoxarifadoAction::getModuleName(), "RelatorioAlmoxarifado", "entradaSaidaProdutoAdmFilter", $pageEntrada, "{$orderPageConditionsEntrada}{$orderPageLinksEntrada}", $this->request->get("porPaginaEntrada")));
	###
	
	public static function getPageLinksPages($porPaginaValor, $pageValor, $modulo, $classe, $metodo = 'admFilter', $totalResults, $gapPerPage = 5, $pageNumber, $parametros, $porPagina) {
        $gapPerPage = 10; # GAP tem que ser fixo pq Caueh Say it so! He can explain ---> Erro de compreensão, quantidade de marcadores por página..
        $totalPages = ceil($totalResults / $gapPerPage);
        $links_total = self::getPageCountAndTotal(($pageNumber + 1), $totalResults, $gapPerPage);
        $links = array();
        if ($totalPages > 1) {
            $url = URL . "{$modulo}/{$classe}/{$metodo}?{$parametros}&{$porPaginaValor}={$porPagina}"; # MODULARIZADO
            $gap = ceil(($pageNumber + 1) / $gapPerPage);
            $begin = ($gap * $gapPerPage - $gapPerPage) + 1;
            if ($pageNumber > 0) {
                $p = 0;
                $links[] = "<li><a href=\"{$url}&{$pageValor}={$p}\">Primeira</a></li>";
            } else {
                $links[] = "<li class='disabled'><a>Primeira</a></li>";
            }
            if ($pageNumber > 0) { #novo, este vai pra página anterior
                $p = $pageNumber - 1;
                $links[] = "<li><a href=\"{$url}&page={$p}\">&larr;</a>";
            } else {
                $links[] = "<li class='disabled'><a>&larr;</a></li>";
            }
            for ($i = $begin; $i < ($begin + $gapPerPage); $i++) {
                if ($i > $totalPages)
                    break;
                $links[] = ($i != ($pageNumber + 1)) ? "<li><a href=\"{$url}&{$pageValor}=" . ($i - 1) . "\">$i</a></li>" : "<li class=\"active\"><a style='z-index:0;'>$i</a></li>"; # hack zindex
            }
            if (($pageNumber + 1) < $totalPages) { #novo, este vai pra próxima anterior
                $p = $pageNumber + 1;
                $links[] = "<li><a href=\"{$url}&{$pageValor}={$p}\">&rarr;</a></li>";
            } else {
                $links[] = "<li class='disabled'><a>&rarr;</a></li>";
            }
            if (($pageNumber + 1) < $totalPages) {
                $links[] = "<li><a href=\"{$url}&{$pageValor}=" . ($totalPages - 1) . "\">Última</a></li>";
            } else {
                $links[] = "<li class='disabled'><a>Última</a></li>";
            }
        } else {
            
        }
        $links = join("\n", $links);
        $links_pagination = "<ul class=\"pagination pagination-xs\">" .
                $links_total .
                $links .
                "</ul>"
        #"{$quantidadePorPagina}" 
        ;
        return $links_pagination;
    }

    public static function quantidadePorPaginaField($field, $modulo, $classe, $metodo, $pageNumber, $parametros, $porPagina) {
        $url = URL_APP . "{$modulo}/{$classe}/{$metodo}?{$parametros}"; #Modularizado
        #$url = URL_APP . "{$classe}/{$metodo}?{$parametros}"; #Não Modularizado
        $html = '<span id="quantidadePorPagina">' .
                "<select id=\"porPagina\" name=\"{$field}\" onchange=\"eqAlternaPorPagina(this, '{$url}', '{$parametros}')\" style='color: black;'>" .
                "<option " . ($porPagina == 10 ? "selected" : "") . " value='10'>Exibir 10 registros</option>" .
                "<option " . ($porPagina == 20 ? "selected" : "") . " value='20'>Exibir 20 registros</option>" .
                "<option " . ($porPagina == 50 ? "selected" : "") . " value='50'>Exibir 50 registros</option>" .
                "<option " . ($porPagina == 100 ? "selected" : "") . " value='100'>Exibir 100 registros</option>";
        //$html .= "<option " . ($porPagina == "T" ? "selected" : "") . " value='T'>Exibir Todos</option>";
        $html .='</select>' .
                '</span>'
        ;
        return $html;
    }

}

?>