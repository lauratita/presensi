<?php 
ob_start(); 
include '../template/headerAdmin.php'; // Pastikan ini hanya untuk header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jadwal Mata Pelajaran</title>
</head>
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Jadwal Mata Pelajaran</h1>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-secondary">Tabel Mata Pelajaran</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahMapel">
                    <i class="fas fa-plus"></i> Tambah Jadwal
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran 1</th>
                                <th>Mata Pelajaran 2</th>
                                <th>Mata Pelajaran 3</th>
                                <th>Guru</th>
                                <th>Jam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dmpls)) : ?>
                                <?php foreach ($dmpls as $dmpl) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($dmpl['id_jadwal_mapel']) ?></td>
                                        <td><?= htmlspecialchars($dmpl['hari']) ?></td>
                                        <td><?= htmlspecialchars($dmpl['id_kelas']) ?></td>
                                        <td><?= htmlspecialchars($dmpl['kd_mapel']) ?></td>
                                        <td><?= htmlspecialchars($dmpl['nik_pegawai']) ?></td>
                                        <td><?= htmlspecialchars($dmpl['jam']) ?></td>
                                        <td>
                                            <a href="" class="btn btn-info btn-circle btn-sm"
                                                data-toggle="modal" data-target="#modalRead"
                                                data-nik="<?= htmlspecialchars($dmpl['id_jadwal_mapel']) ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="pegawai.php?nik=<?= htmlspecialchars($dmpl['id_jadwal_mapel']) ?>"
                                                data-toggle="modal" data-target="#modalEdit"
                                                class="btn btn-warning btn-circle btn-sm ">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-circle btn-sm"
                                                data-toggle="modal" data-target="#modalHapus"
                                                data-nik="<?= htmlspecialchars($dmpl['id_jadwal_mapel']) ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>         
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jadwal Mapel -->
    <div class="modal fade" id="modalTambahJadwal" tabindex="-1" role="dialog" aria-labelledby="modalTambahJadwal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahJadwal">Tambah Jadwal Mata Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="?action=create">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <input type="text" class="form-control" name="hari" placeholder="Masukkan Hari" required>
                        </div>
                        <div class="form-group">
                            <label for="idKelas">ID Kelas</label>
                            <input type="text" class="form-control" name="idKelas" placeholder="Pilih ID Kelas" required>
                        </div>
                        <div class="form-group">
                            <label for="kodeMapel">Kode Mata Pelajaran</label>
                            <input type="text" class="form-control" name="kodeMapel" placeholder="Pilih Kode Mata Pelajaran" required>
                        </div>
                        <div class="form-group">
                            <label for="nikp">NIK Pegawai</label>
                            <input type="text" class="form-control" name="nikp" placeholder="Masukkan NIK Pegawai" required>
                        </div>
                        <div class="form-group">
                            <label for="jam">Jam</label>
                            <input type="email" class="form-control" name="jam" placeholder="Masukkan Jam" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<?php include '../template/footerAdmin.php'; ?>
</html>