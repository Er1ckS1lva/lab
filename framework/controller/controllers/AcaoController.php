<?php

include_once(dirname(__FILE__) . '/../../model/action/AcaoAction.php');
require_once(dirname(__FILE__) . '/../parent/AcaoControllerParent.php');

class AcaoController extends AcaoControllerParent {

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function carrega() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), true))
            return $oUtilAuth->retornaViewLogin($this->response);

        $oUsuario = UtilAuth::recuperaObjetoUsuario();
        if ($oUsuario->getSuperuser() != 'S')
            return new View("Não permitido!", NULL, "print");

        set_time_limit(0);
        $oAcaoAction = new AcaoAction();
        $saida = $oAcaoAction->carrega($this->request);
        return new View($saida, null, 'print');
    }

    public function ajustaImportacao() {
        $oUtilAuth = new UtilAuth();
        if (!$oUtilAuth->usuarioAutenticado($this->request->get("action"), true))
            return $oUtilAuth->retornaViewLogin($this->response);

        # configura para não travar
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        # conexao
        require_once IGENIAL_ROOT_DIR . "/bib/classes/php/orm" . '/Doctrine/Common/ClassLoader.php';
        $loader = new \Doctrine\Common\ClassLoader("Doctrine", dirname(__FILE__));
        $loader->register();
        $setup = new Doctrine\ORM\Tools\Setup();
        $dbParams = array(
            'driver' => CONFIG_DRIVER,
            'host' => CONFIG_HOST,
            'user' => CONFIG_USER,
            'password' => CONFIG_PASSWORD,
            'dbname' => CONFIG_DBNAME,
            'pdo' => new PDO("mysql:host=" . CONFIG_HOST . ";dbname=" . CONFIG_DBNAME, CONFIG_USER, CONFIG_PASSWORD, array(PDO::ATTR_PERSISTENT => true))
        );
        $modelsPath[] = IGENIAL_ROOT_DIR . '/framework/model/doctrine/Entities';
        $config = $setup->createAnnotationMetadataConfiguration($modelsPath, true);
        $entityManager = Doctrine\ORM\EntityManager::create($dbParams, $config);

        $bExit = false;

        # query native
        ### produto ###
        $sql = "SELECT * FROM %%TABLE%%";
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $aSql = array();
        foreach ($result as $i => $objects) {
            $aFields = array();
            $aValues = array();
            foreach ($objects as $k => $v) {
                if ($k == "%%FIELD_FOUND%%") {
                    $aFields[] = $k;
                    $aValues[] = "'$v'";

                    # DIFF
                    $aFields[] = "%%FIELD_DIFF%%";
                    $aValues[] = "NULL";
                } else {
                    $aFields[] = $k;
                    $aValues[] = "'$v'";
                }
            }
            $aSql[] = "#{$i}<br/>INSERT INTO %%TABLE%% (" . implode(",", $aFields) . ") VALUES (" . implode(",", $aValues) . ")";
        }
        Util::debug(join("<br/>", $aSql), $bExit);
        echo "-------//-------";

        Util::debug('OK');
    }

}

?>