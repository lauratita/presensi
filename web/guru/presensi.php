<?php 
ob_start();
session_start();
if (!isset($_SESSION['nik_pegawai'])) {
    header("Location: ../login.php");
    exit();
}
include '../template/headerGuru.php';
include_once '../controller/presensicontroler.php';

$nik_pegawai = $_SESSION['nik_pegawai'];

$controller = new PresensiControler($koneksi);
$presensiHariIni = $controller->getByWaliKelasHariIni($nik_pegawai);
// $presensis = json_decode($controller->read(), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengecek tindakan berdasarkan nilai action
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        // Proses edit data
        $result = $controller->update($_POST);
        if ($result) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        // Proses tambah data (create)
        $result = $controller->create($_POST);
        if ($result) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    // Proses delete data
    $nik = $_GET['nik'];
    $result = $controller->delete(['nik' => $nik]);
    if ($result) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

 ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h6 class="m-0 font-weight-bold text-primary"><span class="text-muted fw-flight">Presensi</span></h6>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="" class="col-form-label" aria-label="Disabled input example" disabled
                        readonly>Tanggal</label>
                </div>
                <div class="col-auto">
                    <!-- <input class="form-control" type="text" value="12/10/2024" aria-label="Disabled input example"
                        disabled readonly> -->
                    <input class="form-control" type="text" id="tanggal" aria-label="Disabled input example" disabled
                        readonly>
                    <script>
                    // Fungsi untuk format tanggal (contoh: dd/mm/yyyy)
                    function formatTanggal(tanggal) {
                        let dd = String(tanggal.getDate()).padStart(2, '0');
                        let mm = String(tanggal.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
                        let yyyy = tanggal.getFullYear();

                        return dd + '/' + mm + '/' + yyyy;
                    }
                    // Mendapatkan tanggal hari ini
                    let tanggalHariIni = new Date();

                    // Menampilkan tanggal yang diformat di input
                    document.getElementById('tanggal').value = formatTanggal(tanggalHariIni);
                    </script>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablepresensi" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Poin Telat</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $no = 1;
                    foreach ($presensiHariIni as $presensi) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $presensi['tanggal'] ?></td>
                            <td><?= $presensi['nis'] ?></td>
                            <td><?= $presensi['nama_siswa'] ?></td>
                            <td><?= $presensi['keterangan'] ?></td>
                            <td><?= $presensi['is_late'] ?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include '../template/footerGuru.php' ?>