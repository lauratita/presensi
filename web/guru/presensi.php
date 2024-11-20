<?php 
ob_start();
include '../template/headerGuru.php';
include_once '../controller/presensicontroler.php';

$controller = new PresensiControler();
$presensis = json_decode($controller->read(), true);

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
                    <input class="form-control" type="text" value="12/10/2024" aria-label="Disabled input example"
                        disabled readonly>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablepresensi" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                        </tr> 
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach ($presensis as $presensi) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $presensi['nis'] ?></td>
                                <td><?= $presensi['nama'] ?></td>
                                <td><?= $presensi['keterangan'] ?></td>
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