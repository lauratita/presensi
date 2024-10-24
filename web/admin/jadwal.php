<?php 
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'jadwal';
include '../template/headerAdmin.php'; ?>
<html>
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
    <h6 class="m-0 mt-4 mb-4 font-weight-bold text-primary"><span class="text-muted fw-flight">Jadwal</span></h6>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="nav-dataJadwal-tab" data-toggle="tab" href="#tab-dataJadwal"
                data-bs-target="#nav-dataJadwal" type="button" role="tab" aria-controls="tab-dataJadwal"
                aria-selected="true">Jadwal</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="nav-tambahJadwal-tab" data-toggle="tab" href="#tab-tambahJadwal"
                data-bs-target="#nav-tambahJadwal" type="button" role="tab" aria-controls="tab-tambahJadwal"
                aria-selected="false">Detail Jadwal</button>
        </li>
    </ul>

    <div class="tab-content" id="TabContent">
        <!-- Tab Data Ortu -->
        <div class="tab-pane fade show active" id="tab-dataJadwal" role="tabpanel" aria-labelledby="nav-dataJadwal-tab">
            <div class="card shadow mb-4 mt-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" >
                    <h6 class="m-0 font-weight-bold text-secondary">Tabel Jadwal</h6>
                    
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hari</th>
                                <th>Kelas</th> 
                                <th>Jam Masuk</th> 
                                <th>Jam Keluar</th>
                                <th>Aksi</th>       
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Senin</td>
                                <td>X RPL 1</td>
                                <td>06:00</td>
                                <td>17:00</td>
                                
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
        <div class="tab-pane fade" id="tab-tambahJadwal" role="tabpanel" aria-labelledby="nav-tambahJadwal-tab">
            <div class="card shadow mb-4 mt-4">
                <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" id="kelas" name="kelas">
                                <option value="A">X RPL 1</option>
                                <option value="B">X RPL 2</option>
                                <option value="C">X1 TKJ 1</option>
                                <!-- Add more class options if needed -->
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="hari">Hari</label>
                            <select class="form-control" id="hari" name="hari">
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="rabu">Kamis</option>
                                <option value="rabu">Jum'at</option>
                                <option value="rabu">Sabtu</option>
                                <!-- Add other days as needed -->

                            </select>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-3 mt-3">
                        <label for="jam-mulai">Jam Masuk</label>
                        <div class="time-picker-container">
                            <select id="jam-mulai-hour" name="jam-mulai-hour">
                                <!-- Options for hours 01-12 -->
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <!-- Tambah opsi jam lainnya -->
                            </select>
                            :
                            <select id="jam-mulai-minute" name="jam-mulai-minute">
                                <!-- Options for minutes 00-55 -->
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <option value="10">10</option>
                                <!-- Tambah opsi menit lainnya -->
                            </select>
                            <select id="jam-mulai-ampm" name="jam-mulai-ampm">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="jam-selesai">Jam Keluar</label>
                        <div class="time-picker-container">
                            <select id="jam-keluar-hour" name="jam-keluar-hour">
                                <!-- Options for hours 01-12 -->
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <!-- Tambah opsi jam lainnya -->
                            </select>
                            :
                            <select id="jam-keluar-minute" name="jam-keluar-minute">
                                <!-- Options for minutes 00-55 -->
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <!-- Tambah opsi menit lainnya -->
                            </select>
                            <select id="jam-keluar-ampm" name="jam-keluar-ampm">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="jam-selesai">Toleransi Masuk</label>
                        <div class="time-picker-container">
                            <select id="toleransi-masuk-hour" name="toleransi-masuk-hour">
                                <!-- Options for hours 01-12 -->
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <!-- Tambah opsi jam lainnya -->
                            </select>
                            :
                            <select id="toleransi-masuk-minute" name="toleransi-masuk-minute">
                                <!-- Options for minutes 00-55 -->
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <!-- Tambah opsi menit lainnya -->
                            </select>
                            <select id="toleransi-masuk-ampm" name="toleransi-masuk-ampm">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="jam-selesai">Toleransi Keluar</label>
                        <div class="time-picker-container">
                            <select id="toleransi-keluar-hour" name="toleransi-keluar-hour">
                                <!-- Options for hours 01-12 -->
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <!-- Tambah opsi jam lainnya -->
                            </select>
                            :
                            <select id="toleransi-keluar-minute" name="toleransi-keluar-minute">
                                <!-- Options for minutes 00-55 -->
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <!-- Tambah opsi menit lainnya -->
                            </select>
                            <select id="toleransi-keluar-ampm" name="toleransi-keluar-ampm">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="form-group text-right mt-3">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                </form>
                </div>    
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
