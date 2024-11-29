<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/suratIzinController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

// Inisialisasi model
$controller = new SuratIzinController($koneksi);

$requestMethod = $_SERVER['REQUEST_METHOD'];

// Router berdasarkan request method dan parameter
switch ($requestMethod) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'createSuratIzin') {
            // Validasi input
            $requiredFields = ['keterangan', 'status', 'tanggal', 'foto_surat', 'nik_ortu', 'nik_pegawai', 'nis'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    http_response_code(400);
                    echo json_encode(['message' => "Field '$field' is required"]);
                    exit;
                }
            }
            // Buat surat izin
            header('Content-Type: application/json');
            echo $controller->create($_POST);
        } elseif (isset($_GET['action']) && $_GET['action'] === 'updateStatusSurat') {
            // Pastikan 'status' dan 'id_surat' ada dalam POST
            if (empty($_POST['status']) || empty($_POST['id_surat'])) {
                http_response_code(400);
                echo json_encode(['message' => "Field 'status' dan 'id_surat' harus ada"]);
                exit;
            }
            header('Content-Type: application/json');
            echo $controller->updateStatusSuratIzin($_POST);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Action tidak didukung']);
        }
        break;

    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] === 'getSiswaByOrtu') {
            if (empty($_GET['nik_ortu'])) {
                http_response_code(400);
                echo json_encode(['message' => "Field 'nik_ortu' is required"]);
                exit;
            }
            header('Content-Type: application/json');
            echo json_encode($controller->getSiswaByNIKOrtu($_GET['nik_ortu']));
        } elseif (isset($_GET['action']) && $_GET['action'] === 'getSuratIzinGuru') {
            if (empty($_GET['nik_pegawai']) || empty($_GET['status'])) {
                http_response_code(400);
                echo json_encode(['message' => "Field 'nik_pegawai' and 'status' are required"]);
                exit;
            }
            header('Content-Type: application/json');
            $response = $controller->getByWaliKelas($_GET['nik_pegawai'], $_GET['status']);
            echo json_encode($response);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Action not supported']);
        }
        break;

    default:
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Request method not supported']);
        break;
}
?>