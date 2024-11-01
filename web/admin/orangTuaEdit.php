<?php
ob_start();

include '../config/config.php';
include_once '../admin/controler/ortucontroler.php';
$controller = new OrtuControler($con);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengecek tindakan berdasarkan nilai action
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        // Proses edit data
        $result = $controller->update($_POST);
        if ($result) {
            header('Location: orangTua.php');
            exit();
        }else{
            var_dump('gagal');
        }
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $ortugetnik = $controller->getByNik($nik);
    
}
?>
<?php include '../template/headerAdmin.php'; ?>

<div class="card shadow mb-4 mt-4">
    <div class="card-body">
        <form method="POST" action="?action=update">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="namaOrtu">Nama</label>
                    <input type="text" class="form-control" value="<?= $ortugetnik['nama'] ?>" name="nama" id="namaOrtu"
                        placeholder="Masukkan Nama Orang Tua" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="jkOrtu">Jenis Kelamin</label>
                    <select class="form-control" id="jkOrtu" name="jenis_kelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="laki-laki" <?= $ortugetnik['jenis_kelamin'] == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="perempuan" <?= $ortugetnik['jenis_kelamin'] == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="email">Email</label>
                    <input type="text" value="<?= $ortugetnik['email'] ?>" class="form-control" name="email" id="email"
                        placeholder="Masukkan Email">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="password">Password</label>
                    <input type="password" value="<?= $ortugetnik['password'] ?>" class="form-control" name="password" id="password"
                        placeholder="Masukkan Password" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="nik">NIK</label>
                    <input type="text" value="<?= $ortugetnik['nik'] ?>" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="nohp">No HP</label>
                    <input type="text" value="<?= $ortugetnik['no_hp'] ?>" class="form-control" name="no_hp" id="nohp"
                        placeholder="Masukkan No HP" required>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <label for="alamatOrtu">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamatOrtu" placeholder="Masukkan Alamat"><?= $ortugetnik['alamat'] ?></textarea>
                </div>
            </div>
            <div class="form-group text-right mt-3">
                <button type="button" class="btn btn-secondary pe-4" data-dismiss="modal">Batal</button>
                <!-- <button type="submit" name="edit" class="btn btn-warning">Edit</button>
                            <button type="submit"  name="create" class="btn btn-primary ">Simpan</button> -->
                <button type="submit" class="btn btn-primary">
                    <?= isset($_GET['action']) && $_GET['action'] === 'edit' ? 'Edit' : 'Simpan' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../template/footerAdmin.php'; ?>
