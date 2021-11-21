<?php

    include_once '../config/koneksi.php';
    include_once '../class/auth.php';

    header("Access-Control-Allow-Origin: * ");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare user object
    $user = new User($db);

    // set ID property of user to be edited
    $user->username = isset($_GET['username']) ? $_GET['username'] : die();
    $user->password = base64_encode(isset($_GET['password']) ? $_GET['password'] : die());  

    // read the details of user to be edited
    $stmt = $user->login();
    if($stmt->rowCount() > 0){
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // create array
        $user_arr=array(
            "status" => true,
            "message" => "Successfully Login!",
            "id_user" => $row['id_user'],
            "username" => $row['username']
        );
    }
    else{
        $user_arr=array(
            "status" => false,
            "message" => "Invalid Username or Password!",
        );
    }
    // make it json format
    print_r(json_encode($user_arr));

?>