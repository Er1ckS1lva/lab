<?php

include_once(dirname(__FILE__) . '/../../model/action/RelatorioAction.php');

class RelatorioController {

    protected $request;
    protected $response;
    protected $view;
    protected $viewMethod = 'module';
    protected $gapPerPage = 10;

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    protected function auth($isOnlyAuthenticated = false) {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), $isOnlyAuthenticated)) {
            $this->view = $oUtilAuth->retornaViewLogin($this->response);
            return false;
        }
        return true;
    }

    # REDMINE 1857 e 1858 LOG DE ACESSO ----- init

    public function relLogAcessoAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relLogAcessoAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relLogAcessoAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relLogAcessoAdm() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'nome ASC', $orderPageLinks);
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelLogAcesso($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionLogAcesso());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }

        $objects = $oAction->paginatedCollectionLogAcesso($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionLogAcesso($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relLogAcessoAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relLogAcessoAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);

        #set dos grafico
        $mes = Util::retornaMesExtenso($this->request->get('mes'));
        $ano = $this->request->get('ano');
        $acessos = count($objectsCount);
        $dados = Array("['{$mes}/{$ano}', {$acessos}]");
        $this->response->set("dados", $dados);


        return new View(RelatorioAction::getModuleName() . '/Relatorio.relLogAcessoAdm.php', $this->response, $this->viewMethod);
    }

    public function relLogAcessoRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "portrait");
        }
        $this->relLogAcessoAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relLogAcessoRelPdf.php', $this->response, $method_view);
    }

    protected function filterConditionsRelLogAcesso(&$orderPageConditions) {
        $conditions = array();

        if ($this->request->get("mes") AND $this->request->get("ano")) {
            $mes = $this->request->get("mes");
            $this->response->set("mes", $mes);
            $ano = $this->request->get("ano");
            $this->response->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        } else {
            $mes = date('m');
            $this->response->set("mes", $mes);
            $this->request->set("mes", $mes);
            $ano = date('Y');
            $this->response->set("ano", $ano);
            $this->request->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        }
        return $conditions;
    }

    # REDMINE 1857 e 1858 LOG DE ACESSO ----- end
    # 
    # 
    # 
    # REDMINE 1859 e 1860 QUANTIDADE DE ACESSO POR TEMA ----- init

    public function relQuantidadeAcessoTemaAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relQuantidadeAcessoTemaAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoTemaAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoTemaAdm() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'te.titulo ASC', $orderPageLinks);
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelQuantidadeAcessoTema($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionQuantidadeAcessoTema());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }

        $objects = $oAction->paginatedCollectionQuantidadeAcessoTema($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionQuantidadeAcessoTema($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoTemaAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoTemaAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);


        #set dos grafico
        $mes = Util::retornaMesExtenso($this->request->get('mes'));
        $ano = $this->request->get('ano');
        $acessos = count($objectsCount);
        $dados = Array("['{$mes}/{$ano}', {$acessos}]");
        $this->response->set("mesGrafico", "{$mes}/{$ano}");
        $this->response->set("dados", $dados);


        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoTemaAdm.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoTemaRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "portrait");
        }
        $this->relQuantidadeAcessoTemaAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoTemaRelPdf.php', $this->response, $method_view);
    }

    protected function filterConditionsRelQuantidadeAcessoTema(&$orderPageConditions) {
        $conditions = array();

        if ($this->request->get("mes") AND $this->request->get("ano")) {
            $mes = $this->request->get("mes");
            $this->response->set("mes", $mes);
            $ano = $this->request->get("ano");
            $this->response->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        } else {
            $mes = date('m');
            $this->response->set("mes", $mes);
            $this->request->set("mes", $mes);
            $ano = date('Y');
            $this->response->set("ano", $ano);
            $this->request->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        }
        return $conditions;
    }

    # REDMINE 1859 e 1860 QUANTIDADE DE ACESSO POR TEMA ----- end
    # 
    # 
    # 
    # REDMINE 1861 e 1862 QUANTIDADE DE ACESSO POR TEMA ----- init

    public function relQuantidadeAcessoAtividadeAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relQuantidadeAcessoAtividadeAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoAtividadeAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoAtividadeAdm() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'ati.titulo ASC', $orderPageLinks);
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelQuantidadeAcessoAtividade($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionQuantidadeAcessoAtividade());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }

        $objects = $oAction->paginatedCollectionQuantidadeAcessoAtividade($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionQuantidadeAcessoAtividade($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoAtividadeAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoAtividadeAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);


        #set dos grafico
        $mes = Util::retornaMesExtenso($this->request->get('mes'));
        $ano = $this->request->get('ano');
        $acessos = count($objectsCount);
        $dados = Array("['{$mes}/{$ano}', {$acessos}]");
        $this->response->set("mesGrafico", "{$mes}/{$ano}");
        $this->response->set("dados", $dados);


        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoAtividadeAdm.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoAtividadeRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "portrait");
        }
        $this->relQuantidadeAcessoAtividadeAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoAtividadeRelPdf.php', $this->response, $method_view);
    }

    protected function filterConditionsRelQuantidadeAcessoAtividade(&$orderPageConditions) {
        $conditions = array();

        if ($this->request->get("mes") AND $this->request->get("ano")) {
            $mes = $this->request->get("mes");
            $this->response->set("mes", $mes);
            $ano = $this->request->get("ano");
            $this->response->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        } else {
            $mes = date('m');
            $this->response->set("mes", $mes);
            $this->request->set("mes", $mes);
            $ano = date('Y');
            $this->response->set("ano", $ano);
            $this->request->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        }
        return $conditions;
    }

    # REDMINE 1861 e 1862 QUANTIDADE DE ACESSO POR TEMA ----- end
    # 
    # 
    # 
    # REDMINE 1863 e 1864 QUANTIDADE DE ACESSO POR ALUNO/USUARIO ----- init

    public function relQuantidadeAcessoUsuarioAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relQuantidadeAcessoUsuarioAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoUsuarioAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoUsuarioAdm() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = "count(a.id) DESC";
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelQuantidadeAcessoUsuario($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionQuantidadeAcessoUsuario());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }
        $resultsPerPage = 15; # http://redmine.equilibriumweb.com/redmine/issues/1864#note-7

        $objects = $oAction->paginatedCollectionQuantidadeAcessoUsuario($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionQuantidadeAcessoUsuario($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoUsuarioAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoUsuarioAdmFilter", $page, "{$orderPageConditions}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);


        #set dos grafico
        $mes = Util::retornaMesExtenso($this->request->get('mes'));
        $ano = $this->request->get('ano');
        $acessos = count($objectsCount);
        $dados = Array("['{$mes}/{$ano}', {$acessos}]");
        $this->response->set("mesGrafico", "{$mes}/{$ano}");
        $this->response->set("dados", $dados);


        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoUsuarioAdm.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoUsuarioRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "portrait");
        }
        $this->relQuantidadeAcessoUsuarioAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoUsuarioRelPdf.php', $this->response, $method_view);
    }

    protected function filterConditionsRelQuantidadeAcessoUsuario(&$orderPageConditions) {
        $conditions = array();

        if ($this->request->get("mes") AND $this->request->get("ano")) {
            $mes = $this->request->get("mes");
            $this->response->set("mes", $mes);
            $ano = $this->request->get("ano");
            $this->response->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        } else {
            $mes = date('m');
            $this->response->set("mes", $mes);
            $this->request->set("mes", $mes);
            $ano = date('Y');
            $this->response->set("ano", $ano);
            $this->request->set("ano", $ano);

            $dataFim = Util::recuperarUltimoDiaMes($ano, $mes);
            $dataInicio = "01/" . $mes . "/" . $ano;

            if ($dataInicio && $dataFim) {
                $start = Util::transformaData($dataInicio, "normal2mysql");
                $end = Util::transformaData($dataFim, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        }
        return $conditions;
    }

    # REDMINE 1863 e 1864 QUANTIDADE DE ACESSO POR USUÁRIO ----- end
    # REDMINE 1865 QUANTIDADE DE ACESSO POR TEMA POR PERIODO ----- init

    public function relQuantidadeAcessoTemaPeriodoAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relQuantidadeAcessoTemaPeriodoAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoTemaPeriodoAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoTemaPeriodoAdm() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'te.titulo ASC', $orderPageLinks);
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelQuantidadeAcessoTemaPeriodo($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionQuantidadeAcessoTemaPeriodo());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }

        $objects = $oAction->paginatedCollectionQuantidadeAcessoTemaPeriodo($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionQuantidadeAcessoTemaPeriodo($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoTemaPeriodoAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoTemaPeriodoAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);

        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoTemaPeriodoAdm.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoTemaPeriodoRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "portrait");
        }
        $this->relQuantidadeAcessoTemaPeriodoAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoTemaPeriodoRelPdf.php', $this->response, $method_view);
    }

    protected function filterConditionsRelQuantidadeAcessoTemaPeriodo(&$orderPageConditions) {
        $conditions = array();

        if ($this->request->get("dataInicial") AND $this->request->get("dataFinal")) {
            $dataInicial = $this->request->get("dataInicial");
            $this->response->set("dataInicial", $dataInicial);
            $dataFinal = $this->request->get("dataFinal");
            $this->response->set("dataFinal", $dataFinal);

            if ($dataFinal && $dataInicial) {
                $start = Util::transformaData($dataInicial, "normal2mysql");
                $end = Util::transformaData($dataFinal, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        } else {
            $dataFinal = date('d/m/Y');
            $this->response->set("dataFinal", $dataFinal);
            $dataInicial = date('d/m/Y', strtotime('-15 days', strtotime(date('d-m-Y'))));
            $this->response->set("dataInicial", $dataInicial);

            if ($dataFinal && $dataInicial) {
                $start = Util::transformaData($dataInicial, "normal2mysql");
                $end = Util::transformaData($dataFinal, "normal2mysql");
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        }
        return $conditions;
    }

    # REDMINE 1865 QUANTIDADE DE ACESSO POR TEMA POR PERÍODO ----- end
    # REDMINE 1867 QUANTIDADE DE ACESSO POR ALUNO/USUARIO POR HORA ----- init

    public function relQuantidadeAcessoUsuarioHoraAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relQuantidadeAcessoUsuarioHoraAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoUsuarioHoraAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoUsuarioHoraAdm() {

        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'a.nome ASC', $orderPageLinks);
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelQuantidadeAcessoUsuarioHora($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionQuantidadeAcessoUsuarioHora());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }

        $objects = $oAction->paginatedCollectionQuantidadeAcessoUsuarioHora($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionQuantidadeAcessoUsuarioHora($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoUsuarioHoraAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoUsuarioHoraAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);

        $aHora = array();
        foreach ($objects as $o) {
            if (!(in_array($o['hora'], $aHora)))
                $aHora[] = $o['hora'];
        }

        $aAluno = array();
        foreach ($objects as $o) {
            $aAluno[$o['aluno']][$o['hora']] = $o['acesso'];
        }

        $this->response->set("aHora", $aHora);
        $this->response->set("aAluno", $aAluno);
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoUsuarioHoraAdm.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoUsuarioHoraRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "landscape");
        }
        $this->relQuantidadeAcessoUsuarioHoraAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoUsuarioHoraRelPdf.php', $this->response, $method_view);
    }

    protected function filterConditionsRelQuantidadeAcessoUsuarioHora(&$orderPageConditions) {
        $conditions = array();

        if ($this->request->get("data")) {
            $data = $this->request->get("data");
            $this->response->set("data", $data);

            $horaInicial = $this->request->get('horaInicial');
            $horaFinal = $this->request->get('horaFinal');

            if ($data && $horaInicial && $horaFinal) {
                $start = Util::transformaData($data, "normal2mysql", $horaInicial);
                $end = Util::transformaData($data, "normal2mysql", $horaFinal);
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        } else {
            $data = date("d/m/Y");
            $this->response->set("data", $data);
            $this->response->set("data", $data);

            $horaInicial = "08:00";
            $this->response->set("horaInicial", $horaInicial);
            $horaFinal = "20:00";
            $this->response->set("horaFinal", $horaFinal);

            if ($data && $horaInicial && $horaFinal) {
                $start = Util::transformaData($data, "normal2mysql", $horaInicial);
                $end = Util::transformaData($data, "normal2mysql", $horaFinal);
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        }
        return $conditions;
    }

    # REDMINE 1867 QUANTIDADE DE ACESSO POR USUÁRIO POR HORA ----- end
    # 
    # 
    # 
    # REDMINE 1866 QUANTIDADE DE ACESSO POR ATIVIDADE MENSAL ----- init

    public function relQuantidadeAcessoAtividadeMensalAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relQuantidadeAcessoAtividadeMensalAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoAtividadeMensalAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoAtividadeMensalAdm() {

        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'a.nome ASC', $orderPageLinks);
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelQuantidadeAcessoAtividadeMensal($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionQuantidadeAcessoAtividadeMensal());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }

        $objects = $oAction->paginatedCollectionQuantidadeAcessoAtividadeMensal($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionQuantidadeAcessoAtividadeMensal($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoAtividadeMensalAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relQuantidadeAcessoAtividadeMensalAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);

        $aHora = array();
        foreach ($objects as $o) {
            if (!(in_array($o['hora'], $aHora)))
                $aHora[] = $o['hora'];
        }

        $aAluno = array();
        foreach ($objects as $o) {
            $aAluno[$o['aluno']][$o['hora']] = $o['acesso'];
        }

        $this->response->set("aHora", $aHora);
        $this->response->set("aAluno", $aAluno);
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoAtividadeMensalAdm.php', $this->response, $this->viewMethod);
    }

    public function relQuantidadeAcessoAtividadeMensalRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "landscape");
        }
        $this->relQuantidadeAcessoAtividadeMensalAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relQuantidadeAcessoAtividadeMensalRelPdf.php', $this->response, $method_view);
    }

    protected function filterConditionsRelQuantidadeAcessoAtividadeMensal(&$orderPageConditions) {
        $conditions = array();

        if ($this->request->get("data")) {
            $data = $this->request->get("data");
            $this->response->set("data", $data);

            $horaInicial = $this->request->get('horaInicial');
            $horaFinal = $this->request->get('horaFinal');

            if ($data && $horaInicial && $horaFinal) {
                $start = Util::transformaData($data, "normal2mysql", $horaInicial);
                $end = Util::transformaData($data, "normal2mysql", $horaFinal);
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        } else {
            $data = date("d/m/Y");
            $this->response->set("data", $data);
            $this->response->set("data", $data);

            $horaInicial = "08:00";
            $this->response->set("horaInicial", $horaInicial);
            $horaFinal = "20:00";
            $this->response->set("horaFinal", $horaFinal);

            if ($data && $horaInicial && $horaFinal) {
                $start = Util::transformaData($data, "normal2mysql", $horaInicial);
                $end = Util::transformaData($data, "normal2mysql", $horaFinal);
                $conditions[] = " aa.dt_registro BETWEEN '$start' AND '$end' ";
            }
        }
        return $conditions;
    }

    # REDMINE 1866 QUANTIDADE DE ACESSO POR ATIVIDADE MENSAL ----- end
    # 
    # 
    # REDMINE 1949 E SUA FILHAS 1950, 1953, 1955 E 1969 ----- init

    public function relUsuarioAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->relUsuarioAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relUsuarioAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function relUsuarioAdm() {

        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'a.nome ASC', $orderPageLinks);
        $orderPageConditions = '';

        $conditions = $this->filterConditionsRelUsuario($orderPageConditions);
        $oAction = new RelatorioAction();

        # paginacao
        $fields = "*";
        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;

        if ($this->request->get("tudo")) {
            $resultsPerPage = count($oAction->collectionUsuario());
        } else {
            $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "RelatorioAlmoxarifado");
        }

        $objects = $oAction->paginatedCollectionUsuario($fields, ($page * $resultsPerPage), $resultsPerPage, $conditions, $orderSql);
        $this->response->set('objects', $objects);
        $objectsCount = $oAction->paginatedCollectionUsuario($fields, FALSE, FALSE, $conditions, $orderSql);
        $this->response->set("total", count($objectsCount));

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(RelatorioAction::getModuleName(), "Relatorio", "relUsuarioAdmFilter", count($objectsCount), $resultsPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(RelatorioAction::getModuleName(), "Relatorio", "relUsuarioAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);

        $this->response->set("objects", $objects);
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relUsuarioAdm.php', $this->response, $this->viewMethod);
    }

    public function relUsuarioRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "landscape");
        }
        $this->relUsuarioAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.relUsuarioRelPDF.php', $this->response, $method_view);
    }

    protected function filterConditionsRelUsuario(&$orderPageConditions) {
        $conditions = array();
        if ($this->request->get('nome')) {
            $conditions[] = "a.nome LIKE '%" . ($this->request->get('nome') ) . "%'";
            $this->response->set('nome', $this->request->get("nome"));
        }
        return $conditions;
    }

    public function relUsuarioDetalhe() {
        if ($this->auth() === FALSE)
            return $this->view;

        $method_view = "include";
        $id = $this->request->get('dados');
        $div = $this->request->get("div");

        $oRelatorioAction = new RelatorioAction();
        switch ($div) {
            case "div_matricula":
                $objects = $oRelatorioAction->colletionUsuarioDetalhe($id, $div);
                $this->response->set('objects', $objects);
                return new View(RelatorioAction::getModuleName() . '/Relatorio.relUsuarioDetalhe.matricula.php', $this->response, $method_view);
                break;
            case "div_avaliacao":
                $objects = $oRelatorioAction->colletionUsuarioDetalhe($id, $div);
                $this->response->set('objects', $objects);
                return new View(RelatorioAction::getModuleName() . '/Relatorio.relUsuarioDetalhe.avaliacao.php', $this->response, $method_view);
                break;
            default:
                $objects = $oRelatorioAction->colletionUsuarioDetalhe($id);
                $this->response->set('objects', $objects);
                return new View(RelatorioAction::getModuleName() . '/Relatorio.relUsuarioDetalhe.php', $this->response, $method_view);
                break;
        }
    }

    # REDMINE 1949 E SUA FILHAS 1950, 1953, 1955 E 1969 ----- end
    # 
    # BEGIN ### REDMINE 1877, RELATÓRIO POR CURSO - e os outros relatórios ficam abaixo de: Funcionalidade #1876: Relatório por Curso

    public function laboratorioAdmFilter() {
        if ($this->auth() === FALSE)
            return $this->view;
        $this->laboratorioAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.laboratorioAdmFilter.php', $this->response, $this->viewMethod);
    }

    public function laboratorioAdm() {
        if ($this->auth() === FALSE)
            return $this->view;

        $oRelatorioAction = new RelatorioAction();

        # paginacao
        $fields = array(
            "DISTINCT o.id AS ID",
            "o.titulo",
            "(SELECT COUNT(*) FROM tema WHERE tema.id_laboratorio=o.id) AS temas",
            "(SELECT COUNT(DISTINCT aa.id_aluno) FROM tema t INNER JOIN atividade a ON t.id = a.id_tema INNER JOIN aluno_atividade aa ON a.id = aa.id_atividade WHERE t.id_laboratorio=o.id) AS participantes",
            "(SELECT COUNT(*) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id) AS acessos",
            "(SELECT COUNT(*) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id)/(SELECT COUNT(DISTINCT id) FROM aluno) AS medias_acesso",
            "(SELECT MIN(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id) AS primeiro_acesso",
            "(SELECT MAX(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id) AS ultimo_acesso",
        );
        $orderPageConditions = '';
        $aConditions = $this->filterConditionsLaboratorio($this->request, $this->response, $orderPageConditions);
        $orderSql = ControllerUtil::orderFunction($this->request, $this->response, 'o.titulo ASC', $orderPageLinks);

        $page = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;
        $this->gapPerPage = (int) $this->request->get("porPagina") ? (int) $this->request->get("porPagina") : $this->gapPerPage;
        $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "Relatorio");

        $aJoin = array();

        $objects = $oRelatorioAction->paginatedCollectionNative("laboratorio", $fields, $aConditions, $aJoin, $orderSql, NULL, $resultsPerPage, $page);
        $aTotal = $oRelatorioAction->paginatedCollectionNative("laboratorio", "COUNT(DISTINCT o.id) AS TOTAL", $aConditions, $aJoin);
        $total = $aTotal[0]["TOTAL"];

        $this->response->set("orderPageConditions", $orderPageConditions);
        $this->response->set("orderPageLinks", $orderPageLinks);
        $this->response->set("objects", $objects);
        $this->response->set("total", $total);
        $this->response->set("resultsInPage", $resultsPerPage);
        $this->response->set("paginationLinks", Paging::getPageLinks(PerfilAction::getModuleName(), "Relatorio", "laboratorioAdmFilter", $total, $this->gapPerPage, $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("perPageLinks", Paging::quantidadePorPagina(PerfilAction::getModuleName(), "Relatorio", "laboratorioAdmFilter", $page, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
        $this->response->set("currentPage", $page);

        return new View(RelatorioAction::getModuleName() . '/Relatorio.laboratorioAdm.php', $this->response, $this->viewMethod);
    }

    public function filterConditionsLaboratorio(&$request, &$response, &$orderPageConditions, $alias = "o", $conditions = array()) {
        if ($request->get('titulo')) {
            $conditions[] = "{$alias}.titulo LIKE '%" . ($request->get('titulo') ) . "%'";
            $orderPageConditions .= "&titulo={$request->get('titulo')}";
            $response->set('titulo', $request->get("titulo"));
        }

        return $conditions;
    }

    public function laboratorioRelPDF() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action")))
            return $oUtilAuth->retornaViewLogin($this->response);

        if ($this->request->get("porPagina") === "T") {
            $method_view = "include";
            $this->response->set("porPagina", $this->request->get("porPagina"));
        } else {
            $method_view = "relPdf";
            $this->response->set("pdf-engine", "wkhtmltopdf");
            $this->response->set("orientacao", $this->request->get('orientation') ? $this->request->get('orientation') : "landscape");
        }
        $this->laboratorioAdm();
        return new View(RelatorioAction::getModuleName() . '/Relatorio.laboratorioRelPDF.php', $this->response, $method_view);
    }

    #1878

    public function laboratorioDetalhe() {
        $id = $this->request->get('dados');

        $fields = array(
            "DISTINCT o.id AS ID",
            "o.titulo",
            "(SELECT COUNT(*) FROM tema WHERE tema.id_laboratorio=o.id) AS temas",
            "(SELECT COUNT(DISTINCT aa.id_aluno) FROM tema t INNER JOIN atividade a ON t.id = a.id_tema INNER JOIN aluno_atividade aa ON a.id = aa.id_atividade WHERE t.id_laboratorio=o.id) AS participantes",
            "(SELECT COUNT(*) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id) AS acessos",
            "(SELECT COUNT(*) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id)/(SELECT COUNT(DISTINCT id) FROM aluno) AS medias_acesso",
            "(SELECT MIN(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id) AS primeiro_acesso",
            "(SELECT MAX(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio=o.id) AS ultimo_acesso",
        );
        $aConditions = "o.id = '{$id}'";
        $aJoin = array();
        $oRelatorioAction = new RelatorioAction();
        $object = $oRelatorioAction->selectNative("laboratorio", $fields, $aConditions, $aJoin);
        $this->response->set("object", $object);

        switch ($this->request->get("div")) {
            case 'div_alunos':
                # paginacao - alunos #1879
                $fieldsSub = array(
                    "DISTINCT o.id AS ID",
                    "o.nome",
                    "o.email",
                    "o.dt_cadastro",
                    "(SELECT COUNT(*) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio='{$id}' AND aa.id_aluno=o.id) AS acessos",
                    "(SELECT MIN(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio='{$id}' AND aa.id_aluno=o.id) AS primeiro_acesso",
                    "(SELECT MAX(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio='{$id}' AND aa.id_aluno=o.id) AS ultimo_acesso",
                );
                $orderPageConditions = '';
                $aConditionsSub = array("EXISTS (SELECT (aa.id_aluno) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio='{$id}' AND aa.id_aluno=o.id)");
                if ($this->request->get('nome')) {
                    $aConditionsSub[] = "o.nome LIKE '%" . ($this->request->get('nome') ) . "%'";
                    $orderPageConditions .= "&nome={$this->request->get('nome')}";
                    $this->response->set('nome', $this->request->get("nome"));
                }
                if ($this->request->get('sem')) {
                    $aConditionsSub = array("NOT EXISTS (SELECT (aa.id_aluno) FROM aluno_acesso aa WHERE aa.id_aluno = o.id)");
                    $orderPageConditions .= "&sem={$this->request->get('sem')}";
                    $this->response->set('sem', $this->request->get("sem"));
                }
                $orderPageLinks = "&div=div_alunos";
                $orderSqlSub = ControllerUtil::orderFunction($this->request, $this->response, 'o.nome ASC', $orderPageLinks);

                $pageSub = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;
                $this->gapPerPage = (int) $this->request->get("porPagina") ? (int) $this->request->get("porPagina") : $this->gapPerPage;
                $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "Relatorio");

                $aJoinSub = array();

                $objects = $oRelatorioAction->paginatedCollectionNative("aluno", $fieldsSub, $aConditionsSub, $aJoinSub, $orderSqlSub, NULL, $resultsPerPage, $pageSub);
                $aTotal = $oRelatorioAction->paginatedCollectionNative("aluno", "COUNT(DISTINCT o.id) AS TOTAL", $aConditionsSub, $aJoinSub);
                $total = $aTotal[0]["TOTAL"];

                $this->response->set("orderPageConditions", $orderPageConditions);
                $this->response->set("orderPageLinks", $orderPageLinks);
                $this->response->set("objects", $objects);
                $this->response->set("total", $total);
                $this->response->set("resultsInPage", $resultsPerPage);
                $this->response->set("paginationLinks", Paging::getAjaxPageLinks($oRelatorioAction->getModuleName() . "/Relatorio/laboratorioDetalhe", $total, $this->gapPerPage, $this->request->get("porPagina"), $pageSub, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("div")));
                $this->response->set("perPageLinks", Paging::quantidadePorPagina(PerfilAction::getModuleName(), "Relatorio", "laboratorioDetalhe", $pageSub, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
                $this->response->set("currentPage", $pageSub);

                return new View(RelatorioAction::getModuleName() . '/Relatorio.laboratorioDetalhe.alunos.php', $this->response, "include");
                break;
            case 'div_avaliacao':
                # paginacao avaliacao #1939
                $fieldsSub = array(
                    "DISTINCT o.id AS ID",
                    "o.nome",
                );
                $orderPageConditions = '';
                $aConditionsSub = array("EXISTS (SELECT (aa.id_aluno) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE t.id_laboratorio='{$id}' AND aa.id_aluno=o.id)");
                if ($this->request->get('nome')) {
                    $aConditionsSub[] = "o.nome LIKE '%" . ($this->request->get('nome') ) . "%'";
                    $orderPageConditions .= "&nome={$this->request->get('nome')}";
                    $this->response->set('nome', $this->request->get("nome"));
                }
                $orderPageLinks = "&div=div_avaliacao";
                $orderSqlSub = ControllerUtil::orderFunction($this->request, $this->response, 'o.nome ASC', $orderPageLinks);

                $pageSub = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;
                $this->gapPerPage = (int) $this->request->get("porPagina") ? (int) $this->request->get("porPagina") : $this->gapPerPage;
                $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "Relatorio");

                $aJoinSub = array();

                $objects = $oRelatorioAction->paginatedCollectionNative("aluno", $fieldsSub, $aConditionsSub, $aJoinSub, $orderSqlSub, NULL, $resultsPerPage, $pageSub);
                $aTotal = $oRelatorioAction->paginatedCollectionNative("aluno", "COUNT(DISTINCT o.id) AS TOTAL", $aConditionsSub, $aJoinSub);
                $total = $aTotal[0]["TOTAL"];

                $this->response->set("orderPageConditions", $orderPageConditions);
                $this->response->set("orderPageLinks", $orderPageLinks);
                $this->response->set("objects", $objects);
                $this->response->set("total", $total);
                $this->response->set("resultsInPage", $resultsPerPage);
                $this->response->set("paginationLinks", Paging::getAjaxPageLinks($oRelatorioAction->getModuleName() . "/Relatorio/laboratorioDetalhe", $total, $this->gapPerPage, $this->request->get("porPagina"), $pageSub, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("div")));
                $this->response->set("perPageLinks", Paging::quantidadePorPagina(PerfilAction::getModuleName(), "Relatorio", "laboratorioDetalhe", $pageSub, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
                $this->response->set("currentPage", $pageSub);

                # COLOQUEI ABAIXO POIS JÁ TEM O ALUNO - avaliacao #1939
                $fieldsExt = array(
                    "DISTINCT o.id AS ID",
                    "o.titulo AS titulo",
                    "'100' AS escala",
                    "(SELECT AVG(score) FROM aluno_atividade_envios WHERE id_atividade = o.id) AS media",
                    "(SELECT COUNT(DISTINCT aluno_atividade_envios.id_aluno) FROM aluno_atividade_envios WHERE id_atividade = o.id) AS alunos",
                    "o.tipo AS tipo",
                );
                $aConditionsExt = "te.id_laboratorio = '{$id}'";
                $aJoinExt = array();
                $aJoinExt[] = array(
                    "type" => "INNER",
                    "table" => "tema",
                    "alias" => "te",
                    "joinConditions" => "o.id_tema = te.id"
                );
                $aAvaliacao = $oRelatorioAction->collectionNative("atividade", $fieldsExt, $aConditionsExt, $aJoinExt, "o.titulo");
                $this->response->set("aAvaliacao", $aAvaliacao);

                $aAvaliacaoAluno = array();
                if ($aAvaliacao && $objects) {
                    foreach ($aAvaliacao as $oAvaliacao) {
                        foreach ($objects as $o) {
                            $oScore = $oRelatorioAction->getTotalScore($oAvaliacao["ID"], $o["ID"]);
                            $aAvaliacaoAluno[$oAvaliacao["ID"]][$o["ID"]] = $oScore["score"];
                        }
                    }
                }
                $this->response->set("aAvaliacaoAluno", $aAvaliacaoAluno);

                return new View(RelatorioAction::getModuleName() . '/Relatorio.laboratorioDetalhe.avaliacao.php', $this->response, "include");
                break;

            case "div_tema":
                # paginacao - tema/atividade #1941
                $fieldsSub = array(
                    "DISTINCT o.id AS ID",
                    "o.titulo",
                );
                $orderPageConditions = '';
                $aConditionsSub = array("o.id_laboratorio='{$id}'");
                if ($this->request->get('titulo')) {
                    $aConditionsSub[] = "o.titulo LIKE '%" . ($this->request->get('titulo') ) . "%'";
                    $orderPageConditions .= "&titulo={$this->request->get('titulo')}";
                    $this->response->set('titulo', $this->request->get("titulo"));
                }
                $orderPageLinks = "&div=div_tema";
                $orderSqlSub = ControllerUtil::orderFunction($this->request, $this->response, 'o.titulo ASC', $orderPageLinks);

                $pageSub = (int) $this->request->get("page") ? (int) $this->request->get("page") : 0;
                $this->gapPerPage = (int) $this->request->get("porPagina") ? (int) $this->request->get("porPagina") : $this->gapPerPage;
                $resultsPerPage = ControllerUtil::porPagina($this->request, $this->response, "Relatorio");

                $aJoinSub = array();

                $objects = $oRelatorioAction->paginatedCollectionNative("tema", $fieldsSub, $aConditionsSub, $aJoinSub, $orderSqlSub, NULL, $resultsPerPage, $pageSub);
                $aTotal = $oRelatorioAction->paginatedCollectionNative("tema", "COUNT(DISTINCT o.id) AS TOTAL", $aConditionsSub, $aJoinSub);
                $total = $aTotal[0]["TOTAL"];

                $this->response->set("orderPageConditions", $orderPageConditions);
                $this->response->set("orderPageLinks", $orderPageLinks);
                $this->response->set("objects", $objects);
                $this->response->set("total", $total);
                $this->response->set("resultsInPage", $resultsPerPage);
                $this->response->set("paginationLinks", Paging::getAjaxPageLinks($oRelatorioAction->getModuleName() . "/Relatorio/laboratorioDetalhe", $total, $this->gapPerPage, $this->request->get("porPagina"), $pageSub, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("div")));
                $this->response->set("perPageLinks", Paging::quantidadePorPagina(PerfilAction::getModuleName(), "Relatorio", "laboratorioDetalhe", $pageSub, "{$orderPageConditions}{$orderPageLinks}", $this->request->get("porPagina")));
                $this->response->set("currentPage", $pageSub);

                # atividades dos temas
                $fieldsExt = array(
                    "DISTINCT o.id AS ID",
                    "'' AS atividade",
                    "'' AS tipo",
                    "'' AS quantidade",
                    "'' AS acessos",
                    "'' AS media",
                    "'' AS primeiro_acesso",
                    "'' AS ultimo_acesso",
                );
                $aJoinExt = array();

                $aAtividadeTema = array();
                if ($objects) {
                    $fieldsExt = array(
                        "DISTINCT o.id AS ID",
                        "o.titulo AS titulo",
                        "o.tipo AS tipo",
                        "(SELECT COUNT(DISTINCT aluno_atividade_envios.id_aluno) FROM aluno_atividade_envios WHERE id_atividade = o.id) AS quantidade",
                        "(SELECT COUNT(*) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE a.id=o.id) AS acessos",
                        "(SELECT COUNT(*) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE a.id=o.id)/(SELECT COUNT(DISTINCT id) FROM aluno) AS medias_acesso",
                        "(SELECT MIN(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE a.id=o.id) AS primeiro_acesso",
                        "(SELECT MAX(aa.dt_registro) FROM tema t INNER JOIN atividade a on t.id = a.id_tema INNER JOIN aluno_acesso aa ON a.id=aa.id_atividade WHERE a.id=o.id) AS ultimo_acesso",
                    );
                    $aJoinExt = array();
                    foreach ($objects as $o) {
                        $aConditionsExt = "o.id_tema = '{$o["ID"]}'";
                        $aAtividadeTema[$o["ID"]] = $oRelatorioAction->collectionNative("atividade", $fieldsExt, $aConditionsExt, $aJoinExt, "o.titulo");
                    }
                }
                $this->response->set("aAtividadeTema", $aAtividadeTema);


                return new View(RelatorioAction::getModuleName() . '/Relatorio.laboratorioDetalhe.tema.php', $this->response, "include");
                break;
            default:
                break;
        }

        return new View(RelatorioAction::getModuleName() . '/Relatorio.laboratorioDetalhe.php', $this->response, "include");
    }

    # END ### REDMINE 1877, RELATÓRIO POR CURSO - e os outros relatórios ficam abaixo de: Funcionalidade #1876: Relatório por Curso
}

?>