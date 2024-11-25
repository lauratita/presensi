<?php 
ob_start();
include '../template/headerAdmin.php';
include_once '../controller/pgwcontroller.php';

$controller = new PegawaiController();
$pgws = [];
$pgwnik = [];
$showEditModal = false;

// Fetch data
$data = $controller->read();
if ($data !== false) {
    $decodedData = json_decode($data, true);
    if (json_last_error() === JSON_ERROR_NONE && !isset($decodedData['message']) || $decodedData['message'] !== 'Data not found') {
        $pgws = $decodedData;
    }
} else {
    echo "Error fetching data.";
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

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
    $action = $_GET['action'] ?? null;

    if ($action === 'delete' && isset($_GET['nik'])) {
        $nik = filter_input(INPUT_GET, 'nik', FILTER_SANITIZE_STRING);
        $result = $controller->delete($nik);
        if ($result) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } elseif (isset($_GET['nik'])) {
        $nik = filter_input(INPUT_GET, 'nik', FILTER_SANITIZE_STRING);
        $data = $controller->getByNik($nik);

        if ($data !== false) {
            $decodedData = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($decodedData[0])) {
                $pgwnik = $decodedData[0];
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
<head>
    <title>Daftar Pegawai</title>
</head>
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Daftar Pegawai</h1>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-secondary">Tabel Pegawai</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahPegawai">
                    <i class="fas fa-plus"></i> Tambah Pegawai
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>No Handphone</th>
                                <th>Jenis Pegawai</th>
                                <th>Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pgws)) : ?>
                                <?php foreach ($pgws as $pgw) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pgw['nik_pegawai']) ?></td>
                                        <td><?= htmlspecialchars($pgw['nama']) ?></td>
                                        <td><?= htmlspecialchars($pgw['alamat']) ?></td>
                                        <td><?= htmlspecialchars($pgw['jenis_kelamin']) ?></td>
                                        <td><?= htmlspecialchars($pgw['no_hp']) ?></td>
                                        <td><?= htmlspecialchars($pgw['id_jenis']) ?></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-circle btn-sm"
                                               data-toggle="modal" data-target="#modalRead"
                                               data-nik="<?= htmlspecialchars($pgw['nik_pegawai']) ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="pegawai.php?nik=<?= htmlspecialchars($pgw['nik_pegawai']) ?>"
                                               data-toggle="modal" data-target="#modalEdit"
                                               class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-circle btn-sm"
                                               data-toggle="modal" data-target="#modalHapus"
                                               data-nik="<?= htmlspecialchars($pgw['nik_pegawai']) ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>    
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Pegawai -->
    <div class="modal fade" id="modalTambahPegawai" tabindex="-1" role="dialog" aria-labelledby="modalTambahPegawaiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPegawaiLabel">Tambah Data Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="?action=create">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Handphone</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="Masukkan No Handphone" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                        </div>
                        <div class="form-group">
                            <label for="id_jenis">Jenis Pegawai</label>
                            <input type="text" class="form-control" name="id_jenis" placeholder="Masukkan Jenis Pegawai" required>
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

    <!-- Auto-trigger modal edit jika diperlukan -->
    <?php if ($showEditModal) : ?>
        <script>
            $(document).ready(function() {
                $('#modalEdit').modal('show');
            });
        </script>
    <?php endif; ?>

</body>
</html>

<?php 
if (file_exists('../template/footerAdmin.php')) {
    include '../template/footerAdmin.php';
} else {
    echo "Error: Footer file not found.";
}
?>