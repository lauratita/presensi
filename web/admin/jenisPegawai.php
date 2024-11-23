<?php 
ob_start();
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
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } elseif ($action === 'create') {
        $result = $controller->create($_POST);
        if ($result) {
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
                <button class="nav-link active" data-toggle="tab" href="#tab-tambahJPGW">Tambah Jenis Pegawai</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-toggle="tab" href="#tab-jenisPegawai">Jenis Pegawai</button>
            </li>
        </ul>
        <div class="tab-content">

            <!-- Tab Tambah Jenis Pegawai -->
            <div class="tab-pane fade show active" id="tab-tambahJPGW">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-body">
                        <form action="?action=create" method="POST">
                            <div class="form-group">
                                <label for="TambahJenisPegawai">Tambah Jenis Pegawai</label>
                                <input type="text" class="form-control" id="TambahJenisPegawai" name="nama" placeholder="Masukkan Jenis Pegawai" required>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>    
                </div>
            </div>

            <!-- Tab Jenis Pegawai -->
            <div class="tab-pane fade" id="tab-jenisPegawai">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableJPGW">
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
                                            <a href="?action=delete&id=<?= htmlspecialchars($jpgw['id_jenis']) ?>" class="btn btn-danger btn-circle btn-sm">
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

    </body>
</html>
<?php include '../template/footerAdmin.php'; ?>