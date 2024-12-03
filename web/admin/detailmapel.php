<?php 
ob_start(); 
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'siswa';
include '../template/headerAdmin.php';
include_once '../controller/dmapelcontroller.php';

$showEditModal= false;
$controller = new DMapelController();
$data = $controller->read();
$dmpls = [];

$kelas = $controller->getkelas(); 
$datakelas = json_decode($kelas, true);

$mapel = $controller->getmapel(); 
$datamapel = json_decode($mapel, true);

$guru = $controller->getguru(); 
$dataguru = json_decode($guru, true);

if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $dmpls = $data;
    }
} else {
    echo "Error fetching data.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengecek tindakan berdasarkan nilai action
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        // Proses edit data
        $result = $controller->update($_POST);
        if ($result) {
            $_SESSION['message'] = "Detail mata pelajaran berhasil diperbaharui!";
            $_SESSION['type'] = "success";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        // Proses tambah data (create)
        $result = $controller->create($_POST);
        if ($result) {
            $_SESSION['message'] = "Detail mata pelajaran berhasil ditambahkan!";
            $_SESSION['type'] = "success";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    // Proses delete data
    $id_jadwal_mapel = $_GET['id'];
    $result = $controller->delete($id_jadwal_mapel);
    if ($result) {
        $_SESSION['message'] = "Detail mata pelajaran berhasil dihapus!";
        $_SESSION['type'] = "success";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
$dmplid = [];

if (isset($_GET['id'])) {
    $id_jadwal_mapel = $_GET['id'];
    $data = $controller->getByID($id_jadwal_mapel); 

    if ($data !== false) {
        $data = json_decode($data, true);
        
        if (is_array($data) && (!isset($data['message']) || $data['message'] !== 'Data not found')) {
            $dmplid = $data[0];
            $showEditModal= true;
            // var_dump($dmplid); 
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
<head>
    <title>Detail Mata Pelajaran</title>
</head>
<body>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Detail Mata Pelajaran</h1>
        </div>

        <!-- Card Tabel -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-secondary">Tabel Detail Mata Pelajaran</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahMapel">
                    <i class="fas fa-plus"></i> Tambah Detail
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTableOrtu" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Jadwal</th>
                                <th>Hari</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Jam Awal</th>
                                <th>Jam Akhir</th>
                                <th>Guru</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dmpls as $dmpl): ?>
                                <tr>
                                    <td><?= htmlspecialchars($dmpl['id_jadwal_mapel']) ?></td>
                                    <td><?= htmlspecialchars($dmpl['hari']) ?></td>
                                    <td><?= htmlspecialchars($dmpl['nama_kelas']) ?></td>
                                    <td><?= htmlspecialchars($dmpl['nama_mapel']) ?></td>
                                    <td><?= htmlspecialchars($dmpl['jam_awal']) ?></td>
                                    <td><?= htmlspecialchars($dmpl['jam_akhir']) ?></td>
                                    <td><?= htmlspecialchars($dmpl['nama_guru']) ?></td>
                                    <td>
                                        <a href="?id=<?= htmlspecialchars($dmpl['id_jadwal_mapel']) ?>"
                                            class="btn btn-warning btn-circle btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="?id=<?= htmlspecialchars($dmpl['id_jadwal_mapel']) ?>"
                                            data-toggle="modal" data-target="#modalHapusDetail"
                                            class="btn btn-danger btn-circle btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        </td>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!-- Logout Modal-->
<div class="modal fade" id="modalHapusDetail" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
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
                    <a href="#" id="btnHapusDetail" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jadwal Mapel -->
    <div class="modal fade" id="modalTambahMapel" tabindex="-1" role="dialog" aria-labelledby="modalTambahMapelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahMapelLabel">Tambah Data Mata Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk tambah data mapel -->
                    <form id="formTambahPegawai" method="POST" action="?action=create">
                    <div class="form-group">
                            <label for="hari">Hari</label>
                            <select class="form-control" name="hari" required>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                    <div class="form-group">
                        <label for="jam_awal">Jam Awal</label>
                        <input type="time" class="form-control" name="jam_awal" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_akhir">Jam Akhir</label>
                        <input type="time" class="form-control" name="jam_akhir" required>
                    </div>
                    <div class="form-group">
                            <label for="id_kelas">Kelas</label>
                            <select class="form-control" id="id_kelas" name="id_kelas">
                                <option value="">Pilih Kelas</option>
                                    <?php if (!empty($datakelas)): ?>
                                        <?php foreach ($datakelas as $kelas): ?>
                                        <option value="<?= htmlspecialchars($kelas['id_kelas']) ?>">
                                            <?= htmlspecialchars($kelas['nama_kelas']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <option value="">Data tidak tersedia</option>
                                    <?php endif; ?>
                            </select>
                        </div>
                    <div class="form-group">
                            <label for="kd_mapel">Mata Pelajaran</label>
                            <select class="form-control" id="kd_mapel" name="kd_mapel">
                                <option value="">Pilih Mata Pelajaran</option>
                                    <?php if (!empty($datamapel)): ?>
                                        <?php foreach ($datamapel as $mapel): ?>
                                        <option value="<?= htmlspecialchars($mapel['kd_mapel']) ?>">
                                            <?= htmlspecialchars($mapel['nama']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <option value="">Data tidak tersedia</option>
                                    <?php endif; ?>
                            </select>
                        </div>
                    <div class="form-group">
                            <label for="nik_pegawai">Guru</label>
                            <select class="form-control" id="nik_pegawai" name="nik_pegawai">
                                <option value="">Pilih Guru</option>
                                    <?php if (!empty($dataguru)): ?>
                                        <?php foreach ($dataguru as $guru): ?>
                                        <option value="<?= htmlspecialchars($guru['nik_pegawai']) ?>">
                                            <?= htmlspecialchars($guru['nama']) ?>
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

    <!-- Modal Edit Data Mata Pelajaran -->
    <?php if ($showEditModal && !empty($dmplid)): ?>
        <div class="modal fade" id="modalEditDetail" tabindex="-1" role="dialog" aria-labelledby="modalEditDetailLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditDetailLabel">Edit Detail Mata Pelajaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form untuk edit detail mapel -->
                        <form id="formEditDetail" method="POST" action="?action=update">
                        <div class="form-group">
                            <label for="edithari">Hari</label>
                                <select class="form-control" id="edithari" name="edithari" required>
                                    <option value="Senin" <?= $dmplid['hari'] == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                    <option value="Selasa" <?= $dmplid['hari'] == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                    <option value="Rabu" <?= $dmplid['hari'] == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                    <option value="Kamis" <?= $dmplid['hari'] == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                    <option value="Jumat" <?= $dmplid['hari'] == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                    <option value="Sabtu" <?= $dmplid['hari'] == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editjamawal">Jam Awal</label>
                                        <input type="time" class="form-control" id="editjamawal" name="editjamawal" 
                                            value="<?= $dmplid['jam_awal'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editjamakhir">Jam Akhir</label>
                                        <input type="time" class="form-control" id="editjamakhir" name="editjamakhir" 
                                            value="<?= $dmplid['jam_akhir'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editkelas">Kelas</label>
                                        <select class="form-control" id="editkelas" name="editkelas" required>
                                            <?php foreach ($datakelas as $kelas): ?>
                                                <option value="<?= htmlspecialchars($kelas['id_kelas']) ?>"
                                                    <?= $dmplid['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($kelas['nama_kelas']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editmapel">Mata Pelajaran</label>
                                        <select class="form-control" id="editmapel" name="editmapel" required>
                                            <?php foreach ($datamapel as $mapel): ?>
                                                <option value="<?= htmlspecialchars($mapel['kd_mapel']) ?>"
                                                    <?= $dmplid['kd_mapel'] == $mapel['kd_mapel'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($mapel['nama']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editguru">Guru</label>
                                        <select class="form-control" id="editguru" name="editguru" required>
                                            <?php foreach ($dataguru as $guru): ?>
                                                <option value="<?= htmlspecialchars($guru['nik_pegawai']) ?>"
                                                    <?= $dmplid['nik_pegawai'] == $guru['nik_pegawai'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($guru['nama']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
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
                $('#modalEditDetail').modal('show');
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