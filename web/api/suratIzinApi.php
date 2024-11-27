<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/suratIzinController.php';

$controller = new SuratIzinController();
$requestMethod = $_SERVER['REQUEST_METHOD'];


switch ($requestMethod) {
    case 'GET':
        // Ambil data berdasarkan parameter
        header('Content-Type: application/json');
        echo $controller->read();
       break;

    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'SuratIzin') {
            header('Content-Type: application/json');
            echo $controller->create($_POST);
        }else if (isset($_GET['action']) && $_GET['action'] === 'VerifikasiSurat' ) {
            header('Content-Type: application/json');
            echo $controller->updateStatusSuratIzin($_POST);
        }else{  
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Request method not supported']);
        }
        break;
        // Update status surat izin
        // if (isset($_POST['id_surat']) && isset($_POST['status'])) {
        //     $id_surat = $_POST['id_surat'];
        //     $status = $_POST['status'];
        //     $result = $controller->updateStatusSuratIzin($id_surat, $status); // Pastikan `updateStatus` sudah dibuat
        //     if ($result) {
        //         echo json_encode(['message' => 'Status berhasil diperbarui']);
        //     } else {
        //         echo json_encode(['error' => 'Gagal memperbarui status']);
        //     }
        // } else {
        //     echo json_encode(['error' => 'Parameter `id_surat` dan `status` diperlukan']);
        // }
        // break;

    default:
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Metode request tidak didukung']);
        break;
}
?>