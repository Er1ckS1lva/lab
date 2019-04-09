<?php

include_once(dirname(__FILE__).'/controllers/UsuarioController.php');
include_once(dirname(__FILE__).'/controllers/PerfilController.php');
include_once(dirname(__FILE__).'/controllers/ModuloController.php');
include_once(dirname(__FILE__).'/controllers/EntidadeController.php');
include_once(dirname(__FILE__).'/../model/action/PermissaoAction.php');
include_once(dirname(__FILE__).'/controllers/AcaoController.php');
include_once(dirname(__FILE__).'/controllers/ConfiguracaoController.php');
include_once(dirname(__FILE__).'/controllers/LogController.php');
include_once(dirname(__FILE__).'/controllers/ModuloMenuController.php');
include_once(dirname(__FILE__).'/../model/action/PerfilModuloMenuAction.php');
include_once(dirname(__FILE__).'/controllers/PortalController.php');
include_once(dirname(__FILE__).'/controllers/LaboratorioController.php');
include_once(dirname(__FILE__).'/controllers/TemaController.php');
include_once(dirname(__FILE__).'/../model/action/TemaIdiomaAction.php');
include_once(dirname(__FILE__).'/controllers/AtividadeController.php');
include_once(dirname(__FILE__).'/../model/action/AtividadeIdiomaAction.php');
include_once(dirname(__FILE__).'/../model/action/ConteudoAction.php');
include_once(dirname(__FILE__).'/../model/action/ConteudoArquivoAction.php');
include_once(dirname(__FILE__).'/../model/action/AtividadeOpcaoAction.php');
include_once(dirname(__FILE__).'/../model/action/ConteudoFormularioAction.php');
include_once(dirname(__FILE__).'/../model/action/FormularioOpcaoAction.php');
include_once(dirname(__FILE__).'/controllers/AlunoController.php');
include_once(dirname(__FILE__).'/../model/action/AlunoAtividadeAction.php');
include_once(dirname(__FILE__).'/../model/action/AlunoAtividadeEnviosAction.php');
include_once(dirname(__FILE__).'/controllers/IdiomaController.php');
include_once(dirname(__FILE__).'/controllers/PaginaController.php');
include_once(dirname(__FILE__).'/../model/action/PaginaIdiomaAction.php');
include_once(dirname(__FILE__).'/../model/action/AlunoAcessoAction.php');
include_once(dirname(__FILE__).'/controllers/RelatorioController.php');



include_once(dirname(__FILE__)."/../../bib/eFramework/controller/FrontControllerParent.php");
include_once(dirname(__FILE__)."/../view/View.php");

class FrontController extends FrontControllerParent {

    public function __construct() {
        parent::__construct();        
    }

}

?>
