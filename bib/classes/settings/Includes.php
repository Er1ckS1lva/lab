<?php
/**
*    Este arquivo guarda as inclusões do sistema
*    Atente para a ordem que os arquivos são incluídos para evitar falha no funcionamento
*    Adicione, preferencialmente, no final quaisquer include de arquivo
*/
include_once(dirname(__FILE__) . "/../php/mvc/Response.php");
include_once(dirname(__FILE__) . "/../php/mvc/Request.php");
include_once(dirname(__FILE__) . '/../php/orm/DoctrineBootstrap.php');
include_once(dirname(__FILE__) . "/../../eFramework/view/ViewParent.php");
include_once(dirname(__FILE__) . "/Constants.php");
include_once(dirname(__FILE__) . "/ConstantsConfig.php");

include_once(IGENIAL_ROOT_DIR . "/framework/model/doctrine/Entities.php");

#Util
include_once(dirname(__FILE__) . "/../util/UtilParent.php");
include_once(dirname(__FILE__) . "/../util/UtilAuthParent.php");

#Util/Language
include_once(dirname(__FILE__) . "/../util/i18n/Language.php");

#Util/Interface
include_once(dirname(__FILE__) . '/../util/interface/PagingParent.php');
include_once(dirname(__FILE__) . "/../util/interface/InterfaceHTMLParent.php");
include_once(dirname(__FILE__) . "/../util/interface/BreadcrumbUtilParent.php");
include_once(dirname(__FILE__) . "/../util/interface/PdfUtilParent.php");

#Util/MVC
include_once(dirname(__FILE__) . "/../util/mvc/ExceptionHandler.php");
include_once(dirname(__FILE__) . "/../util/mvc/QueryHelper.php");
include_once(dirname(__FILE__) . "/../util/mvc/ControllerUtilParent.php");
include_once(dirname(__FILE__) . "/../util/mvc/Validate.php");

#Util/File
include_once(dirname(__FILE__) . "/../util/file/FileUtilParent.php");
include_once(dirname(__FILE__) . "/../util/file/ImageUtilParent.php");
include_once(dirname(__FILE__) . "/../util/file/MediaUtilParent.php");
include_once(dirname(__FILE__) . "/../util/file/m2brimagem.class.php");

#Extensions
include_once(IGENIAL_ROOT_DIR . "/ext/Extensions.php");
