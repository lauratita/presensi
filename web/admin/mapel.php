<?php 
ob_start();
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
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        // Proses tambah data
        $result = $controller->create($_POST);
        if ($result) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Menangani request GET untuk delete data
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $kode = $_GET['kode'];
    $result = $controller->delete($kode);
    if ($result) {
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
            <div class="tab-pane fade show active" id="tab-mataPelajaran">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableMapel">
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
                                        <a href="?action=delete&kode=<?= htmlspecialchars($mpl['kd_mapel']) ?>" class="btn btn-danger btn-circle btn-sm">
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

    </body>
</html>
<?php include '../template/footerAdmin.php'; ?>
