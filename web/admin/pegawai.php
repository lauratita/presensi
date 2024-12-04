<?php 
ob_start();
$activeMenu = 'pegawai'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'pegawai';
include '../template/headerAdmin.php';
include_once '../controller/pgwcontroller.php';
$showEditModal= false;
$controller = new PegawaiController();
$data = $controller->read();
$pgws = [];

$jpegawai = $controller->getjpegawai(); 
$datajpgw = json_decode($jpegawai, true);

if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $pgws = $data;
    }
} else {
    echo "Error fetching data.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action']) && $_GET['action'] === 'update') {
        // Validasi NIK pada edit
        if (isset($_POST['nik_pegawai']) && strlen($_POST['nik_pegawai']) < 10) {
            echo "<script>alert('NIK harus minimal 10 digit!');</script>";
        } else {
            $result = $controller->update($_POST);
            if ($result) {
                $_SESSION['message'] = "Data pegawai berhasil diperbaharui!";
                $_SESSION['type'] = "success";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    } else {
        // Validasi NIK pada create
        if (isset($_POST['nik_pegawai']) && strlen($_POST['nik_pegawai']) < 10) {
            echo "<script>alert('NIK harus minimal 10 digit!');</script>";
        } else {
            // Cek duplikasi NIK
            $isDuplicateNIK = false;
            foreach ($pgws as $pgw) {
                if ($pgw['nik_pegawai'] === $_POST['nik_pegawai']) {
                    $isDuplicateNIK = true;
                    break;
                }
            }

            // Cek duplikasi No HP
            $isDuplicateNoHP = false;
            foreach ($pgws as $pgw) {
                if ($pgw['no_hp'] === $_POST['no_hp']) {
                    $isDuplicateNoHP = true;
                    break;
                }
            }

            // Cek duplikasi Email
            $isDuplicateEmail = false;
            foreach ($pgws as $pgw) {
                if ($pgw['email'] === $_POST['email']) {
                    $isDuplicateEmail = true;
                    break;
                }
            }

            // Tampilkan pesan error jika ada duplikasi
            if ($isDuplicateNIK || $isDuplicateNoHP || $isDuplicateEmail) {
                $errorMessages = [];
                if ($isDuplicateNIK) {
                    $errorMessages[] = "NIK sudah terdaftar!";
                }
                if ($isDuplicateNoHP) {
                    $errorMessages[] = "Nomor Handphone sudah digunakan!";
                }
                if ($isDuplicateEmail) {
                    $errorMessages[] = "Email sudah terdaftar!";
                }
                
                $_SESSION['message'] = implode(" ", $errorMessages);
                $_SESSION['type'] = "error";
                
                // Redirect untuk mencegah submit ulang
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            $result = $controller->create($_POST);
            if ($result) {
                $_SESSION['message'] = "Data pegawai berhasil ditambahkan!";
                $_SESSION['type'] = "success";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $nik_pegawai = $_GET['nik'];
    $result = $controller->delete($nik_pegawai);
    if ($result) {
        $_SESSION['message'] = "Data pegawai berhasil dihapus!";
        $_SESSION['type'] = "success";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$pgwnik = [];

if (isset($_GET['nik'])) {
    $nik_pegawai = $_GET['nik'];
    $data = $controller->getByNik($nik_pegawai); 

    if ($data !== false) {
        $data = json_decode($data, true);
        
        if (is_array($data) && (!isset($data['message']) || $data['message'] !== 'Data not found')) {
            $pgwnik = $data[0];
            $showEditModal= true;
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
                                <th>Jenis Pegawai</th>
                                <th>Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($pgws as $pgw) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pgw['nik_pegawai']) ?></td>
                                        <td><?= htmlspecialchars($pgw['nama_pegawai']) ?></td>
                                        <td><?= htmlspecialchars($pgw['jenis_pegawai']) ?></td>
                                        <td>
                                        <!-- <a href="#" class="btn btn-info btn-circle btn-sm"
                                            data-toggle="modal" data-target="#modalRead"
                                            data-nik="<?= htmlspecialchars($pgw['nik_pegawai']) ?>"
                                            data-nama="<?= htmlspecialchars($pgw['nama_pegawai']) ?>"
                                            data-alamat="<?= htmlspecialchars($pgw['alamat']) ?>"
                                            data-jenis-kelamin="<?= htmlspecialchars($pgw['jenis_kelamin']) ?>"
                                            data-no-hp="<?= htmlspecialchars($pgw['no_hp']) ?>"
                                            data-email="<?= htmlspecialchars($pgw['email']) ?>"
                                            data-id-jenis="<?= htmlspecialchars($pgw['jenis_pegawai']) ?>">
                                                <i class="fas fa-eye"></i>
                                            </a> -->
                                            <a href="?nik=<?= htmlspecialchars($pgw['nik_pegawai']) ?>"
                                               class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-circle btn-sm"

                                        data-toggle="modal" data-target="#modalHapusPegawai"
                                        data-nik="<?= htmlspecialchars($pgw['nik_pegawai']) ?>">
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

                <div class="modal-body">
                    <form id="formTambahPegawai" method="POST" action="?action=create">
                        <div class="form-group">
                            <label for="nikp">NIK</label>
                            <input type="text" class="form-control" id="nikp" name="nik_pegawai" 
                            placeholder="Masukkan NIK" 
                            pattern="\d{10,}" 
                            title="NIK harus minimal 10 digit angka" 
                            required>
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
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Handphone</label>
                            <input type="text" class="form-control" name="no_hp" placeholder="Masukkan No Handphone"
                                pattern="62\d{10,13}" title="No Handphone harus terdiri dari 10 hingga 13 digit angka dan berawal 62" 
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                        </div>
                        <div class="form-group">
                            <label for="id_jenis">Jenis Pegawai</label>
                            <select class="form-control" id="id_jenis" name="id_jenis">
                                <option value="">Pilih Jenis Pegawai</option>
                                <?php if (!empty($datajpgw)): ?>
                                    <?php foreach ($datajpgw as $jpegawai): ?>
                                    <option value="<?= htmlspecialchars($jpegawai['id_jenis']) ?>">
                                        <?= htmlspecialchars($jpegawai['nama']) ?>
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
</body>

<script>
    document.getElementById('nikp').addEventListener('input', function() {
        const nikInput = this.value;
        const passwordField = document.getElementById('password');
        passwordField.value = nikInput; // Set nilai password dengan NIK yang diinput
    });
</script>

<!-- Modal Lihat Data Pegawai
<div class="modal fade" id="modalRead" tabindex="-1" role="dialog" aria-labelledby="modalReadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReadLabel">Detail Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>NIK:</strong> <span id="detailNIK"></span></p>
                <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                <p><strong>Alamat:</strong> <span id="detailAlamat"></span></p>
                <p><strong>Jenis Kelamin:</strong> <span id="detailJenisKelamin"></span></p>
                <p><strong>Password:</strong> <span id="detailPassword"></span></p>
                <p><strong>No HP:</strong> <span id="detailNoHP"></span></p>
                <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                <p><strong>Jenis Pegawai:</strong> <span id="detailJenisPegawai"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> -->

    <!-- Logout Modal-->
    <div class="modal fade" id="modalHapusPegawai" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
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
                    <a href="#" id="btnHapusPegawai" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal Edit Data Pegawai -->
        <?php if ($showEditModal && !empty($pgwnik)): ?>
        <div class="modal fade" id="modalEditPegawai" tabindex="-1" role="dialog" aria-labelledby="modalEditPegawaiLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPegawaiLabel">Edit Data Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form untuk  edit pegawai -->
                        <form id="formEditPegawai" method="POST" action="?action=update">
                            <div class="form-group">
                                <label for="nikp">NIK</label>
                                <input type="text" class="form-control" id="editnikp" name="editnikp" 
                                value="<?= htmlspecialchars($pgwnik['nik_pegawai']) ?>" 
                                placeholder="Masukkan NIK" 
                                pattern="\d{10,}" 
                                title="NIK harus minimal 10 digit angka" 
                                readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="editnama" name="editnama"
                                value="<?=$pgwnik['nama']?>" placeholder="Masukkan Nama">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="editalamat" name="editalamat"
                                value="<?=$pgwnik['alamat']?>" placeholder="Masukkan Alamat">
                            </div>
                            <div class="form-group">
                            <label for="jKelamin">Jenis Kelamin</label>
                            <select class="form-control" id="editjk" name="editjk">
                                <option value="Laki-laki" <?= $pgwnik['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $pgwnik['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select> 
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="editpw" name="editpw" 
                                    value="<?=$pgwnik['password']?>" placeholder="Masukkan Password" readonly>
                            </div>
                            <div class="form-group">
                                <label for="noHp">No Handphone</label>
                                <input type="text" class="form-control" id="editnohp" name="editnohp"
                                    value="<?=$pgwnik['no_hp']?>" placeholder="Masukkan No Handphone"
                                    pattern="62\d{10,13}" title="No Handphone harus terdiri dari 10 hingga 13 digit angka dan berawal 62">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="editemail" name="editemail"
                                    value="<?=$pgwnik['email']?>" placeholder="Masukkan Email" required>
                            </div>
                            <div class="form-group">
                                <label for="jenisPegawai">Jenis Pegawai</label>
                                <select class="form-control" id="editjpgw" name="editjpgw">
                                    <option value="">Pilih Jenis Pegawai</option>
                                        <?php if (!empty($datajpgw)): ?>
                                            <?php foreach ($datajpgw as $jpegawai): ?>
                                                <option value="<?= htmlspecialchars($jpegawai['id_jenis']) ?>"
                                                <?= ($jpegawai['id_jenis'] == $pgwnik['id_jenis']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($jpegawai['nama']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data tidak tersedia</option>
                                        <?php endif; ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" name="update" class="btn btn-primary" >Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <script>
                $(document).ready(function() {
                $('#modalEditPegawai').modal('show');
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
