<?php 
ob_start();
session_start();
include '../template/headerGuru.php';
include_once '../controller/authController.php';
include_once '../controller/dashboardController.php';

$controller = new LoginController();
$statistikController = new DashboardController($koneksi);
$jumlahSiswa = json_decode($statistikController->getJumlahSiswa($_SESSION['nik_pegawai']), true);
$jumlahSurat = json_decode($statistikController->getJumlahSurat($_SESSION['nik_pegawai']), true);
$jumlahSuratHariIni = $statistikController->getJumlahSuratHariIni($_SESSION['nik_pegawai']);
$jumlahPresensiHariIni = $statistikController->getJumlahPresensiHariIni($_SESSION['nik_pegawai']);



if (!isset($_SESSION['nik_pegawai']) || !isset($_SESSION['id_jenis'])) {
    // Jika tidak ada sesi login, arahkan ke halaman login
    header("Location: ../login.php");
    exit();
}
if ($_SESSION['id_jenis'] != 2) { 
    header("Location: ../admin/index.php"); 
    exit();
}

$currentUser = [
    'nik_pegawai' => $_SESSION['nik_pegawai'],
    'nama' => $_SESSION['nama'],
    'id_jenis' => $_SESSION['id_jenis']
];

// Data Statistik
$statistikSiswa = [
    'total' => $jumlahSiswa['statistik_siswa'] ?? 0,
    'hadir' => 36,
    'sakit' => 2,
    'izin' => 1,
    'alpa' => 1
];
$statistikSurat = [
    'total' => $jumlahSurat['statistik_surat'] ?? 0,
    'unverified' => $jumlahSuratHariIni['unverified'] ?? 0,
    'verified' => $jumlahSuratHariIni['verified'] ?? 0,
    'disable' => $jumlahSuratHariIni['disable'] ?? 0
];
$statistikSuratHariIni = [
    'total' => $jumlahSuratHariIni['statistik_surat'] ?? 0,
    'unverified' => $jumlahSuratHariIni['unverified'] ?? 0,
    'verified' => $jumlahSuratHariIni['verified'] ?? 0,
    'disable' => $jumlahSuratHariIni['disable'] ?? 0
];
$statistikPresensiHariIni = [
    'total' => $jumlahPresensiHariIni['statistik_siswa'] ?? 0,
    'hadir' => $jumlahPresensiHariIni['hadir'] ?? 0,
    'sakit' => $jumlahPresensiHariIni['sakit'] ?? 0,
    'izin' => $jumlahPresensiHariIni['izin'] ?? 0,
    'alpa' => $jumlahPresensiHariIni['alpa'] ?? 0
];

?>

<!-- Begin Page Content -->
<div class="container text-center">
    <!-- Content Row -->
    <div class="row">
        <!-- Statistik Siswa -->
        <div class="col-sm-5 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-primary text-uppercase mb-1 m-0 me-2">
                                Statistik Siswa</div>
                            <div class="h2 mb-3 me-2 mt-4 font-weight-bold text-gray-800">
                                <?= $statistikSiswa['total']; ?>
                            </div>
                            <span>Total Siswa</span>
                            <ul class="p-0 m-0 mt-5">
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="text-success bi bi-person-fill-check mr-2"></i>
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0" style="font-weight: bold;">Hadir</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small
                                                class="fw-semibold"><?= $statistikPresensiHariIni['hadir']; ?></small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="text-primary bi bi-person-fill-dash mr-2"></i>
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0" style="font-weight: bold;">Sakit</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small
                                                class="fw-semibold"><?= $statistikPresensiHariIni['sakit']; ?></small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="text-warning bi bi-person-fill-exclamation mr-2"></i>
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0" style="font-weight: bold;">Izin</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold"><?= $statistikPresensiHariIni['izin']; ?></small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="text-danger bi bi-person-fill-slash mr-2"></i>
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0" style="font-weight: bold;">Alpha</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold"><?= $statistikPresensiHariIni['alpa']; ?></small>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Statistik Siswa -->
        <!-- Statistik Surat Izin -->
        <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-primary text-uppercase mb-1 m-0 me-2">
                                Statistik Surat Izin</div>
                            <div class="h2 mb-3 me-2 mt-4 font-weight-bold text-gray-800">
                                <?php echo $statistikSurat['total']; ?></div>
                            <span>Total Surat</span>
                            <ul class="p-0 m-0 mt-5">
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="text-warning bi bi-dash-circle-fill mr-2"></i>
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0" style="font-weight: bold;">Unverified</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small
                                                class="fw-semibold"><?php echo $statistikSuratHariIni['unverified']; ?></small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="text-success bi bi-check-circle-fill mr-2"></i>
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0" style="font-weight: bold;">Verified</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small
                                                class="fw-semibold"><?php echo $statistikSuratHariIni['verified']; ?></small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <i class="text-danger bi bi-x-circle-fill mr-2"></i>
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0" style="font-weight: bold;">Disable</h6>
                                        </div>
                                        <div class="user-progress">
                                            <small
                                                class="fw-semibold"><?php echo $statistikSuratHariIni['disable']; ?></small>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Statistik Surat Izin -->
    </div>
</div>
<!-- /.container-fluid -->

<?php include '../template/footerGuru.php'; ?>