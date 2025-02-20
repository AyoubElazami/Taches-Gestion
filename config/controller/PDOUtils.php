<?php 

class PDOUtils {
    private $pdo_;
    private static $sharedInstance_;

    private function __construct() {
        $this->pdo_ = new PDO('mysql:host=localhost;dbname=examprojet', 'root', '', [  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',]); }

      
        public static function getSharedInstance()
        {
            if (!isset(PDOUtils::$sharedInstance_)) {
                PDOUtils::$sharedInstance_ = new PDOUtils();
            }
        
            return PDOUtils::$sharedInstance_;
        }

        public function requestSQL($sql, $params = null) {
            $statement = $this->pdo_->prepare($sql);
            
            if ($statement) {
                if ($statement->execute($params)) {
                   
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    unset($statement);
                    return $result;
                } else {
                    throw new Exception('Erreur lors de l\'exécution de la requête : ' . implode(", ", $statement->errorInfo()));
                }
            } else {
                throw new Exception('Erreur lors de la préparation de la requête : ' . implode(", ", $this->pdo_->errorInfo()));
            }
        }
        public function execSQL($sql, $params = null) {
            $statement = $this->pdo_->prepare($sql);
            if($statement && $statement->execute($params)) {
               
                unset($statement);
                return true;
            }
            return false;
           
        }

        public function lastInsertId() {
            return $this->pdo_->lastInsertId();
        }
    
      
}