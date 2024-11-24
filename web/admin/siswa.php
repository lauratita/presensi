<?php 
ob_start();
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'siswa';
include '../template/headerAdmin.php'; 
include_once '../controller/siswaController.php';
$showEditModal= false;
$controller = new SiswaController();
$data = $controller->read();
$siswas = [];

$ortu = $controller->getortu(); 
$dataortu = json_decode($ortu, true);

$kelas = $controller->getkelas(); 
$datakelas = json_decode($kelas, true);

if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $siswas = $data;
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
    $id_kelas = $_GET['id'];
    $result = $controller->delete($id_kelas);
    if ($result) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
$siswanis=[];
if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];
    $datasiswa = $controller->getByNis($nis);
    // $pegawaiEdit = $controller->pegawaiEdit($id_kelas); 

    if ($datasiswa !== false) {
        // Decode JSON as associative array
        $datasiswa = json_decode($datasiswa, true);
        
        if (is_array($datasiswa) && (!isset($datasiswa['message']) || $datasiswa['message'] !== 'Data not found')) {
            $siswanis = $datasiswa[0];
            $showEditModal= true;
            // $pegawaiku = $controller->getPegawai($kelasid['nik_pegawai']);
            var_dump($kelasid); 
        } else {
            echo 'Data not found';
        }
    } else {
        echo 'Error fetching data.';
    }
}
?>

<html lang="en">
<body>
<div class="container-fluid">
 <h6 class="m-0 mt-4 mb-4 font-weight-bold text-primary"><span class="text-muted fw-flight">Data Siswa</span></h6>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="nav-dataSiswa-tab" data-toggle="tab" href="#tab-dataSiswa"
                data-bs-target="#nav-dataSiswa" type="button" role="tab" aria-controls="tab-dataSiswa"
                aria-selected="true">Data</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="nav-tambahSiswa-tab" data-toggle="tab" href="#tab-tambahSiswa"
                data-bs-target="#nav-tambahSiswa" type="button" role="tab" aria-controls="tab-tambahSiswa"
                aria-selected="false">Tambah Data</button>
        </li>
    </ul>

    <div class="tab-content" id="TabContent">
        <!-- Tab Data Ortu -->
        <div class="tab-pane fade show active" id="tab-dataSiswa" role="tabpanel" aria-labelledby="nav-dataSiswa-tab">
            <div class="card shadow mb-4 mt-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" >
                    <h6 class="m-0 font-weight-bold text-secondary">Tabel Kelas</h6>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th> 
                                <th>Tahun Masuk</th>
                                <th>Alamat</th>
                                <th>Kelas</th> 
                                <th>Aksi</th>       
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($siswas as $siswa) : ?>
                            <tr>
                                <td><?= htmlspecialchars($siswa['nis']) ?></td>
                                <td><?= htmlspecialchars($siswa['nama']) ?></td>
                                <td><?= htmlspecialchars($siswa['tanggal_lahir']) ?></td>
                                <td><?= htmlspecialchars($siswa['tahun_akademik']) ?></td>
                                <td><?= htmlspecialchars($siswa['alamat']) ?></td>
                                <td><?= htmlspecialchars($siswa['id_kelas']) ?></td>
                                
                                
                                <td><!-- Circle Buttons (Small) -->
                                    <a href="#" class="btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="?nis=<?= htmlspecialchars($siswa['nis']) ?>" class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#modalHapus">
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
        <div class="tab-pane fade" id="tab-tambahSiswa" role="tabpanel" aria-labelledby="nav-tambahSiswa-tab">
            <div class="card shadow mb-4 mt-4">
                <div class="card-body">
                    <form id="formTambahSiswa" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control" name="nis" id="nis" placeholder="Masukkan NIS" required>
                            </div>
                            <div class="col-md-5 mt-3">
                                <label for="namaSiswa">Nama</label>
                                <input type="text" class="form-control" name="nama" id="namaSiswa" placeholder="Masukkan Nama" required>
                            </div>
                            <!-- <div class="col-md-3 mt-3">
                                <label for="namaSiswa">Nama</label>
                                <input type="text" class="form-control" name="id_foto" id="namaSiswa" placeholder="Masukkan Nama" required>
                            </div> -->
                            <div class="col-md-2 mt-3">
                                <label for="kelas">Tahun Masuk</label>
                                <input type="year" class="form-control yearpicker" name="tahun_akademik" id="tahunMasuk" placeholder="Pilih tahun">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label for="jkSiswa">Jenis Kelamin</label>
                                <select class="form-control" id="jkSiswa" name="jenis_kelamin" >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="password" name="tanggal_lahir" placeholder="Masukkan Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
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
                            <div class="col-md-6 mt-3">
                                <label for="nik_ortu">Orang Tua</label>
                                <select class="form-control" id="nik_ortu" name="nik_ortu">
                                    <option value="">Pilih Orang Tua</option>
                                        <?php if (!empty($dataortu)): ?>
                                            <?php foreach ($dataortu as $ortu): ?>
                                            <option value="<?= htmlspecialchars($ortu['nik_ortu']) ?>">
                                                <?= htmlspecialchars($ortu['nama']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data tidak tersedia</option>
                                        <?php endif; ?>
                                </select>
                            </div>
                        </div>               
                            <div class="form-group mt-3">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" required></textarea>
                            </div>
                        <div class="row">
                            <div class="container-upfoto">
                                <input type="file" id="file1" name="foto_depan" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto depan</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file2" name="foto_kiri"accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto Kiri</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file3" name="foto_kanan" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto Kanan</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file4" name="foto_atas" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto Atas</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file5" name="foto_bawah" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto Bawah</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" name="create" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>    
            </div> 
    </div>

</div>    
<!-- Tombol Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
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
            <button type="button" class="btn btn-danger">Hapus</button>
          </div>
        </div>
      </div>
    </div>
</body>
</html>
<?php include '../template/footerAdmin.php'; ?>