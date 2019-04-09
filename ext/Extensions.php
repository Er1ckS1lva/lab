<?php
/**
*    Este arquivo guarda as inclusões da(s) extensão(ões) que os sistema pode utilziar
*    Adicione, preferencialmente, no final quaisquer include de arquivo (se usar, substitua o modelo, não deixe-o comentado!)
*/
#System Includes
include_once(dirname(__FILE__) . "/doctrine/vendor/autoload.php"); #DOCTRINE
include_once(dirname(__FILE__) . "/../framework/bib/util/Util.php");
include_once(dirname(__FILE__) . "/../framework/bib/util/UtilAuth.php");

#Util/File
include_once(dirname(__FILE__) . "/../framework/bib/util/file/FileUtil.php");
include_once(dirname(__FILE__) . "/../framework/bib/util/file/ImageUtil.php");
include_once(dirname(__FILE__) . "/../framework/bib/util/file/MediaUtil.php");

#Util/Interface
include_once(dirname(__FILE__) . "/../framework/bib/util/interface/BreadcrumbUtil.php");
include_once(dirname(__FILE__) . "/../framework/bib/util/interface/InterfaceHTML.php");
include_once(dirname(__FILE__) . "/../framework/bib/util/interface/Paging.php");
include_once(dirname(__FILE__) . "/../framework/bib/util/interface/PdfUtil.php");

include_once(dirname(__FILE__) . "/recaptcha-php-1.11/recaptchalib.php");
include_once(dirname(__FILE__) . "/phpmailer/class.phpmailer.php");
# include_once(dirname(__FILE__) . "/EXTENSION_DIR/EXTENSION_FILE.php");

?>