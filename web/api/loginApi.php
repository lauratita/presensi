<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/authView.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/authModel.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

// Mengambil parameter NIK dan password dari request
$nikPegawai = isset($data['nik_pegawai']) ? trim($data['nik_pegawai']) : '';
$password = isset($data['password']) ? trim($data['password']) : '';

// Validasi parameter NIK dan password
if (empty($nikPegawai) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "NIK dan Password wajib diisi"]);
    exit();
}

// Validasi panjang NIK
if (strlen($nikPegawai) < 10) {
    echo json_encode(["status" => "error", "message" => "NIK minimal 10 karakter"]);
    exit();
}

// Membuat instance LoginService untuk memeriksa login
$loginService = new LoginService($koneksi);
$loginResult = $loginService->getLogin($nikPegawai, $password);

// Mendekode hasil login
$loginResult = json_decode($loginResult, true);

// Mengecek hasil login
if ($loginResult['status'] === 'success') {
    // Jika login berhasil, buat session
    session_start();
    $_SESSION['nik_pegawai'] = $loginResult['data']['nik_pegawai'];
    $_SESSION['nama'] = $loginResult['data']['nama'];
    $_SESSION['id_jenis'] = $loginResult['data']['id_jenis'];

    // Mengembalikan response sukses
    echo json_encode([
        "status" => "success",
        "message" => "Login berhasil",
        "data" => [
            "nik_pegawai" => $_SESSION['nik_pegawai'],
            "nama" => $_SESSION['nama'],
            "id_jenis" => $_SESSION['id_jenis']
        ]
    ]);
} else {
    echo json_encode(["status" => "error", "message" => $loginResult['message']]);
}