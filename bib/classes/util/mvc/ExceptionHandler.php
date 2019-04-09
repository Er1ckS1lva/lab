<?php

/**
 * Está aceitando qualquer mensagem. Deve ser refatorado para aceitar Exceções somente.
 * Foi colocado em setMsg(), em cada ActionParent. No entanto, nem todo erro está sendo tratado
 * como Exceção. Verificar este problema.
 */
class ExceptionHandler {

    private static $INTEGRITY_CONSTRAINT_VIOLATION_1451 = 'Impossível deletar! Este registro está em uso no sistema. Delete todos as dependências para poder deletá-lo!'; //Cannot delete or update a parent row: a foreign key constraint fails
    private static $INTEGRITY_CONSTRAINT_VIOLATION_1452 = 'Erro de integridade de dados! Contate o Administrador!'; //Cannot delete or update a parent row: a foreign key constraint fails
    private static $INTEGRITY_CONSTRAINT_VIOLATION_1062 = 'Este valor já está cadastrado! Tente outro.'; //Cannot delete or update a parent row: a foreign key constraint fails
    private static $UNCONTROLLED_ERROR = "Ocorreu um erro não controlado!";

    private function __construct() {
        
    }

    /**
     *
     * @param <type> $e
     * @return <type>
     */
    public static function getMessage($e) {
        /*
          if ($e instanceof \Doctrine\DBAL\DBALException) {
          if(method_exists($e, "getMessage")){
          return "Erro: " . $e->getMessage();
          }
          switch ($e->getPrevious()->getCode()) {
          case 23000 :
          if (strpos($e->getMessage(), '1451') !== false) {
          return self::$INTEGRITY_CONSTRAINT_VIOLATION_1451;
          } else if (strpos($e->getMessage(), '1452') !== false) {
          return self::$INTEGRITY_CONSTRAINT_VIOLATION_1452;
          } else if (strpos($e->getMessage(), '1062') !== false) {
          return self::$INTEGRITY_CONSTRAINT_VIOLATION_1062;
          }
          break;
          default:
          return $e->getMessage(); //self::$UNCONTROLLED_ERROR;
          break;
          }
          }
          return $e;
         */

        /*
          if ($e instanceof \Doctrine\DBAL\DBALException) {
          #Util::debug($e);
          if (method_exists($e, "getPrevious")) {
          switch ($e->getPrevious()->getCode()) {
          case 23000 :
          if (strpos($e->getMessage(), '1451') !== false) {
          return self::$INTEGRITY_CONSTRAINT_VIOLATION_1451;
          } else if (strpos($e->getMessage(), '1452') !== false) {
          return self::$INTEGRITY_CONSTRAINT_VIOLATION_1452;
          } else if (strpos($e->getMessage(), '1062') !== false) {
          return self::$INTEGRITY_CONSTRAINT_VIOLATION_1062;
          }
          break;
          default:
          return $e->getMessage(); //self::$UNCONTROLLED_ERROR;
          break;
          }
          } elseif (method_exists($e, "getMessage")) {
          return "Erro: " . $e->getMessage();
          }
          }
          return $e;
         */
        
        if ($e instanceof \Doctrine\DBAL\DBALException || $e instanceof Exception) {
            #Util::debug($e);
            $a = ($e->getPrevious() && $e->getPrevious()->getCode()) ? $e->getPrevious()->getCode() : $e->getCode();
            switch ($a) {
                case 23000 :
                    if (strpos($e->getMessage(), '1451') !== false) {
                        return self::$INTEGRITY_CONSTRAINT_VIOLATION_1451;
                    } else if (strpos($e->getMessage(), '1452') !== false) {
                        return self::$INTEGRITY_CONSTRAINT_VIOLATION_1452;
                    } else if (strpos($e->getMessage(), '1062') !== false) {
                        return self::$INTEGRITY_CONSTRAINT_VIOLATION_1062;
                    }
                    break;
                default:
                    return $e->getMessage(); //self::$UNCONTROLLED_ERROR;
                    break;
            }
        }
        return $e;
    }

}

?>