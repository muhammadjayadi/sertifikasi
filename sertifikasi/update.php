<?php
  if (isset($_SERVER['HTTP_ORIGIN'])) {
          header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
          header('Access-Control-Allow-Credentials: true');
          header('Access-Control-Max-Age: 86400');    // cache for 1 day
      }
      
      // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
      
          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
              header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
      
          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
              header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
      
          exit(0);
        }    
      include_once '../config/koneksi.php';
      include_once '../class/sertifikasi.php';
      
      $database = new Database();
      $db = $database->getConnection();
      
      $item = new Sertifikasi($db);
      
      $data = json_decode(file_get_contents("php://input"));
      if (
        !empty($data->nama_sertifikasi) &&
        !empty($data->dosen_pengampu) &&
        !empty($data->hari) &&
        !empty($data->jam) &&
        !empty($data->tanggal)
      ) {
        $item->id_sertifikasi = $data->id_sertifikasi;
        $item->nama_sertifikasi = $data->nama_sertifikasi;
        $item->dosen_pengampu = $data->dosen_pengampu;
        $item->hari = $data->hari;
        $item->jam = $data->jam;
        $item->tanggal = $data->tanggal;
      
      if($item->updateSertifikasi()){
          echo json_encode(array("message" => "data sertifikasi updated successfull."));
      } else{
          echo json_encode(array("message" => "Data sertifikasi could not be updated"));
      }
  }else {
      http_response_code(400);
      echo json_encode(array("message" => "Unable to update sertifikasi. Data is incomplete."));
  }
?>