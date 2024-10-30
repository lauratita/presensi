<?php 
ob_start();
include '../template/headerAdmin.php'; 
include_once '../admin/controler/ortucontroler.php';

$controller = new OrtuControler();
$ortus = json_decode($controller->read(), true);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $result = $controller->create($_POST);
//     if ($result) {
//         header("Location: " . $_SERVER['PHP_SELF']);
//         exit();
//     }
// }


// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $controller->update($_POST);
//     header("Location: " . $_SERVER['PHP_SELF']);
// }

// if (isset($_GET['nik'])) {
//     $controller->delete(['nik' => $_GET['nik']]);
//     header("Location: " . $_SERVER['PHP_SELF']);
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nik'])) {
//     $result = $controller->delete(['nik' => $_POST['nik']]);
// }

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
                <div class="card-header py-3 d-flex justify-content-between align-items-center" >
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
                                <td><?= $ortu['nik'] ?></td>
                                <td><?= $ortu['nama'] ?></td>
                                <td><?= $ortu['jenis_kelamin'] ?></td>
                                <td><?= $ortu['email'] ?></td>
                                <td><?= $ortu['no_hp'] ?></td>
                                <td><?= $ortu['alamat'] ?></td>
                                <td><!-- Circle Buttons (Small) -->
                                    <a href="" class="btn btn-info btn-circle btn-sm" data-nik="<?=$ortu['nik']?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="?action=edit&nik=<?= $ortu['nik'];?>" class="btn btn-warning btn-circle btn-sm edit-btn" >
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#modalHapus" data-nik="<?= $ortu['nik'] ?>">
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
                                <input type="text" class="form-control" name="nama" id="namaOrtu" placeholder="Masukkan Nama Orang Tua" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="jkOrtu">Jenis Kelamin</label>
                                <select class="form-control" id="jkOrtu" name="jenis_kelamin" >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan Email">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"  placeholder="Masukkan Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="nohp">No HP</label>
                                <input type="text" class="form-control" name="no_hp" id="nohp"  placeholder="Masukkan No HP" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <label for="alamatOrtu">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamatOrtu" placeholder="Masukkan Alamat" ></textarea>
                            </div>
                        </div>
                        <div class="form-group text-right mt-3">
                            <button type="button" class="btn btn-secondary pe-4" data-dismiss="modal">Batal</button>
                            <!-- <button type="submit" name="edit" class="btn btn-warning">Edit</button>
                            <button type="submit"  name="create" class="btn btn-primary ">Simpan</button> -->
                            <button type="submit" class="btn btn-primary">
                                <?= isset($_GET['action']) && $_GET['action'] === 'edit' ? 'Edit' : 'Simpan'; ?>
                            </button>
                        </div>
                    </form>
                </div>    
            </div>        
        </div>
    </div>

    <!-- Tombol Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
        aria-hidden="true" >
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
                    <!-- <button href="<?= $ortu['nik']?>" type="button" class="btn btn-danger">Hapus</button> -->
                    <a id="btnHapus" href="#" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../template/footerAdmin.php'; ?>