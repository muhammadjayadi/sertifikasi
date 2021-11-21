<?php
    class Daftar{

        // Connection
        private $conn;

        // Table
        private $db_table = "mahasiswa";

        // Columns
        public $id_mhs;
        public $nim;
        public $nama;
        public $jurusan;
        public $pilihan1;
        public $pilihan2;
        public $pilihan3;

        // Db connection
        public function __construct($db){
            $this->conn =   $db;
        }

        // GET ALL
        public function getDaftarSertifikasi(){
            $sqlQuery = "SELECT id_mhs, nim, nama, jurusan, pilihan1, pilihan2, pilihan3, upload_ktm  FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        
           // GET DATA
        public function getMhsBerdasarkanJurusan(){
            if(isset($_GET['jurusan'])){
                $mahasiswa=$_GET['jurusan'];
                $sql="select * from mahasiswa where jurusan like '%$mahasiswa%' ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();    
                return $stmt;
            }
            
            
        }

        // CREATE
        public function createDaftarSertifikasi(){
        
                $sqlQuery = "INSERT INTO
                ". $this->db_table ."
            SET
                nim = :nim,
                nama = :nama,
                jurusan = :jurusan,
                pilihan1 = :pilihan1,
                pilihan2 = :pilihan2,
                pilihan3 = :pilihan3,
                upload_ktm = :upload_ktm";

            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->nim=htmlspecialchars(strip_tags($this->nim));
            $this->nama=htmlspecialchars(strip_tags($this->nama));
            $this->jurusan=htmlspecialchars(strip_tags($this->jurusan));
            $this->pilihan1=htmlspecialchars(strip_tags($this->pilihan1));
            $this->pilihan2=htmlspecialchars(strip_tags($this->pilihan2));
            $this->pilihan3=htmlspecialchars(strip_tags($this->pilihan3));
            $this->upload_ktm=htmlspecialchars(strip_tags($this->upload_ktm));

        

            // bind data
            $stmt->bindParam(":nim", $this->nim);
            $stmt->bindParam(":nama", $this->nama);
            $stmt->bindParam(":jurusan", $this->jurusan);
            $stmt->bindParam(":pilihan1", $this->pilihan1);
            $stmt->bindParam(":pilihan2", $this->pilihan2);
            $stmt->bindParam(":pilihan3", $this->pilihan3);
            $stmt->bindParam(":upload_ktm", $this->upload_ktm);
        
            if($stmt->execute()){
            return true;
            }
            return false;
        }

        
    }
?>