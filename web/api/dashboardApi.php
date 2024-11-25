<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/dashboardModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/controller/dashboardController.php';

header('Content-Type: application/json');

// Periksa metode request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Request method harus POST']);
    exit();
}

// Ambil data dari body POST
$nikPegawai = isset($_POST['nik_pegawai']) ? $_POST['nik_pegawai'] : '';

// Validasi input
if (empty($nikPegawai)) {
    echo json_encode(['status' => 'error', 'message' => 'NIK Pegawai wajib diisi']);
    exit();
}

try {
    // Instansiasi controller
    $dashboardController = new DashboardController();

    // Ambil data statistik
    $jumlahSiswa = json_decode($dashboardController->getJumlahSiswa($nikPegawai), true);
    $jumlahSurat = json_decode($dashboardController->getJumlahSurat($nikPegawai), true);
    $jumlahSuratHariIni = $dashboardController->getJumlahSuratHariIni($nikPegawai);
    $jumlahPresensiHariIni = $dashboardController->getJumlahPresensiHariIni($nikPegawai);

    // Susun respons data
    $response = [
        'status' => 'success',
        'message' => 'Data statistik berhasil diambil',
        'data' => [
            'statistikSiswa' => [
                'total' => $jumlahSiswa['statistik_siswa'] ?? 0
            ],
            'statistikSurat' => [
                'total' => $jumlahSurat['statistik_surat'] ?? 0,
                'hari_ini' => [
                    'unverified' => $jumlahSuratHariIni['unverified'] ?? 0,
                    'verified' => $jumlahSuratHariIni['verified'] ?? 0,
                    'disable' => $jumlahSuratHariIni['disable'] ?? 0
                ]
            ],
            'statistikPresensiHariIni' => [
                'total' => $jumlahPresensiHariIni['statistik_siswa'] ?? 0,
                'hadir' => $jumlahPresensiHariIni['hadir'] ?? 0,
                'sakit' => $jumlahPresensiHariIni['sakit'] ?? 0,
                'izin' => $jumlahPresensiHariIni['izin'] ?? 0,
                'alpha' => $jumlahPresensiHariIni['alpha'] ?? 0
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