<?php 
ob_start();
session_start();
if (!isset($_SESSION['nik_pegawai'])) {
    header("Location: ../login.php");
    exit();
}

include '../template/headerGuru.php';
include_once '../controller/suratIzinController.php';
$nik_pegawai = $_SESSION['nik_pegawai'];

$controller = new SuratIzinController();

// Ambil data berdasarkan status
$surat_unverified = $controller->getByWaliKelas($nik_pegawai, 'unverified') ?? [];
$surat_verified = $controller->getByWaliKelas($nik_pegawai, 'verified') ?? [];
$surat_disable = $controller->getByWaliKelas($nik_pegawai, 'disable') ?? [];

// Validasi jika data tidak ditemukan
$surat_unverified = !empty($surat_unverified) ? $surat_unverified : [];;
$surat_verified = !empty($surat_verified) ? $surat_verified : [];;
$surat_disable = !empty($surat_disable) ? $surat_disable : [];;

// Periksa apakah form disubmit untuk memperbarui status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_surat = $_POST['id_surat'];
    $status = $_POST['status'];

    // Update status surat izin
    $query = "UPDATE tb_suratizin SET status = ? WHERE id_surat = ?";
    $stmt = $koneksi->prepare($query);
    
    // Mengikat parameter untuk query
    $stmt->bind_param('si', $status, $id_surat);
    
    if ($stmt->execute()) {
        // Redirect ke tab yang sesuai setelah status diperbarui
        header("Location: suratIzin.php?status=$status");
        exit;
    } else {
        echo "Gagal memperbarui status.";
    }
}

