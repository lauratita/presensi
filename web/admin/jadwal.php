<?php 
$activeMenu = 'siswa'; // Tentukan menu 'Siswa' yang aktif
$activeSubmenu = 'jadwal';
include '../template/headerAdmin.php'; 
include_once '../controller/jadwalController.php';

$controller = new JadwalController();
$data = $controller->read();
$jadwals = [];

if ($data !== false) {
    $data = json_decode($data, true);
    if (!isset($data['message']) || $data['message'] !== 'Data not found') {
        $jadwals = $data;
        // var_dump($kelass);
    }
} else {
    // Handle errors from getAllOrtu()
    echo "Error fetching data.";
}

?>

<html>
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Daftar Jadwal</h1>
        </div>
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
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Jam Masuk</th> 
                                <th>Jam Pulang</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($jadwals as $jadwal) : ?>
                            <tr>
                                <td><?= htmlspecialchars($jadwal['nama_kelas']) ?></td>
                                <td><?= htmlspecialchars($jadwal['hari']) ?></td>
                                <td><?= htmlspecialchars($jadwal['jam_masuk']) ?></td>
                                <td><?= htmlspecialchars($jadwal['jam_pulang']) ?></td> 
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
</body>
</html>
<?php include '../template/footerAdmin.php'; ?>
