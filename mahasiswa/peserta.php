<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/koneksi.php';
    include_once '../class/daftarSertifikasi.php';
    // include_once '../mahasiswa/mahasiswa.php';
    
    $database = new Database();
    $db = $database->getConnection();

    $items = new Daftar($db);

    $stmt = $items->getDaftarSertifikasi();
    $itemCount = $stmt->rowCount();

    if($itemCount > 0){
        
        $pesertaArr = array();
        $pesertaArr["body"] = array();
        $pesertaArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id_mhs" => $id_mhs,
                "nim" => $nim,
                "nama" => $nama,
                "jurusan" => $jurusan,
                "pilihan1" => $pilihan1,
                "pilihan2" => $pilihan2,
                "pilihan3" => $pilihan3,
                "upload_ktm"=>$upload_ktm
                
            );

            array_push($pesertaArr["body"], $e);
        }
        echo json_encode($pesertaArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>