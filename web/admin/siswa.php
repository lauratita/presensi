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
        $result = $controller->update(array_merge($_POST, $_FILES));
        if ($result) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    } else {
        // Proses tambah data (create)
        $result = $controller->create(array_merge($_POST, $_FILES));
        if ($result) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    // Proses delete data
    $nis = $_GET['nis'];
    $result = $controller->delete($nis);
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
            var_dump($siswanis); 
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
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" 
                                        data-toggle="modal"
                                        data-target="#modalHapusSiswa"
                                        data-nis="<?= htmlspecialchars($siswa['nis']) ?>">
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
                    <form id="formTambahSiswa" method="POST" enctype="multipart/form-data" action="?action=create">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control" name="nis" id="nis" placeholder="Masukkan NIS" required>
                            </div>
                            <div class="col-md-5 mt-3">
                                <label for="namaSiswa">Nama</label>
                                <input type="text" class="form-control" name="nama" id="namaSiswa" placeholder="Masukkan Nama" required>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="kelas">Tahun Masuk</label>
                                <input type="year" class="form-control yearpicker" name="tahun_akademik" id="tahunMasuk" placeholder="Pilih tahun">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="jkSiswa">Jenis Kelamin</label>
                                <select class="form-control" id="jkSiswa" name="jenis_kelamin" >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <!-- <div class="col-md-4 mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                            </div> -->
                            <div class="col-md-6 mt-3">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Password" required>
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
                                <input type="file" id="file1" name="foto" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto depan</p>
                                </div>
                                <button type="button" class="select-image">Cari Gambar</button>
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

</div>    
<!-- Tombol Hapus -->
<div class="modal fade" id="modalHapusSiswa" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
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
            <a href="#" id="btnHapusSiswa" type="button" class="btn btn-danger">Hapus</a>
          </div>
        </div>
    </div>
</div>

<?php if ($showEditModal && !empty($siswanis)): ?>
        <div class="modal fade" id="modalEditSiswa" tabindex="-1" role="dialog" aria-labelledby="modalEditKelasLabel"
            >
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKelasLabel">Edit Data Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form untuk  edit kelas -->
                        <form id="formEditSiswa" method="POST" enctype="multipart/form-data" action="?action=update">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control" name="edit_nis" id="editnis" value="<?= $siswanis['nis'] ?>" placeholder="Masukkan NIS" required>
                            </div>
                            <div class="col-md-5 mt-3">
                                <label for="namaSiswa">Nama</label>
                                <input type="text" class="form-control" name="edit_nama" id="neditamaSiswa" placeholder="Masukkan Nama" value="<?= $siswanis['nama'] ?>" required>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="kelas">Tahun Masuk</label>
                                <input type="year" class="form-control yearpicker" name="edit_tahun_akademik" id="edittahunMasuk" value="<?= $siswanis['tahun_akademik'] ?>" placeholder="Pilih tahun">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label for="jkSiswa">Jenis Kelamin</label>
                                <select class="form-control" id="editjkSiswa" name="edit_jenis_kelamin" >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki"
                                            <?= $siswanis['jenis_kelamin'] == 'laki-laki' ? 'selected' : '' ?>>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            <?= $siswanis['jenis_kelamin'] == 'perempuan' ? 'selected' : '' ?>>Perempuan
                                        </option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="editpassword" name="edit_password" placeholder="Masukkan Password" value="<?= $siswanis['password'] ?>" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="edittanggal_lahir" name="edit_tanggal_lahir" placeholder="Masukkan Password" value="<?= $siswanis['tanggal_lahir'] ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="id_kelas">Kelas</label>
                                <select class="form-control" id="editid_kelas" name="edit_id_kelas">
                                    <option value="">Pilih Kelas</option>
                                        <?php if (!empty($datakelas)): ?>
                                            <?php foreach ($datakelas as $kelas): ?>
                                                <option value="<?= htmlspecialchars($kelas['id_kelas']) ?>"
                                                <?= ($kelas['id_kelas'] == $siswanis['id_kelas']) ? 'selected' : '' ?>>
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
                                <select class="form-control" id="editnik_ortu" name="edit_nik_ortu">
                                    <option value="">Pilih Orang Tua</option>
                                        <?php if (!empty($dataortu)): ?>
                                            <?php foreach ($dataortu as $ortu): ?>
                                                <option value="<?= htmlspecialchars($ortu['nik_ortu']) ?>"
                                                    <?= ($ortu['nik_ortu'] == $siswanis['nik_ortu']) ? 'selected' : '' ?>>
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
                            <textarea class="form-control" id="edit_alamat" name="edit_alamat" placeholder="Masukkan Alamat"  required><?= $siswanis['alamat'] ?></textarea>
                        </div>                             
                        <div class="container-upfoto">
                            <input type="file" id="editfoto" name="edit_foto" accept="image/*" hidden>
                            <div class="img-area mb-3">
                                <img src="<?= str_replace('C:/laragon/www', '',
                                      $siswanis['foto']); ?>" alt="Foto Siswa" 
                                      style="max-width: 100%; height: 100%;">
                                <i class='bi bi-cloud-arrow-up icon'></i>
                             </div>
                            <button type="button" class="select-image">Cari Gambar</button>
                            <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($siswanis['foto']) ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            
            <script>
                $(document).ready(function() {
                $('#modalEditSiswa').modal('show');
                });
            </script>
            <?php endif?>
        </div>
            </div>
            </div>



</body>
</html>
<?php include '../template/footerAdmin.php'; ?>