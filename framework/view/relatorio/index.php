<?php
$_oUsuarioAutenticado = UtilAuth::recuperaObjetoUsuario();
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title> <?= APPLICATION_NAME ?> - <?= $this->aModules[URL_APP . $this->module . "/"]["descricao"] ?> </title>
        <meta name="description" content="">
        <meta name="author" content="">
        <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/header.php'; ?>
        <?php include "{$this->dir}/{$this->module}/inc/header.php"; ?>
    </head>
    <body class="">
        <?php include "{$this->dir}/app/inc/topo.php"; ?>
        <div id="main" role="main">
            <div id="ribbon">
                <ol class="breadcrumb">
                    <?php
                    if (class_exists("{$this->classe}Controller")) {
                        $oBreadcrumb = new BreadcrumbUtil(URL_APP, $this->module, $this->classe, $this->metodo);
                        $oBreadcrumb->create();
                    }
                    ?>
                </ol>
            </div>
            <div id="content">
                <?php include $this->dir . '/app/inc/alert-modals.php' ?>
                <section id="widget-grid" class="">
                    <?php
                    if ($this->name && file_exists("{$this->dir}/{$this->name}")) {
                        include "{$this->dir}/{$this->name}";
                    } elseif ($this->name == "Defaultview.index") {
                        define("IS_MODULE_INDEX", 1);
                        include $this->dir . '/app/Defaultview.index.php';
                    } else {
                        echo '<form class="well well-large">',
                        "Arquivo '<strong>{$this->module}/{$this->name}</strong>' não encontrado!",
                        "</form>";
                    }
                    ?>
                </section>
            </div>
        </div>
        <?php include IGENIAL_ROOT_DIR . '/bib/eFramework/view/inc/footer.js.php'; ?>
    </body>
</html>