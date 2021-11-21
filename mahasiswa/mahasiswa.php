<?php

//  specify your own database credentials
//  $host = "127.0.0.1";            //Server
//  $db_name = "sertifikasi";       //Database Name
//  $username = "root";             //UserName of Phpmyadmin
//  $password = "";                 //Password associated with username

// $conn =new mysqli($host,$db_name,$username,$password);

header("content-type:application/json");

include_once '../config/koneksi.php';
$database = new Database();
$db = $database->getConnection();   


$method = $_SERVER['REQUEST_METHOD'];


$result= array();


// function datamhs(){
//     $sqlQuery= "SELECT * FROM mahasiswa";
// }

if($method='POST'){
    
    // cek
    if(isset($_POST['nim']) AND isset($_POST['nama']) AND isset($_POST['jurusan']) AND isset($_POST['pilihan1']) AND isset($_POST['pilihan2']) AND isset($_POST['pilihan3'])){
        

        $nim=$_POST['nim'];
        $nama=$_POST['nama'];
        $jurusan=$_POST['jurusan'];
        $pilihan1=$_POST['pilihan1'];
        $pilihan2=$_POST['pilihan2'];
        $pilihan3=$_POST['pilihan3'];


        $foto_tmp = $_FILES['upload_ktm']['tmp_name'];
        $nama_foto = $_FILES['upload_ktm']['name'];
        $direktory="../image/";
        
    
    if( move_uploaded_file($foto_tmp, "$direktory/$nama_foto")){
        $result['status'] = [
            "code"=>200,
            "description"=>'1 data berhasil diinput'          
            
        ];

        $sql="INSERT INTO mahasiswa (nim, nama, jurusan, pilihan1, pilihan2, pilihan3, upload_ktm)     
        VALUES ('$nim','$nama','$jurusan','$pilihan1','$pilihan2','$pilihan3','$nama_foto') ";

        
        
        $db->query($sql);
        $result['result']=[
        "nim"=>$nim,
        "nama"=>$nama,
        "jurusan"=>$jurusan,
        "pilihan1"=>$pilihan1,
        "pilihan2"=>$pilihan2,
        "pilihan3"=>$pilihan3,
        "pilihan3"=>$nama_foto,
            
        ] ;
        
    }else{
        $result['status']=[
            "description"=>'data gagal diinputkan'   
        ];

    }
    }
        
}
// else{
//     $result['status']=[
//         "code"=>400,
//         "description"=>'not invalid'   
//     ];
// }
echo json_encode($result);

?>