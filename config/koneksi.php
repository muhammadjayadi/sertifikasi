<?php
    class Database{
    
        // specify your own database credentials
        private $host = "127.0.0.1";            //Server
        private $db_name = "sertifikasi";       //Database Name
        private $username = "root";             //UserName of Phpmyadmin
        private $password = "";                 //Password associated with username
        public $conn;
    
        
        // get the database connection
        public function getConnection(){
    
            $this->conn = null;
    
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
    
            return $this->conn;
        }
    }
?>