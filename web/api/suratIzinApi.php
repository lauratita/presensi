<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/suratIzinController.php';

$controller = new SuratIzinController();
$requestMethod = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch ($requestMethod) {
    case 'GET':
        // Ambil data berdasarkan parameter
        if (isset($_GET['status']) && isset($_GET['nik_pegawai'])) {
            $nik_pegawai = $_GET['nik_pegawai'];
            $status = $_GET['status'];
            echo json_encode($controller->getByWaliKelas($nik_pegawai, $status));
        } else {
            echo json_encode(['error' => 'Parameter `status` dan `nik_pegawai` diperlukan']);
        }
        break;

    case 'POST':
        // Update status surat izin
        if (isset($_POST['id_surat']) && isset($_POST['status'])) {
            $id_surat = $_POST['id_surat'];
            $status = $_POST['status'];
            $result = $controller->updateStatusSuratIzin($id_surat, $status); // Pastikan `updateStatus` sudah dibuat
            if ($result) {
                echo json_encode(['message' => 'Status berhasil diperbarui']);
            } else {
                echo json_encode(['error' => 'Gagal memperbarui status']);
            }
        } else {
            echo json_encode(['error' => 'Parameter `id_surat` dan `status` diperlukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode request tidak didukung']);
        break;
}
?>