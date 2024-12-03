<?php 
ob_start();
$activeMenu = 'pegawai'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'jenispegawai';
include '../template/headerAdmin.php';
include_once '../controller/jpgwcontroller.php';
$controller = new JPGWController();
$jpgws = [];
$jpgwid = [];
$showEditModal = false;

// Fetch data
$data = $controller->read();
if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $jpgws = $data;
    }
} else {
    echo "Error fetching data.";
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? $_POST['action'] ?? null;

    if ($action === 'update') {
        $result = $controller->update($_POST);
        if ($result) {

            $_SESSION['message'] = "Jenis pegawai berhasil diperbaharui!";
            $_SESSION['type'] = "success";

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } elseif ($action === 'create') {
        $result = $controller->create($_POST);
        if ($result) {

            $_SESSION['message'] = "Jenis pegawai berhasil ditambahkan!";
            $_SESSION['type'] = "success";

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Handle GET request for delete or edit
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $idJenis = $_GET['id'];
        $result = $controller->delete($idJenis);
        if ($result) {

            $_SESSION['message'] = "Jenis pegawai berhasil dihapus!";
            $_SESSION['type'] = "success";

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } elseif (isset($_GET['id'])) {
        $idJenis = $_GET['id'];
        $data = $controller->getByIdJenis($idJenis);

        if ($data !== false) {
            $data = json_decode($data, true);
            if (is_array($data) && (!isset($data['message']) || $data['message'] !== 'Data not found')) {
                $jpgwid = $data[0];
                $showEditModal = true;
            } else {
                echo 'Data not found.';
            }
        } else {
            echo 'Error fetching data.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Jenis Pegawai</h1>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">

                <button class="nav-link active" data-toggle="tab" href="#tab-jenisPegawai">Jenis Pegawai</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-toggle="tab" href="#tab-tambahJPGW">Tambah Jenis Pegawai</button>
            </li>
        </ul>
        <div class="tab-content">
            
           <!-- Tab Data Ortu -->
           <div class="tab-pane fade show active" id="tab-jenisPegawai" role="tabpanel" aria-labelledby="nav-jenisPegawai-tab">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-secondary">Tabel Jenis Pegawai</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableOrtu" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                        <th>ID Jenis</th>
                                        <th>Jenis Pegawai</th> 
                                        <th>Aksi</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($jpgws as $jpgw): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($jpgw['id_jenis']) ?></td>
                                        <td><?= htmlspecialchars($jpgw['nama']) ?></td>
                                        <td>
                                            <a href="?id=<?= htmlspecialchars($jpgw['id_jenis']) ?>" class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <a href="#" class="btn btn-danger btn-circle btn-sm" 
                                                data-toggle="modal"
                                                data-target="#modalHapusJPegawai"
                                                data-id="<?= htmlspecialchars($jpgw['id_jenis']) ?>">
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

            <!-- Tab Tambah Jenis Pegawai -->
            <div class="tab-pane fade" id="tab-tambahJPGW">
            <div class="card shadow mb-4 mt-4">
                <div class="card-body">
                    <form action="?action=create" method="POST" id="formTambahJenisPegawai">
                        <div class="form-group">
                            <label for="TambahJenisPegawai">Tambah Jenis Pegawai</label>
                            <input type="text" class="form-control" id="TambahJenisPegawai" name="nama" placeholder="Masukkan Jenis Pegawai" required>
                        </div>
                        <div class="modal-footer">
                            <!-- Tombol Batal yang hanya menutup modal -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>    
            </div>
        </div>
        
        <!-- Modal Hapus -->
        <div class="modal fade" id="modalHapusJPegawai" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
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
                        <a id="btnHapusJPegawai" href="#" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <?php if ($showEditModal && !empty($jpgwid)): ?>
        <div class="modal fade show" id="modalEdit" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="?action=update">
                        <div class="modal-header">
                            <h5>Edit Jenis Pegawai</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_jenis" value="<?= $jpgwid['id_jenis'] ?>">
                            <div class="form-group">
                                <label for="editJPGW">Jenis Pegawai</label>
                                <input type="text" class="form-control" id="editJPGW" name="editjenisPegawai" value="<?= $jpgwid['nama'] ?>">
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
        // Clear session messages after displaying
        unset($_SESSION['message']);
        unset($_SESSION['type']);
        ?>
    <?php endif; ?>

</body>

</html>
<?php include '../template/footerAdmin.php'; ?>