?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h6 class="m-0 mt-4 mb-4 font-weight-bold text-primary"><span class="text-muted fw-flight">Konfirmasi Surat
            Izin</span></h6>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="nav-unVerified-tab" data-toggle="tab" href="#tab-unVerified"
                data-bs-target="#nav-unVerified" type="button" role="tab" aria-controls="tab-unVerified"
                aria-selected="true">Unverified</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="nav-verified-tab" data-toggle="tab" href="#tab-verified"
                data-bs-target="#nav-verified" type="button" role="tab" aria-controls="tab-verified"
                aria-selected="false">Verified</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="nav-disable-tab" data-toggle="tab" href="#tab-disable"
                data-bs-target="#nav-disable" type="button" role="tab" aria-controls="tab-disable"
                aria-selected="false">Disable</button>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content" id="myTabContent">

        <!-- Tab unVerified -->
        <div class="tab-pane fade show active" id="tab-unVerified" role="tabpanel" aria-labelledby="nav-unVerified-tab">
            <div class="card shadow mb-4 mt-4">
                <h5 class="card-header">UnVerified</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-bordered" id="dataTable-unVerified" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Tenggat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($surat_unverified as $surat): ?>
                                    <tr>
                                        <td><?= $surat['nis'] ?></td>
                                        <td><?= $surat['nama_siswa'] ?></td>
                                        <td><?= $surat['keterangan'] ?></td>
                                        <td><span class="badge bg-warning"><?= $surat['status'] ?></span>
                                        </td>
                                        <td><?= $surat['tanggal'] ?></td>
                                        <td><?= $surat['tenggat'] ?></td>
                                        <td>
                                            <a href="?verifiedizin=<?= $surat['id_surat'] ?>" data-toggle="modal"
                                                data-target="#verifiedizin<?= $surat['id_surat'] ?>"
                                                class="btn btn-sm btn-primary">
                                                Verified
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="verifiedizin<?= $surat['id_surat'] ?>" tabindex="-1"
                                        aria-labelledby="verifiedizinLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-5" id="exampleModalLabel">Surat Siswa</h3>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>NIS : <?= $surat['nis'] ?></h6>
                                                    <h6>NAMA : <?= $surat['nama_siswa'] ?></h6>
                                                    <h6>KETERANGAN : <?= $surat['keterangan'] ?></h6>
                                                    <h6>TANGGAL : <?= $surat['tanggal'] ?></h6>
                                                    <h6>TENGGAT : <?= $surat['tenggat'] ?></h6>
                                                    <h6>FOTO SURAT : </h6>
                                                    <img src="../img/<?= $surat['foto_surat'] ?>" class="img-fluid"
                                                        width="300" height="300" />
                                                </div>
                                                <div class="modal-footer">
                                                    <!-- Form untuk perubahan status -->
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <form action="suratIzin.php" method="POST">
                                                        <input type="hidden" name="id_surat"
                                                            value="<?= $surat['id_surat'] ?>" />
                                                        <input type="hidden" name="status" value="verified" />
                                                        <button type="submit" class="btn btn-success">Verified</button>
                                                    </form>
                                                    <form action="suratIzin.php" method="POST">
                                                        <input type="hidden" name="id_surat"
                                                            value="<?= $surat['id_surat'] ?>" />
                                                        <input type="hidden" name="status" value="disable" />
                                                        <button type="submit" class="btn btn-danger">Disable</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tab unVerified -->

        <!-- Tab Verified -->
        <div class="tab-pane fade" id="tab-verified" role="tabpanel" aria-labelledby="nav-verified-tab">
            <div class="card shadow mb-4 mt-4">
                <h5 class="card-header">Verified</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-bordered" id="dataTable-verified" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Tenggat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($surat_verified as $surat) : ?>
                                    <tr>
                                        <td><?= $surat['nis'] ?></td>
                                        <td><?= $surat['nama_siswa'] ?></td>
                                        <td><?= $surat['keterangan'] ?></td>
                                        <td><span class="badge bg-primary text-white"><?= $surat['status'] ?></span>
                                        </td>
                                        <td><?= $surat['tanggal'] ?></td>
                                        <td><?= $surat['tenggat'] ?></td>
                                        <td>
                                            <a href="?updateverifiedizin=<?= $surat['id_surat'] ?>" data-toggle="modal"
                                                data-target="#updateverifiedizin<?= $surat['id_surat'] ?>"
                                                class="btn btn-sm btn-danger">
                                                Disable
                                            </a>
                                    </tr>
                                    <!-- Modal verified -->
                                    <div class="modal fade" id="updateverifiedizin<?= $surat['id_surat'] ?>"
                                        tabindex="-1" aria-labelledby="verifiedizinLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-5" id="exampleModalLabel">
                                                        Edit
                                                        Verified
                                                    </h3>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>NIS : <?= $surat['nis'] ?></h6>
                                                    <h6>NAMA : <?= $surat['nama_siswa'] ?></h6>
                                                    <h6>KETERANGAN : <?= $surat['keterangan'] ?></h6>
                                                    <h6>TANGGAL : <?= $surat['tanggal'] ?></h6>
                                                    <h6>TENGGAT : <?= $surat['tenggat'] ?></h6>
                                                    <h6>FOTO SURAT : </h6>
                                                    <img src="../img/<?= $surat['foto_surat'] ?>" class="img-fluid"
                                                        width="300" height="300" />
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="suratIzin.php" method="POST" style="display:inline;">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <input type="hidden" name="id_surat"
                                                            value="<?= $surat['id_surat'] ?>" />
                                                        <input type="hidden" name="status" value="disable" />
                                                        <button type="submit" class="btn btn-danger">Disable</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Tab unVerified -->

        <!-- Tab Disable -->
        <div class="tab-pane fade" id="tab-disable" role="tabpanel" aria-labelledby="nav-disable-tab">
            <div class="card shadow mb-4 mt-4">
                <h5 class="card-header">Disable</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <table class="table table-bordered" id="dataTable-disable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Tenggat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($surat_disable as $surat) : ?>
                                    <tr>
                                        <td><?= $surat['nis'] ?></td>
                                        <td><?= $surat['nama_siswa'] ?></td>
                                        <td><?= $surat['keterangan'] ?></td>
                                        <td><span class="badge bg-secondary text-white"><?= $surat['status'] ?></span>
                                        </td>
                                        <td><?= $surat['tanggal'] ?></td>
                                        <td><?= $surat['tenggat'] ?></td>
                                        <td>
                                            <a href="?updatedisableizin=<?= $surat['id_surat'] ?>" data-toggle="modal"
                                                data-target="#updatedisableizin<?= $surat['id_surat'] ?>"
                                                class="btn btn-sm btn-success">
                                                Verified
                                            </a>
                                    </tr>
                                    <!-- modal disable -->
                                    <div class="modal fade" id="updatedisableizin<?= $surat['id_surat'] ?>"
                                        tabindex="-1" aria-labelledby="verifiedizinLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-5" id="exampleModalLabel">Edit
                                                        Disable
                                                    </h3>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>NIS : <?= $surat['nis'] ?></h6>
                                                    <h6>NAMA : <?= $surat['nama_siswa'] ?></h6>
                                                    <h6>KETERANGAN : <?= $surat['keterangan'] ?></h6>
                                                    <h6>TANGGAL : <?= $surat['tanggal'] ?></h6>
                                                    <h6>TENGGAT : <?= $surat['tenggat'] ?></h6>
                                                    <h6>FOTO SURAT : </h6>
                                                    <img src="../img/<?= $surat['foto_surat'] ?>" class="img-fluid"
                                                        width="300" height="300" />
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="suratIzin.php" method="POST" style="display:inline;">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <input type="hidden" name="id_surat"
                                                            value="<?= $surat['id_surat'] ?>" />
                                                        <input type="hidden" name="status" value="verified" />
                                                        <button type="submit" class="btn btn-success">Verified</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Tab Disable -->
        </div>
    </div>
    <!-- End tab Verified -->
</div>

</div>

<!-- <?php include '../template/footerGuru.php' ?> -->