<?php 
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'siswa';
include '../template/headerAdmin.php'; ?>
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
                aria-selected="false">Detail Data</button>
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
                                <th>Jenis Kelamin</th> 
                                <th>Password</th>
                                <th>Aksi</th>       
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>306261805</td>
                                <td>Ita Nurlaili</td>
                                <td>24 Juni 2006</td>
                                <td>2020</td>
                                <td>Bondowoso</td>
                                <td>Perempuan</td>
                                <td>123</td>
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
        <div class="tab-pane fade" id="tab-tambahSiswa" role="tabpanel" aria-labelledby="nav-tambahSiswa-tab">
            <div class="card shadow mb-4 mt-4">
                <div class="card-body">
                    <form id="formTambahSiswa" >
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label for="nis">NIS</label>
                                <input type="text" class="form-control" id="nis" placeholder="Masukkan NIS" required>
                            </div>
                            <div class="col-md-5 mt-3">
                                <label for="namaSiswa">Nama</label>
                                <input type="text" class="form-control" id="namaSiswa" placeholder="Masukkan Nama" required>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="kelas">Tahun Masuk</label>
                                <select class="form-control" id="tahun" name="tahun">
                                    <option value="A">2020</option>
                                    <option value="B">2021</option>
                                    <option value="C">2023</option>
                                    <!-- Add more class options if needed -->
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="jkSiswa">Jenis Kelamin</label>
                                <select class="form-control" id="jkSiswa" name="gender" >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password"  placeholder="Masukkan Password" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" placeholder="Masukkan Alamat"></textarea>
                        </div>

                        <div class="row">
                            <div class="container-upfoto">
                                <input type="file" id="file1" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto depan</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file2" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto Kiri</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file3" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto Kanan</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file4" accept="image/*" hidden>
                                <div class='img-area' data-img="">
                                    <i class='bi bi-cloud-arrow-up icon'></i>
                                    <h3>Upload Image</h3>
                                    <p>Foto Atas</p>
                                </div>
                                <button class="select-image">Cari Gambar</button>
                            </div>
                            <div class="container-upfoto">
                                <input type="file" id="file5" accept="image/*" hidden>
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
                            <button type="submit" class="btn btn-primary">Simpan</button>
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