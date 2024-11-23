

<?php 
$activeMenu = 'pegawai'; 
$activeSubmenu = 'jenis pegawai';
include '../template/headerAdmin.php'; 

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_presensicekinout";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data jenis pegawai
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambahJenisPegawai'])) {
    $jenisPegawai = $_POST['jenisPegawai'];
    $sqlTambahJenis = "INSERT INTO tb_jenis_pegawai (nama) VALUES ('$jenisPegawai')";
    if ($conn->query($sqlTambahJenis) === TRUE) {
        echo "<div class='alert alert-success'>Jenis Pegawai berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sqlTambahJenis . "<br>" . $conn->error . "</div>";
    }
}

// Edit data jenis pegawai
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editJenisPegawai'])) {
    $idJenis = $_POST['id_jenis'];
    $jenisPegawai = $_POST['jenisPegawai'];
    $sqlEditJenis = "UPDATE tb_jenis_pegawai SET nama='$jenisPegawai' WHERE id_jenis='$idJenis'";
    if ($conn->query($sqlEditJenis) === TRUE) {
        echo "<div class='alert alert-success'>Jenis Pegawai berhasil diupdate!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sqlEditJenis . "<br>" . $conn->error . "</div>";
    }
}

// Hapus data jenis pegawai
if (isset($_GET['hapus_id'])) {
    $idJenis = $_GET['hapus_id'];
    $sqlHapusJenis = "DELETE FROM tb_jenis_pegawai WHERE id_jenis='$idJenis'";
    if ($conn->query($sqlHapusJenis) === TRUE) {
        echo "<div class='alert alert-success'>Jenis Pegawai berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sqlHapusJenis . "<br>" . $conn->error . "</div>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Jenis Pegawai</h1>
        </div>

        <!-- Tab Menu -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="nav-jenisPegawai-tab" data-toggle="tab" href="#tab-jenisPegawai" type="button" role="tab" aria-controls="tab-jenisPegawai" aria-selected="true">Jenis Pegawai</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="nav-daftarJenisPegawai-tab" data-toggle="tab" href="#tab-daftarJenisPegawai" type="button" role="tab" aria-controls="tab-daftarJenisPegawai" aria-selected="false">Daftar Jenis Pegawai</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Tab Jenis Pegawai -->
            <div class="tab-pane fade show active" id="tab-jenisPegawai" role="tabpanel" aria-labelledby="nav-jenisPegawai-tab">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Jenis Pegawai</h6>
                    </div>
                    <div class="card-body">
                        <!-- Form Jenis Pegawai -->
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="jenisPegawai">Jenis Pegawai</label>
                                <input type="text" class="form-control" id="jenisPegawai" name="jenisPegawai" placeholder="Masukkan Jenis Pegawai" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="tambahJenisPegawai">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Daftar Jenis Pegawai -->
            <div class="tab-pane fade" id="tab-daftarJenisPegawai" role="tabpanel" aria-labelledby="nav-daftarJenisPegawai-tab">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Jenis Pegawai</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Tabel Daftar Jenis Pegawai -->
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID Jenis</th>
                                        <th>Jenis Pegawai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Query untuk menampilkan daftar jenis pegawai
                                    $sql = "SELECT * FROM tb_jenis_pegawai";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['id_jenis'] . "</td>";
                                            echo "<td>" . $row['nama'] . "</td>";
                                            echo "<td>
                                            <a href='#' class='btn btn-warning btn-circle btn-sm' data-toggle='modal' data-target='#modalEditJenis' data-id='{$row['id_jenis']}' data-nama='{$row['nama']}'>
                                                <i class='fas fa-pencil-alt'></i>
                                            </a>
                                            <a href='?hapus_id={$row['id_jenis']}' class='btn btn-danger btn-circle btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                                <i class='fas fa-trash'></i>
                                            </a>
                                          </td>";                                    
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='text-center'>Belum ada data jenis pegawai</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Jenis Pegawai -->
        <div class="modal fade" id="modalEditJenis" tabindex="-1" role="dialog" aria-labelledby="modalEditJenisLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditJenisLabel">Edit Jenis Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Edit Jenis Pegawai -->
                        <form method="POST" action="">
                            <input type="hidden" id="edit_id_jenis" name="id_jenis">
                            <div class="form-group">
                                <label for="edit_jenisPegawai">Jenis Pegawai</label>
                                <input type="text" class="form-control" id="edit_jenisPegawai" name="jenisPegawai" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="editJenisPegawai">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
include '../template/footerAdmin.php'; 
?>
