<?php

header('Content-Type: application/json');

try{
    $con = new PDO('myqsl:host=localhost;dbname=db_presensicekinout', 'root', '', array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);

    $nik = $input['nik'] ?? '' ;
    $pass = $input['password'] ?? '';
    
    if(empty($nik) || empty($pass)){
        echo json_encode(['error' => 'NIK dan password wajib diisi']);
        exit;
    }

    $stmt = $con->prepare("SELECT * FROM tb_pegawai WHERE nik = :nik");
    $stmt->bindParam(":nik", $nik);
    $stmt->execute();
    $data = $stmt->fetch();

    if($data){
        if($data['password'] == $pass){
            echo json_encode([
                'success' => true,
                'nik' => $data['nik'],
                'id_jenis' => $data['id_jenis']
            ]);
        } else {
            echo json_encode(['error' => 'Password salah']);
        }
    } else {
        echo json_encode(['error' => 'NIK tidak terdaftar']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}