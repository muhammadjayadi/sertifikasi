<?php
    class User{

        // Connection
        private $conn;

        // Table
        private $db_table = "user";

        // Columns
        public $id_user;
        public $nama;
        public $username;
        public $password;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }
        // CREATE
        public function Signup(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        nama = :nama,
                        username = :username,
                        password = :password";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->nama=htmlspecialchars(strip_tags($this->nama));
            $this->username=htmlspecialchars(strip_tags($this->username));
            $this->password=htmlspecialchars(strip_tags($this->password));
        
            // bind data
            $stmt->bindParam(":nama", $this->nama);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
        
            if($stmt->execute()){
            return true;
            }
            return false;
        }

        function login(){
            // select all query with user inputed username and password
            $query = "SELECT
                        `id_user`, `nama`, `username`, `password`
                    FROM
                        " . $this->db_table . " 
                    WHERE
                        username='".$this->username."' AND password='".$this->password."'";
            // prepare query statement
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();
            return $stmt;
        }
    
        //Notify if User with given username Already exists during SignUp
        function isAlreadyExist(){
            $query = "SELECT *
                FROM
                    " . $this->db_table . " 
                WHERE
                    username='".$this->username."'";
            // prepare query statement
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        }
    }
?>