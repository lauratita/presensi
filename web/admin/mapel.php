<?php 
ob_start();
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'jadwal_mapel';
include '../template/headerAdmin.php';
include_once '../controller/mapelcontroller.php';

$controller = new MapelController();
$data = $controller->read();
$mpls = [];
$mplkd = null;
$showEditModal = false; 

// Mendapatkan data semua mata pelajaran
if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $mpls = $data;
    }
} else {
    echo "Error fetching data.";
}

// Menangani request POST untuk create atau update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        // Proses edit data
        $result = $controller->update($_POST);
        if ($result) {
            $_SESSION['message'] = "Mata pelajaran berhasil diperbaharui!";
            $_SESSION['type'] = "success";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        // Proses tambah data
        $isDuplicate = false;
        foreach ($mpls as $mpl) {
            if ($mpl['kd_mapel'] === $_POST['kd_mapel']) {
                $isDuplicate = true;
                break;
            }
        }

        if ($isDuplicate) {
            $_SESSION['message'] = "Kode pelajaran sudah ada!";
            $_SESSION['type'] = "error";
        } else {
            $result = $controller->create($_POST);
            if ($result) {
                $_SESSION['message'] = "Mata pelajaran berhasil ditambahkan!";
                $_SESSION['type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal menambahkan mata pelajaran!";
                $_SESSION['type'] = "error";
            }
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Menangani request GET untuk delete data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $kode = $_GET['kode'];
    $result = $controller->delete($kode);
    if ($result) {
        $_SESSION['message'] = "Mata pelajaran berhasil dihapus!";
        $_SESSION['type'] = "success";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Mendapatkan data untuk modal edit jika ada parameter kode
if (isset($_GET['kode']) && !empty($_GET['kode'])) {
    $kode = $_GET['kode'];
    $data = $controller->getByKode($kode);
    if ($data !== false) {
        $data = json_decode($data, true);
        if (is_array($data) && (!isset($data['message']) || $data['message'] !== 'Data not found')) {
            $mplkd = $data[0];
            $showEditModal = true;
        } else {
            echo 'Data not found.';
        }
    } else {
        echo 'Error fetching data.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Mata Pelajaran</h1>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-toggle="tab" href="#tab-mataPelajaran">Mata Pelajaran</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-toggle="tab" href="#tab-detailPelajaran">Tambah Mata Pelajaran</button>
            </li>
        </ul>
        <div class="tab-content">

            <!-- Tab Mata Pelajaran -->
            <div class="tab-pane fade show active" id="tab-mataPelajaran" role="tabpanel" aria-labelledby="nav-mataPelajaran-tab">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-secondary">Tabel Mata Pelajaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableOrtu" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Kode Pelajaran</th>
                                        <th>Nama Pelajaran</th> 
                                        <th>Aksi</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($mpls as $mpl): ?>
                                <tr>
                                    <td><?= htmlspecialchars($mpl['kd_mapel']) ?></td>
                                    <td><?= htmlspecialchars($mpl['nama']) ?></td>
                                    <td>
                                        <a href="?action=update&kode=<?= htmlspecialchars($mpl['kd_mapel']) ?>" class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-circle btn-sm" 
                                           data-toggle="modal"
                                           data-target="#modalHapusMapel"
                                           data-kode="<?= htmlspecialchars($mpl['kd_mapel']) ?>">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Detail Pelajaran -->
            <div class="tab-pane fade" id="tab-detailPelajaran">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-body">
                        <form action="?action=create" method="POST">
                            <div class="form-group">
                                <label for="kdmapel">Kode Pelajaran</label>
                                <input type="text" class="form-control" id="kdmapel" name="kd_mapel" placeholder="Masukkan Kode Pelajaran" required>
                            </div>
                            <div class="form-group">
                                <label for="namamapel">Nama Pelajaran</label>
                                <input type="text" class="form-control" id="namamapel" name="nama" placeholder="Masukkan Nama Pelajaran" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>    

        <!-- Modal Hapus -->
        <div class="modal fade" id="modalHapusMapel" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a id="btnHapusMapel" href="#" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <?php if ($showEditModal && !empty($mplkd)): ?>
        <div class="modal fade show" id="modalEdit" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="?action=update">
                        <div class="modal-header">
                            <h5>Edit Mata Pelajaran</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="kd_mapel" value="<?= $mplkd['kd_mapel'] ?>">
                            <div class="form-group">
                                <label for="editnama">Nama Pelajaran</label>
                                <input type="text" class="form-control" id="editnama" name="nama" value="<?= $mplkd['nama'] ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#modalEdit').modal('show');
            });
        </script>
        <?php endif; ?>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Informasi',
                text: '<?= $_SESSION['message']; ?>',
                icon: '<?= $_SESSION['type']; ?>',
                confirmButtonText: 'OK'
            });
        });
    </script>
    <?php
    unset($_SESSION['message']);
    unset($_SESSION['type']);
    ?>
    <?php endif; ?>

</body>
</html>
<?php include '../template/footerAdmin.php'; ?>