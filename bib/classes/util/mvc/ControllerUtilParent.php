<?php

class ControllerUtil {

    public static function orderFunction(&$request, &$response, $mainOrderAttribute, &$orderPageLinks = '') {
        $orderAscDesc = $request->get('orderAscDesc');
        ControllerUtil::orderInverteAscDesc($orderAscDesc, $response);

        if ($request->get("order") != "") {
            $response->set("order", $request->get("order"));
            $orderPageLinks = "&order={$request->get("order")}&orderAscDesc={$orderAscDesc}";
            $orderSql = "{$request->get("order")} {$orderAscDesc}";
        } else {
            $orderSql = $mainOrderAttribute;
        }
        return $orderSql;
    }

    public static function orderInverteAscDesc($orderAscDesc, $response = null) {
        $order = "";
        if ($orderAscDesc == "ASC" || !$orderAscDesc) {
            $order = "DESC";
        } else if ($orderAscDesc == "DESC") {
            $order = "ASC";
        }

        if ($response) {
            $response->set('orderAscDesc', $order);
        }
        return $order = (!$order && isset($_REQUEST["orderAscDesc"]) ? $_REQUEST["orderAscDesc"] : $order);
    }

    public static function porPagina(&$request, &$response, $class) {
        $resultsPerPage = (!defined(POR_PAGINA)) ? POR_PAGINA : 10;
        if ($request->get("porPagina") == "T") {
            @ini_set("memory_limit", (!defined(MAXIMUM_MEMORY_REL)) ? MAXIMUM_MEMORY_REL : '64M');
            eval("\$o{$class}Action = new {$class}Action();");
            eval("\$resultsPerPage = \$o{$class}Action->totalRegistros();");
            $response->set("resultsPerPage", $resultsPerPage);
            $response->set("porPagina", "&porPagina={$resultsPerPage}");
        } elseif ($request->get("porPagina")) {
            $resultsPerPage = $request->get("porPagina");
            $response->set("resultsPerPage", $resultsPerPage);
            $response->set("porPagina", "&porPagina={$resultsPerPage}");
        }
        return $resultsPerPage;
    }

    public static function objectsToSuggest($action, $objects, $page, $getPk = 'getId') {
        $objectsFoundList = array();
        if ($objects) {
            foreach ($objects as $o) {
                $objectsFoundList[] = array("id" => $o->$getPk(), "desc" => $action->suggestDesc($o), "descHtml" => $action->suggestDescHtml($o));
            }
        } else {
            if ($page === 0) { # so mostrará na primeira página = 0
                $objectsFoundList[] = array("id" => NULL, "desc" => "Nenhum registro encontrado", "descHtml" => NULL);
            }
        }
        return json_encode($objectsFoundList);
    }

}

?>