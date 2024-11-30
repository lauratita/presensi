<?php 

ob_start();
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'kelas';
include '../template/headerAdmin.php';
include_once '../controller/kelasController.php';
$showEditModal= false;
$controller = new KelasController();
$data = $controller->read();
$kelass = [];

$pegawaitambah = $controller->pegawaiTambah(); 
$datapegawaitambah = json_decode($pegawaitambah, true);


if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $kelass = $data;
        // var_dump($kelass);
    }
} else {
    // Handle errors from getAllOrtu()
    echo "Error fetching data.";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengecek tindakan berdasarkan nilai action
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        // Proses edit data
        $result = $controller->update($_POST);
        if ($result) {
            $_SESSION['message'] = "Data berhasil diperbaharui!";
            $_SESSION['type'] = "success";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        // Proses tambah data (create)
        $result = $controller->create($_POST);
        if ($result) {
            $_SESSION['message'] = "Data berhasil ditambahkan!";
            $_SESSION['type'] = "success";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    // Proses delete data
    $id_kelas = $_GET['id'];
    $result = $controller->delete($id_kelas);
    if ($result) {
        $_SESSION['message'] = "Data berhasil dihapus!";
        $_SESSION['type'] = "success";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
$kelasid = [];

if (isset($_GET['id'])) {
    $id_kelas = $_GET['id'];
    $datakelas = $controller->getById($id_kelas);
    $pegawaiEdit = $controller->pegawaiEdit($id_kelas); 

    if ($datakelas !== false) {
        // Decode JSON as associative array
        $datakelas = json_decode($datakelas, true);
        $datapegawaiedit = json_decode($pegawaiEdit, true);
        
        if (is_array($datakelas) && (!isset($datakelas['message']) || $datakelas['message'] !== 'Data not found')) {
            $kelasid = $datakelas[0];
            $showEditModal= true;
            // $pegawaiku = $controller->getPegawai($kelasid['nik_pegawai']);
            // var_dump($kelasid); 
        } else {
            echo 'Data not found';
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
            <h1 class="h4 mb-0 text-gray-800">Daftar Kelas</h1>

        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-secondary">Tabel Kelas</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modalTambahKelas">
                    <i class="fas fa-plus"></i> Tambah Kelas
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Kelas</th>
                                <th>Nama</th>
                                <th>Wali Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($kelass as $kelas) : ?>
                            <tr>
                                <td><?= htmlspecialchars($kelas['id_kelas']) ?></td>
                                <td><?= htmlspecialchars($kelas['nama_kelas']) ?></td>
                                <td><?= htmlspecialchars($kelas['nama_wali_kelas']) ?></td>
                                <td>
                                    <!-- Circle Buttons (Small) -->
                                    <a href="?id=<?= htmlspecialchars($kelas['id_kelas']) ?>" class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" 
                                        data-toggle="modal"
                                        data-target="#modalHapusKelas"
                                        data-id="<?= htmlspecialchars($kelas['id_kelas']) ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="modalHapusKelas" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
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
                    Apakah Anda yakin ingin menghapus item ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="#" id="btnHapusKelas" type="button" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data Kelas -->
    <div class="modal fade" id="modalTambahKelas" tabindex="-1" role="dialog" aria-labelledby="modalTambahKelasLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKelasLabel">Tambah Data Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk tambah data kelas -->
                    <form id="formTambahKelas" method="POST" action="?action=create">
                        <div class="form-group">
                            <label for="namaKelas">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama_kelas" id="namaKelas" placeholder="Masukkan Nama Kelas">
                        </div>
                        <div class="form-group">
                            <label for="nik_pegawai">Wali Kelas</label>
                            <select class="form-control" id="nik_pegawai" name="nik_pegawai">
                                <option value="">Pilih waliKelas</option>
                                    <?php if (!empty($datapegawaitambah)): ?>
                                        <?php foreach ($datapegawaitambah as $pegawaitambah): ?>
                                        <option value="<?= htmlspecialchars($pegawaitambah['nik_pegawai']) ?>">
                                            <?= htmlspecialchars($pegawaitambah['nama']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="">Data tidak tersedia</option>
                                    <?php endif; ?>
                            </select>
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

        <!-- Modal Edit Data Kelas -->
        <?php if ($showEditModal && !empty($kelasid)): ?>
        <div class="modal fade" id="modalEditKelas" tabindex="-1" role="dialog" aria-labelledby="modalEditKelasLabel"
            >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKelasLabel">Edit Data Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form untuk  edit kelas -->
                        <form id="formEditKelas" method="POST" action="?action=update">
                            <input type="hidden" name="id_kelas" value="<?= $kelasid['id_kelas'] ?>">
                            <div class="form-group">
                                <label for="namaKelas">Nama Kelas</label>
                                <input type="text" class="form-control" id="editnama_kelas" name="editnama_kelas"
                                value="<?=$kelasid['nama_kelas']?>" placeholder="Masukkan Nama Kelas">
                            </div>
                            <div class="form-group">
                                <label for="waliKelas">Wali Kelas</label>
                                <select class="form-control" id="editnik_pegawai" name="editnik_pegawai">
                                    <option value="">Pilih Wali Kelas</option>
                                        <?php if (!empty($datapegawaiedit)): ?>
                                            <?php foreach ($datapegawaiedit as $pegawaiEdit): ?>
                                                <option value="<?= htmlspecialchars($pegawaiEdit['nik_pegawai']) ?>"
                                                    <?= ($pegawaiEdit['nik_pegawai'] == $kelasid['nik_pegawai']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($pegawaiEdit['nama']) ?>
                                                </option>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data tidak tersedia</option>
                                        <?php endif; ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" name="update" class="btn btn-primary" >Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <script>
                $(document).ready(function() {
                $('#modalEditKelas').modal('show');
                });
            </script>
            <?php endif?>
        </div>
            </div>
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