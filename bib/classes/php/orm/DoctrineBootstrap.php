<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Tools\SchemaValidator;

class DoctrineBootstrap {

    private $modelsPath;
    private $host;
	private $port;
    private $dbname;
    private $user;
    private $password;

    public function __construct() {
        
    }

    public static function iGenialConnection() {
        $sErrorConn = "Ocorreu um erro ao tentar conectar ao banco de dados";

        $host = CONFIG_HOST;
		$port = CONFIG_PORTA;
        $dbname = CONFIG_DBNAME;
        $user = CONFIG_USER;
        $password = CONFIG_PASSWORD;
		$charset = CONFIG_CHARSET;

        if ($host == '')
            exit('Configure um servidor.');
        if ($dbname == '')
            exit('Configure um banco de dados.');
        if ($user == '')
            exit('Configure um usuário.');

        $modelsPath[] = IGENIAL_ROOT_DIR . '/framework/model/doctrine/Entities';
        #$modelsPath[] = GENIAL_ROOT_DIR . '/framework/model/doctrine/Entities'; #another models path 

        $loader = new \Doctrine\Common\ClassLoader("Doctrine", dirname(__FILE__));
        $loader->register();
        try {
            $dbParams = array(
                'driver' => CONFIG_DRIVER,
                'host' => $host,
				'port' => $port,
                'user' => $user,
                'password' => $password,
                'dbname' => $dbname,
                'pdo' => new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}", $user, $password, array(PDO::ATTR_PERSISTENT => true))
            );
            $config = Setup::createAnnotationMetadataConfiguration($modelsPath, true);
            
            /*
             * Configuração de Diretorio TEMPORARIO
             * Documentação: http://docs.doctrine-project.org/en/latest/reference/advanced-configuration.html#autoloading-proxies
             */
            if (defined('DOCTRINE_PROXY_DIR') === TRUE) {
                $config->setProxyDir(DOCTRINE_PROXY_DIR);
            }
            $entityManager = EntityManager::create($dbParams, $config);

            $entityManager->getConnection()->connect();
        } catch (\Exception $e) {
			die("{$sErrorConn}: {$e->getMessage()}");
        }

        return $entityManager;
    }

    public function iGenialPaginate($query) {
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }

}
