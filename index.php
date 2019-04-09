<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
define("IGENIAL_ROOT_DIR", dirname(__FILE__));
include(dirname(__FILE__)."/framework/controller/FrontController.php");
#Util::debug($_REQUEST);
$fc = new FrontController();
?>
