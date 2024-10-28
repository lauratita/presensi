
<?php 
$activeMenu = 'pegawai'; // Menentukan menu 'Pegawai' yang aktif
$activeSubmenu = 'pegawai';
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
?>


<!DOCTYPE html>
<html lang="en">
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Daftar Pegawai</h1>
        </div>

        <!-- DataTales Example -->
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
                                <th>Jenis Kelamin</th>
                                <th>Jenis Pegawai</th>
                                <th>Aksi</th>         
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query untuk mengambil data pegawai dari tabel tb_pegawai
                            $query = "SELECT tb_pegawai.nik, tb_pegawai.nama, tb_pegawai.password, tb_pegawai.jenis_kelamin 
                                      FROM tb_pegawai 
                                      INNER JOIN tb_jenis_pegawai ON tb_pegawai.id_jenis = tb_jenis_pegawai.id_jenis";
                            $result = mysqli_query($conn, $query);
                            
                            // Loop untuk menampilkan data ke dalam tabel
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$row['nik']}</td>";
                                echo "<td>{$row['nama']}</td>";
                                echo "<td>{$row['jenis_kelamin']}</td>";
                                echo "<td>{$row['jenis_nama']}</td>";
                                echo "<td>
                                        <a href='#' class='btn btn-info btn-circle btn-sm'>
                                            <i class='fas fa-eye'></i>
                                        </a>
                                        <a href='#' class='btn btn-warning btn-circle btn-sm' data-toggle='modal' data-target='#modalEditPegawai' data-nik='{$row['nik']}'>
                                            <i class='fas fa-pencil-alt'></i>
                                        </a>
                                        <a href='#' class='btn btn-danger btn-circle btn-sm' data-toggle='modal' data-target='#modalHapus' data-nik='{$row['nik']}'>
                                            <i class='fas fa-trash'></i>
                                        </a>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
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
            <!-- Form untuk tambah data pegawai -->
            <form id="formTambahPegawai" method="POST" action="tambah_pegawai.php">
              <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" maxlength="16" placeholder="Masukkan NIK (16 karakter)">
              </div>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" maxlength="100" placeholder="Masukkan Nama Pegawai">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" maxlength="100" placeholder="Masukkan Password">
              </div>
              <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="id_jenis">Jenis Pegawai</label>
                <select class="form-control" id="id_jenis" name="id_jenis">
                  <?php
                  // Query untuk mengambil jenis pegawai dari tabel tb_jenis_pegawai
                  $jenis_query = "SELECT * FROM tb_jenis_pegawai";
                  $jenis_result = mysqli_query($conn, $jenis_query);
                  while($jenis = mysqli_fetch_assoc($jenis_result)) {
                      echo "<option value='{$jenis['id_jenis']}'>{$jenis['jenis_nama']}</option>";
                  }
                  ?>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" form="formTambahPegawai">Simpan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit Data Pegawai -->
    <div class="modal fade" id="modalEditPegawai" tabindex="-1" role="dialog" aria-labelledby="modalEditPegawaiLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditPegawaiLabel">Edit Data Pegawai</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form untuk edit data pegawai -->
            <form id="formEditPegawai" method="POST" action="edit_pegawai.php">
              <input type="hidden" id="edit_nik" name="nik">
              <div class="form-group">
                <label for="edit_nama">Nama</label>
                <input type="text" class="form-control" id="edit_nama" name="nama" maxlength="100" placeholder="Masukkan Nama Pegawai">
              </div>
              <div class="form-group">
                <label for="edit_password">Password</label>
                <input type="password" class="form-control" id="edit_password" name="password" maxlength="100" placeholder="Masukkan Password">
              </div>
              <div class="form-group">
                <label for="edit_jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin">
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="edit_id_jenis">Jenis Pegawai</label>
                <select class="form-control" id="edit_id_jenis" name="id_jenis">
                  <?php
                  // Query untuk mengambil jenis pegawai dari tabel tb_jenis_pegawai
                  $jenis_query = "SELECT * FROM tb_jenis_pegawai";
                  $jenis_result = mysqli_query($conn, $jenis_query);
                  while($jenis = mysqli_fetch_assoc($jenis_result)) {
                      echo "<option value='{$jenis['id_jenis']}'>{$jenis['jenis_nama']}</option>";
                  }
                  ?>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary" form="formEditPegawai">Perbarui</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Hapus Pegawai -->
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
            Apakah Anda yakin ingin menghapus pegawai ini?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <a href="#" class="btn btn-danger">Hapus</a>
          </div>
        </div>
      </div>
    </div>

</body>
</html>

<?php include '../template/footerAdmin.php'; ?>
