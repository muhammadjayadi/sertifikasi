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
    include_once '../class/auth.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new User($db);

    $data = json_decode(file_get_contents("php://input"));
    if (
        !empty($data->nama) &&
        !empty($data->username) &&
        !empty($data->password)
    ) {
        $item->nama = $data->nama;
        $item->username = $data->username;
        $item->password = base64_encode($data->password);

        if ($item->Signup()) {
            echo json_encode(array(
                "message" => "Account created successfully",
                "nama" => $item->nama,
                "username" => $item->username,
                "password" => $item->password
            ));
        } else {
            echo json_encode(array("message" => "Account could not be created."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create account. Data is incomplete."));
    }