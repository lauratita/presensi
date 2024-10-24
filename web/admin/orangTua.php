<?php 
include '../template/headerAdmin.php'; ?>
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
                    <h6 class="m-0 font-weight-bold text-secondary">Tabel Kelas</h6>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                            <tr>
                                <td>3511096406060003</td>
                                <td>Barizatul Kamilah</td>
                                <td>Perempuan</td>
                                <td>bariza@gmail.com</td>
                                <td>112233445566</td>
                                <td>Jember</td>
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
        <!-- End Data Ortu -->
         <!-- tab tambah data -->
        <div class="tab-pane fade" id="tab-tambahOrtu" role="tabpanel" aria-labelledby="nav-tambahOrtu-tab">
            <div class="card shadow mb-4 mt-4">
                <div class="card-body">
                    <form id="formTambahOrtu">
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="namaOrtu">Nama</label>
                                <input type="text" class="form-control" id="namaOrtu" placeholder="Masukkan Nama Orang Tua" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="jkOrtu">Jenis Kelamin</label>
                                <select class="form-control" id="jkOrtu" name="gender" >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="Masukkan Email">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password"  placeholder="Masukkan Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" id="nik" placeholder="Masukkan NIK">
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="nohp">No HP</label>
                                <input type="text" class="form-control" id="nohp"  placeholder="Masukkan No HP" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <label for="alamatOrtu">Alamat</label>
                                <textarea class="form-control" id="alamatOrtu" placeholder="Masukkan Alamat" ></textarea>
                            </div>
                        </div>
                        <div class="form-group text-right mt-3">
                            <button type="button" class="btn btn-secondary pe-4" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary ">Simpan</button>
                        </div>
                    </form>
                </div>    
            </div>        
        </div>
    </div>

    <!-- Tombol Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel"
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
                    <button type="button" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../template/footerAdmin.php'; ?>