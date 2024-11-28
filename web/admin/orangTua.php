<?php 
ob_start();

include '../template/headerAdmin.php';
include_once '../controller/ortucontroler.php';
$showEditModal= false;
$controller = new OrtuControler();
$data = $controller->read();
$ortus = [];

if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $ortus = $data;
        // var_dump($ortus);
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
    $nik = $_GET['nik'];
    $result = $controller->delete($nik);
    if ($result) {
        $_SESSION['message'] = "Data berhasil dihapus!";
            $_SESSION['type'] = "success";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
$ortunik = [];

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $datanik = $controller->getByNik($nik);

    if ($datanik !== false) {
        // Decode JSON as associative array
        $datanik = json_decode($datanik, true);
        
        if (is_array($datanik) && (!isset($datanik['message']) || $datanik['message'] !== 'Data not found')) {
            $ortunik = $datanik[0];
            $showEditModal= true;
            // var_dump($ortunik); 
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
        <h6 class="m-0 mt-4 mb-4 font-weight-bold text-primary"><span class="text-muted fw-flight">Data Orang Tua</span>
        </h6>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="nav-dataOrtu-tab" data-toggle="tab" href="#tab-dataOrtu"
                    data-bs-target="#nav-dataOrtu" type="button" role="tab" aria-controls="tab-dataOrtu"
                    aria-selected="true">Data</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="nav-tambahOrtu-tab" data-toggle="tab" href="#tab-tambahOrtu"
                    data-bs-target="#nav-tambahOrtu" type="button" role="tab" aria-controls="tab-tambahOrtu"
                    aria-selected="false">Tambah Data</button>
            </li>
        </ul>


        <div class="tab-content" id="TabContent">
            <!-- Tab Data Ortu -->
            <div class="tab-pane fade show active" id="tab-dataOrtu" role="tabpanel" aria-labelledby="nav-dataOrtu-tab">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-secondary">Tabel Orang Tua</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableOrtu" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ortus as $ortu) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ortu['nik_ortu']) ?></td>
                                        <td><?= htmlspecialchars($ortu['nama']) ?></td>
                                        <td><?= htmlspecialchars($ortu['jenis_kelamin']) ?></td>
                                        <td><?= htmlspecialchars($ortu['email']) ?></td>
                                        <td><?= htmlspecialchars($ortu['no_hp']) ?></td>
                                        <td><?= htmlspecialchars($ortu['alamat']) ?></td>
                                        <td>
                                            <a href="" class="btn btn-info btn-circle btn-sm"
                                                data-nik="<?= htmlspecialchars($ortu['nik_ortu']) ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="?nik=<?= htmlspecialchars($ortu['nik_ortu']) ?>"
                                                class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                                data-target="#modalHapusOrtu"
                                                data-nik="<?= htmlspecialchars($ortu['nik_ortu']) ?>">
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
            <!-- End Data Ortu -->
            <!-- tab tambah data -->
            <div class="tab-pane fade" id="tab-tambahOrtu" role="tabpanel" aria-labelledby="nav-tambahOrtu-tab">
                <div class="card shadow mb-4 mt-4">
                    <div class="card-body">
                        <form id="formTambahOrtu" method="POST" action="?action=create">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="namaOrtu">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="namaOrtu"
                                        placeholder="Masukkan Nama Orang Tua" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="jkOrtu">Jenis Kelamin</label>
                                    <select class="form-control" id="jkOrtu" name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        placeholder="Masukkan Email">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" name="nik" id="nik"
                                        placeholder="Masukkan NIK">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="nohp">No HP</label>
                                    <input type="text" class="form-control" name="no_hp" id="nohp"
                                        placeholder="Masukkan No HP" required>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <label for="alamatOrtu">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamatOrtu"
                                        placeholder="Masukkan Alamat"></textarea>
                                </div>
                            </div>
                            <div class="form-group text-right mt-3">
                                <button type="button" class="btn btn-secondary pe-4" data-dismiss="modal">Batal</button>
                                <button type="submit" name="create" class="btn btn-primary ">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Hapus -->
        <div class="modal fade" id="modalHapusOrtu" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
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
                        <a id="btnHapusOrtu" href="#" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Data -->
        <?php if ($showEditModal && !empty($ortunik)): ?>
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Data Orang Tua</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formEditOrtu" method="POST" action="<?= $_SERVER['PHP_SELF']; ?>?action=update">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="editNikOrtu">NIK</label>
                                    <input type="text" class="form-control" name="editnik" id="editNik"
                                        value="<?= $ortunik['nik_ortu']?>">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="editNamaOrtu">Nama</label>
                                    <input type="text" class="form-control" name="editnama" id="editNamaOrtu"
                                        value="<?=$ortunik['nama']?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="editJkOrtu">Jenis Kelamin</label>
                                    <select class="form-control" name="editjenis_kelamin" id="editJkOrtu">
                                        <option value="Laki-laki"
                                            <?= $ortunik['jenis_kelamin'] == 'laki-laki' ? 'selected' : '' ?>>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            <?= $ortunik['jenis_kelamin'] == 'perempuan' ? 'selected' : '' ?>>Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="editpassword" id="editPassword"
                                        value="<?= $ortunik['password'] ?>" placeholder="Masukkan Password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="editEmail">Email</label>
                                    <input type="text" class="form-control" name="editemail" id="editEmail"
                                        value="<?= $ortunik['email'] ?>" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="editNoHp">No HP</label>
                                    <input type="text" class="form-control" name="editno_hp" id="editNoHp"
                                        value="<?= $ortunik['no_hp'] ?>" required>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="editAlamatOrtu">Alamat</label>
                                <textarea class="form-control" name="editalamat"
                                    id="editAlamatOrtu"><?= $ortunik['alamat'] ?></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
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