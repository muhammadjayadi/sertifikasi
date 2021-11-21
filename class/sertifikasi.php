<?php
    class Sertifikasi{

        // Connection
        private $conn;

        // Table
        private $db_table = "sertifikasi";

        // Columns
        public $id_sertifikasi;
        public $nama_sertifikasi;
        public $dosen_pengampu;
        public $hari;
        public $jam;
        public $tanggal;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getSertifikasi(){
            $sqlQuery = "SELECT id_sertifikasi, nama_sertifikasi, dosen_pengampu, hari, jam, tanggal FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }


        // GET DATA
        public function getSertifikasiBerdasarkanNama(){
            
            if(isset($_GET['nama_sertifikasi'])){
                $sertifikasi=$_GET['nama_sertifikasi'];
                $sql="select * from sertifikasi where nama_sertifikasi like '%$sertifikasi%' ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();    
                return $stmt;
            }
            
            
        }

        // CREATE
        public function createSertifikasi(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        nama_sertifikasi = :nama_sertifikasi,
                        dosen_pengampu = :dosen_pengampu,
                        hari = :hari,
                        jam = :jam,
                        tanggal =:tanggal";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->nama_sertifikasi=htmlspecialchars(strip_tags($this->nama_sertifikasi));
            $this->dosen_pengampu=htmlspecialchars(strip_tags($this->dosen_pengampu));
            $this->hari=htmlspecialchars(strip_tags($this->hari));
            $this->jam=htmlspecialchars(strip_tags($this->jam));
            $this->tanggal=htmlspecialchars(strip_tags($this->tanggal));
        
            // bind data
            $stmt->bindParam(":nama_sertifikasi", $this->nama_sertifikasi);
            $stmt->bindParam(":dosen_pengampu", $this->dosen_pengampu);
            $stmt->bindParam(":hari", $this->hari);
            $stmt->bindParam(":jam", $this->jam);
            $stmt->bindParam(":tanggal", $this->tanggal);
        
            if($stmt->execute()){
            return true;
            }
            return false;
        }

        // READ single
        public function getSingleSertifikasi(){
            $sqlQuery = "SELECT
                        id_sertifikasi, 
                        nama_sertifikasi, 
                        hari, 
                        jam, 
                        tanggal,
                        designation, 
                        created
                    FROM
                        ". $this->db_table ."
                    WHERE 
                    id_sertifikasi = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->nama_sertifikasi = $dataRow['nama_sertifikasi'];
            $this->dosen_pengampu = $dataRow['dosen_pengampu'];
            $this->hari = $dataRow['hari'];
            $this->jam = $dataRow['jam'];
            $this->tanggal = $dataRow['tanggal'];
            $this->designation = $dataRow['designation'];
            $this->created = $dataRow['created'];
        }        

        // UPDATE
        public function updateSertifikasi(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                    nama_sertifikasi = :nama_sertifikasi,
                    dosen_pengampu = :dosen_pengampu,
                    hari = :hari,
                    jam = :jam,
                    tanggal = :tanggal
                    WHERE 
                        id_sertifikasi = :id_sertifikasi";
        
            $stmt = $this->conn->prepare($sqlQuery);

            $this->nama_sertifikasi=htmlspecialchars(strip_tags($this->nama_sertifikasi));
            $this->dosen_pengampu=htmlspecialchars(strip_tags($this->dosen_pengampu));
            $this->hari=htmlspecialchars(strip_tags($this->hari));
            $this->jam=htmlspecialchars(strip_tags($this->jam));
            $this->tanggal=htmlspecialchars(strip_tags($this->tanggal));
            $this->id_sertifikasi=htmlspecialchars(strip_tags($this->id_sertifikasi));
        
            // bind data
            $stmt->bindParam(":nama_sertifikasi", $this->nama_sertifikasi);
            $stmt->bindParam(":dosen_pengampu", $this->dosen_pengampu);
            $stmt->bindParam(":hari", $this->hari);
            $stmt->bindParam(":jam", $this->jam);
            $stmt->bindParam(":tanggal", $this->tanggal);
            $stmt->bindParam(":id_sertifikasi", $this->id_sertifikasi);
        
            if($stmt->execute()){
            return true;
            }
            return false;
        }

        // DELETE
        function deleteSertifikasi(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id_sertifikasi = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id_sertifikasi=htmlspecialchars(strip_tags($this->id_sertifikasi));
        
            $stmt->bindParam(1, $this->id_sertifikasi);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>