<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/koneksi.php';
    include_once '../class/sertifikasi.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Sertifikasi($db);

    $stmt = $items->getSertifikasi();
    $itemCount = $stmt->rowCount();

    if($itemCount > 0){
        
        $sertifikasiArr = array();
        $sertifikasiArr["body"] = array();
        $sertifikasiArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id_sertifikasi" => $id_sertifikasi,
                "nama_sertifikasi" => $nama_sertifikasi,
                "dosen_pengampu" => $dosen_pengampu,
                "hari" => $hari,
                "jam" => $jam,
                "tanggal" => $tanggal
            );

            array_push($sertifikasiArr["body"], $e);
        }
        echo json_encode($sertifikasiArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>