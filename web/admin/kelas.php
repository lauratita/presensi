<?php 
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'kelas';
include '../template/headerAdmin.php'; ?>
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
            <div class="card-header py-3 d-flex justify-content-between align-items-center" >
                <h6 class="m-0 font-weight-bold text-secondary">Tabel Kelas</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahKelas">
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
                            <tr>
                                <td>1</td>
                                <td>X RPL 1</td>
                                <td>Barizatul Kamilah</td>
                                <td><!-- Circle Buttons (Small) -->
                                    <a href="#" class="btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#modalEditKelas">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#modalHapus">
                                        <i class="fas fa-trash"></i>
                                    </a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Logout Modal-->
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
    
    <!-- Modal Tambah Data Kelas -->
    <div class="modal fade" id="modalTambahKelas" tabindex="-1" role="dialog" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
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
            <form id="formTambahKelas" >
              <div class="form-group">
                <label for="namaKelas">Nama Kelas</label>
                <input type="text" class="form-control" id="namaKelas" placeholder="Masukkan Nama Kelas">
              </div>
              <div class="form-group">
                <label for="waliKelas">Wali Kelas</label>
                <select class="form-control" id="walikelas" name="walikelas" >
                                    <option value="">Pilih waliKelas</option>
                                    <option value="Laki-laki">Bariza</option>
                                    <option value="Perempuan">Hendra</option>
                                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="btnSimpanKelas">Simpan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit Data Kelas -->
    <div class="modal fade" id="modalEditKelas" tabindex="-1" role="dialog" aria-labelledby="modalEditKelasLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahKelasLabel">Edit Data Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form untuk tambah data kelas -->
            <form id="formTambahKelas">
              <div class="form-group">
                <label for="namaKelas">Nama Kelas</label>
                <input type="text" class="form-control" id="namaKelas" placeholder="Masukkan Nama Kelas">
              </div>
              <div class="form-group">
                <label for="waliKelas">Wali Kelas</label>
                <select class="form-control" id="walikelas" name="walikelas" >
                                    <option value="">Pilih Wali Kelas</option>
                                    <option value="Laki-laki">Bariza</option>
                                    <option value="Perempuan">Hendra</option>
                                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="btnSimpanKelas">Perbarui</button>
          </div>
        </div>
      </div>
    </div>

</body>
</html>
<?php include '../template/footerAdmin.php'; ?>
