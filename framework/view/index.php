<?php
$_oUsuarioAutenticado = UtilAuth::recuperaObjetoUsuario();
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title> <?= APPLICATION_NAME ?> </title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Use the correct meta names below for your web application
                 Ref: http://davidbcalhoun.com/2010/viewport-metatag 
                 
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">-->
        <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/header.php'; ?>
        <?php #include "{$this->dir}/app/inc/headers.php"; # TODOS OS HEADERS ?>

    </head>
    <body class="">
        <!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->

        <?php include "{$this->dir}/app/inc/topo.php"; ?>

        <!-- MAIN PANEL -->
        <div id="main" role="main">

            <!-- RIBBON -->
            <div id="ribbon">

                <!--<span class="ribbon-button-alignment"> <span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true"><i class="fa fa-refresh"></i></span> </span>-->

                <!-- breadcrumb -->
                <ol class="breadcrumb">
                    <?php
                    if (class_exists("{$this->classe}Controller")) {
                        $oBreadcrumb = new BreadcrumbUtil(URL_APP, $this->module, $this->classe, $this->metodo);
                        $oBreadcrumb->create();
                    }
                    ?>
                    <?php
                    /*
                      $classe = Util::recuperaNomeEntidade($this->classe);
                      eval("\$o = new {$classe}Action();");
                      echo $o->getEntityName();
                     */
                    ?>
                </ol>
                <!-- end breadcrumb -->

                <!-- You can also add more buttons to the
                ribbon for further usability
    
                Example below:
    
                <span class="ribbon-button-alignment pull-right">
                <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
                <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
                <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
                </span> -->

            </div>
            <!-- END RIBBON -->

            <!-- MAIN CONTENT -->
            <div id="content">
                <?php include $this->dir . '/app/inc/alert-modals.php'?>
                <!--                <div class="row">
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        <h1 class="page-title txt-color-blueDark">
                
                                             PAGE HEADER 
                                            <i class="fa-fw fa fa-pencil-square-o"></i> 
                                            Forms
                                            <span>>  
                                                Form Layouts
                                            </span>
                                        </h1>
                                    </div>
                
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                         Button trigger modal 
                                        <a data-toggle="modal" href="#myModal" class="btn btn-success btn-lg pull-right header-btn hidden-mobile"><i class="fa fa-circle-arrow-up fa-lg"></i> Launch form modal</a>
                                    </div>
                                </div>-->

                <!-- widget grid -->
                <section id="widget-grid" class="">
                    <?php
                    if ($this->name && file_exists("{$this->dir}/{$this->name}")) {
                        include "{$this->dir}/{$this->name}";
                    } elseif($this->name == "Defaultview.index") {
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
            <!-- END MAIN CONTENT -->

        </div>
        <!-- END MAIN PANEL -->

        <!--================================================== -->
        <?php include IGENIAL_ROOT_DIR . '/bib/eFramework/view/inc/footer.js.php'; ?>
    </body>
</html>

<? /** / ?>
  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
  <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/header.php'; ?>
  <?php include "{$this->dir}/app/inc/headers.php"; ?>


  <?php
  # parte que esconde as opcoes da listagem caso nao tenha permissao
  $action = explode(".", $_REQUEST["action"]);
  $action = strToLower($action[1]);
  ?>
  <?php if ($action == "admfilter" OR $action == "adm") { ?>
  <script>
  $(document).ready(function() {
  <?php if (!UtilAuth::temPermissaoRequest($_REQUEST["action"], "Edit")) { ?>
  $(".edicao").remove();
  <?php } ?>
  <?php if (!UtilAuth::temPermissaoRequest($_REQUEST["action"], "Del")) { ?>
  $(".delecao").remove();
  <?php } ?>

  <?php if (!UtilAuth::temPermissaoRequest($_REQUEST["action"], "Edit") && !UtilAuth::temPermissaoRequest($_REQUEST["action"], "Del")) { ?>
  $(".acoes").remove();
  <?php } ?>
  })
  </script>
  <?php } ?>


  </head>
  <body data-color="grey" class="flat">
  <div id="wrapper">
  <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/modals.php'; ?>
  <div id="header">
  <h1><a href="<?= URL_APP ?>">Painel Administrativo - iGenial</a></h1>
  <a id="menu-trigger" href="#"><i class="icon-align-justify"></i></a>
  </div>

  <?php $oUsuario = UtilAuth::recuperaObjetoUsuario(); ?>
  <div id="user-nav">
  <ul class="btn-group">
  <li class="btn dropdown" id="menu-perfil">
  <a href="#" data-toggle="dropdown" data-target="#menu-perfil" class="dropdown-toggle tip-left" title="Minha conta">
  <?php $img = MediaUtil::getLinkForFileNameById('Usuario', "{$oUsuario->getId()}_m"); ?>
  <?php if ($img != "javascript: void(0);") { ?>
  <div id="user-top" class="pull-left">
  <img width="33" height="33" class="img-thumbnail" alt="User" src="<?= $img ?>">
  </div>
  <?php } else { ?>
  <i class="icon-user"></i>
  <span class="text">Conta</span>
  <?php } ?>
  <?= $oUsuario->getLogin() ?>
  <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
  <li><a class="tip-left" title="Meus dados" href="<?= URL_SEGURANCA_USUARIO_DADOS_PESSOAIS ?>"><i class="icon-user"></i> <span class="text">Meus Dados</span></a></li>
  <li><a class="tip-left" title="Troque sua senha periódicamente" href="<?= URL_SEGURANCA_USUARIO_TROCAR_SENHA ?>"><i class="icon-lock"></i> <span class="text">Trocar Senha</span></a></li>
  <li><a class="tip-left" title="Visualizar o que posso fazer" href="<?= URL_SEGURANCA_MEU_PERFIL ?>"><i class="icon-eye-open"></i> <span class="text">Meu Perfil</span></a></li>
  </ul>
  </li>
  <?php if ($oUsuario->getSuperuser()) { ?>
  <li class="btn dropdown" id="menu-config">
  <a class="tip-left" title="Segurança" href="#" data-toggle="dropdown" data-target="#menu-config" class="dropdown-toggle"><i class="icon-cog"></i>
  <span class="text">Administração</span>
  <b class="caret"></b>
  </a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="administracao">
  <li role="presentation"><a role="menuitem" class="tip-left" title="Gerenciar usuários" href="<?= URL_APP ?>Usuario/"><i class="icon-user"></i> Usuários</a></li>
  <li role="presentation"><a role="menuitem" class="tip-left" title="Gerenciar perfís" href="<?= URL_APP ?>Perfil/"><i class="icon-group"></i> Perfís</a></li>
  <li role="presentation"><a role="menuitem" class="tip-left" title="Gerenciar entidades" href="<?= URL_APP ?>Entidade/"><i class="icon-tags"></i> Entidade</a></li>
  <li role="presentation"><a role="menuitem" class="tip-left" title="Gerenciar módulos" href="<?= URL_APP ?>Modulo/"><i class="icon-tag"></i> Módulos</a></li>
  <li role="presentation"><a role="menuitem" class="tip-left" title="Gerenciar ações" href="<?= URL_APP ?>Acao/"><i class="icon-tasks"></i> Ações</a></li>
  <li role="presentation" class="divider"></li>
  <li role="presentation"><a role="menuitem" class="tip-left" title="Consultar Log" href="<?= URL_APP ?>Log/"><i class="icon-eye-open"></i> Log</a></li>
  <li role="presentation" class="divider"></li>
  <li role="presentation"><a role="menuitem" class="tip-left" title="Gerar ações" href="#confirmationModal" data-toggle="modal" onclick="eqConfirmDialog('Gerar ações do sistema?', 'Acao.carrega', 'eqAcaoCarregaHandler')"><i class="icon-power-off"></i> Gerar Ações</a></li>
  </ul>
  </li>
  <li class="btn" ><a class="tip-bottom" title="Configure o sistema" href="<?= URL_APP ?>Configuracao/"><i class="icon-wrench"></i> <span class="text">Configuração</span></a></li>
  <?php } ?>
  <li class="btn"><a class="tip-bottom" title="Log-out" href="<?= URL_LOGOUT ?>"><i class="icon-signout"></i> <span class="text">Sair</span></a></li>
  </ul>
  </div>

  <div id="sidebar">
  <div id="search">
  <input type="text" placeholder="Buscar no Menu"/><button type="submit" class="tip-bottom" title="Search"><i class="icon-search"></i></button>
  </div>
  <ul selectedEntity="<?= $this->classe ?>">
  <?php include 'inc/menu.php'; ?>
  </ul>

  </div>

  <div id="content">
  <div id="content-header">
  <h1><?php
  $classe = Util::recuperaNomeEntidade($this->classe);
  eval("\$o = new {$classe}Action();");
  echo $o->getEntityName();
  ?></h1>
  <div class="btn-group">
  <a title="Manage Comments" class="btn btn-large">
  <i class="icon-comment"></i><span class="label label-info">5</span>
  </a>
  <a title="Manage Comments" class="btn btn-large">
  <i class="icon-eye-open"></i><span class="label label-danger">2</span>
  </a>
  </div>
  </div>
  <div id="breadcrumb">
  <?php
  if (class_exists("{$this->classe}Controller")) {
  $oBreadcrumb = new BreadcrumbUtil(URL_APP, NULL, $this->classe, $this->metodo);
  $oBreadcrumb->create();
  }
  ?>
  </div>
  <div id="alert-box"></div>
  <div class="container-fluid">
  <?php
  if ($this->name && file_exists("{$this->dir}/{$this->name}")) {
  include "{$this->dir}/{$this->name}";
  } else {
  echo '<form class="well well-large">',
  "Arquivo '<strong>{$this->module}/{$this->name}</strong>' não encontrado!",
  "</form>";
  }
  ?>
  </div>
  </div>
  <?php include "{$this->dir}/" . URL_BIB_VIEW . 'inc/footer.php'; ?>
  </div>
  </body>
  </html>
  <? /* */ ?>