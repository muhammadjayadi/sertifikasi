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
        include_once '../class/daftarSertifikasi.php';

        $database = new Database();
        $db = $database->getConnection();

        $item = new Daftar($db);

        $data = json_decode(file_get_contents("php://input"));
        if (
            !empty($data->nim) &&
            !empty($data->nama) &&
            !empty($data->jurusan) &&
            !empty($data->pilihan1) &&
            !empty($data->pilihan2) &&
            !empty($data->pilihan3) &&
            !empty($data->upload_ktm)
        ) {
            $item->nim = $data->nim;
            $item->nama = $data->nama;
            $item->jurusan = $data->jurusan;
            $item->pilihan1 = $data->pilihan1;
            $item->pilihan2 = $data->pilihan2;
            $item->pilihan3 = $data->pilihan3;
            $item->upload_ktm = $data->upload_ktm;

            if ($item->getDaftarSertifikasi()) {
                echo json_encode(array("message" => "Daftar Sertifikasi created successfully."));
            } else {
                echo json_encode(array("message" => "Daftar Sertifikasi could not be created."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create sertifikasi. Data is incomplete."));
        }