<?php 
    class Database{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $conn;
        private $stmt;
        public $error;

        public function __construct(){
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try{
                $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
            }catch(PDOException $e){
                $this->error = $e->getMessage();
                die("Database connection failed: " . $this->error);
            }
        }

        public function callProcedure($procedure, $params = []){
            $placeholders = implode(',', array_fill(0, count($params), '?'));
            $query = "CALL {$procedure}({$placeholders})";
            $this->stmt = $this->conn->prepare($query);
            foreach($params as $key => $value){
                $this->stmt->bindValue($key + 1, $value);
            }
            try{
                $this->stmt->execute();
                return $this->stmt;
            }catch(PDOException $e){
                $this->error = $e->getMessage();
                return false;
            }
        }
    }
?>