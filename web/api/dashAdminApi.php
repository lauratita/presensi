<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/dashAdminModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/dashAdminController.php';

header('Content-Type: application/json');

// Periksa metode request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Request method harus POST']);
    exit();
}

// Ambil data dari body POST
// $nikPegawai = isset($_POST['nik_pegawai']) ? $_POST['nik_pegawai'] : '';

// Validasi input
// if (empty($nikPegawai)) {
//     echo json_encode(['status' => 'error', 'message' => 'NIK Pegawai wajib diisi']);
//     exit();
// }

try {
    // Instansiasi controller
    $dashAdminController = new DashboardAdminController();

    // Ambil data statistik
    $jumlahSiswa = json_decode($dashAdminController->getJumlahSiswa());
    $jumlahKelas = json_decode($dashAdminController->getJumlahKelas());
    $jumlahPegawai = json_decode($dashAdminController->getJumlahPegawai());
    $jumlahPresensiHariIni = $dashAdminController->getJumlahPresensiHariIni();

    // Susun respons data
    $response = [
        'status' => 'success',
        'message' => 'Data statistik berhasil diambil',
        'data' => [
            'statistikSiswa' => [
                'total' => $jumlahSiswa->total_siswa ?? 0
            ],
            'statistikKelas' => [
                'total' => $jumlahKelas->total_kelas ?? 0
            ],
            'statistikPegawai' => [
                'total' => $jumlahPegawai->total_pegawai ?? 0
            ],
            'statistikPresensiHariIni' => [
                'total' => $jumlahPresensiHariIni->total_siswa ?? 0,
                'hadir' => $jumlahPresensiHariIni['hadir'] ?? 0,
                'sakit' => $jumlahPresensiHariIni['sakit'] ?? 0,
                'izin' => $jumlahPresensiHariIni['izin'] ?? 0,
                'alpa' => $jumlahPresensiHariIni['alpa'] ?? 0
            ]
        ]
    ];

    // Kirim respons
    echo json_encode($response);

} catch (Exception $e) {
    // Tangani error
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}
?>