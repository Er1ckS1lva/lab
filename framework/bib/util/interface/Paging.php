<?php

class Paging extends PagingParent {

    public static function getAjaxPageLinks($metodo, $totalResults, $gapPerPage = 5, $porPagina = 10, $pageNumber, $parametros, $divTarget) {
        $totalPages = ceil($totalResults / $gapPerPage);
        $links_total = self::getPageCountAndTotal(($pageNumber + 1), $totalResults, $gapPerPage);
        $links_total = $totalResults ? $links_total : "";
        $links = array();

        if ($totalPages > 1) {
            $url = URL . "{$metodo}?{$parametros}";
            $gap = ceil(($pageNumber + 1) / $gapPerPage);
            $begin = ($gap * $gapPerPage - $gapPerPage) + 1;

            if ($pageNumber > 0) { #novo, este vai pra página anterior
                $p = $pageNumber - 1;
                $links[] = "<li><a href=\"javascript:;\" onclick=\"paginateAjax('{$url}&porPagina={$porPagina}&page={$p}', '{$divTarget}');\">Voltar</a>";
            } else {
                $links[] = "<li class='disabled'><a>Voltar</a></li>";
            }
            for ($i = $begin; $i < ($begin + $gapPerPage); $i++) {
                if ($i > $totalPages)
                    break;
                $links[] = ($i != ($pageNumber + 1)) ? "<li><a href=\"javascript:;\" onclick=\"paginateAjax('{$url}&porPagina={$porPagina}&page=" . ($i - 1) . "', '{$divTarget}');\">$i</a></li>" : "<li class=\"active\"><a>$i</a></li>";
            }
            if (($pageNumber + 1) < $totalPages) { #novo, este vai pra próxima anterior
                $p = $pageNumber + 1;
                $links[] = "<li><a href=\"javascript:;\" onclick=\"paginateAjax('{$url}&porPagina={$porPagina}&page={$p}', '{$divTarget}');\">Avançar</a></li>";
            } else {
                $links[] = "<li class='disabled'><a>Avançar</a></li>";
            }
        } else {
            
        }

        $links = join("\n", $links);
        $links_pagination = ''
                . '<div class="row text-center fontsize-14px padding-top-100">'
                . '<div class="ol-md-12 paginacao">' .
                "<ul class='pagination'>" .
                $links_total .
                $links .
                "</ul>" .
                '</div>' .
                '</div>'
//                . $gapPerPage
        ;
        return $links_pagination;
    }

}

?>