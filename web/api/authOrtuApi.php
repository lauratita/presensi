<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/authOrtuController.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nikOrtu = $_POST['nik_ortu'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($nikOrtu) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'NIK dan Password wajib diisi']);
        exit();
    }

    $controller = new LoginOrtuController($koneksi);
    echo $controller->login($nikOrtu, $password);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Request method harus POST']);
}