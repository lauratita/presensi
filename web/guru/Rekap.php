<?php
ob_start();
session_start();
include_once '../controller/rekapController.php';
include '../template/headerGuru.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/vendor/autoload.php'; 
include_once '../config/config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

if (!isset($_SESSION['nik_pegawai'])) {
    header("Location: ../login.php");
    exit();
}

$nik_pegawai = $_SESSION['nik_pegawai'];
$controller = new RekapController($koneksi);
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;
$rekapByWaliKelas = $controller->rekapGetByWaliKelas($nik_pegawai, $start_date, $end_date);

// if (isset($_GET['action']) && $_GET['action'] === 'export') {
//     $controller = new RekapController();
//     $data = json_decode($controller->read(), true);
//     exportToExcel($data);
// }

if (isset($_GET['action']) && $_GET['action'] === 'export') {
    $controller = new RekapController($koneksi);
    
    // Ambil parameter filter tanggal
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

    // Filter data berdasarkan tanggal
    $data = json_decode($controller->readFiltered($start_date, $end_date), true);
    exportToExcel($data);
}

function exportToExcel($data) {
    try {
        // Validate input data
        if (empty($data)) {
            throw new Exception("No data available for export");
        }

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Title and Date
        $sheet->setCellValue('A1', 'Laporan Rekapitulasi Presensi');
        $sheet->setCellValue('A2', 'Tanggal Cetak: ' . date('Y-m-d H:i:s'));
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
        // Headers
        $headers = ['No', 'NIS', 'Nama', 'Keterangan', 'Jam Datang', 'Jam Pulang', 'Tanggal'];
        $rowHeader = 4;
    
        // Set headers
        foreach ($headers as $col => $header) {
            $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($cell . $rowHeader, $header);
        }
    
        // Header Style
        $sheet->getStyle("A{$rowHeader}:G{$rowHeader}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00']
            ]
        ]);
    
        // Add Data Rows
        $row = $rowHeader + 1;
        $no = 1;
        foreach ($data as $record) {
            $sheet->setCellValue("A$row", $no++);
            $sheet->setCellValue("B$row", $record['nis'] ?? '');
            $sheet->setCellValue("C$row", $record['nama'] ?? '');
            $sheet->setCellValue("D$row", $record['keterangan'] ?? '');
            $sheet->setCellValue("E$row", $record['jam_datang'] ?? '');
            $sheet->setCellValue("F$row", $record['jam_pulang'] ?? '');
            $sheet->setCellValue("G$row", $record['tanggal'] ?? '');
            $row++;
        }
    
        // Adjust Column Width
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Prepare file name
        $fileName = 'Laporan_Rekap_' . date('Ymd_His') . '.xlsx';
    
        // Clear any previous output
        ob_clean();
        ob_end_clean();
    
        // Set headers for file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');
    
        // Create Excel Writer
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        
        // Save directly to output
        $writer->save('php://output');
        exit;

    } catch (Exception $e) {
        // Error handling
        header('Content-Type: text/html');
        echo "Export Error: " . $e->getMessage();
        
        // Log the error (replace with your logging method)
        error_log('Excel Export Error: ' . $e->getMessage());
        exit;
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h6 class="m-0 font-weight-bold text-primary"><span class="text-muted fw-flight">Rekap</span></h6>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header">
            <div class="row g-3 align-items-center">
                <form action="Rekap.php" method="GET" id="filterForm">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <label for="start_date" class="col-form-label">Filter Tanggal</label>
                        </div>
                        <div class="col-auto">
                            <input class="form-control" type="date" name="start_date" id="start_date"
                                value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>"
                                onchange="document.getElementById('filterForm').submit();">
                        </div>
                        <div class="col-auto">
                            <h3>-</h3>
                        </div>
                        <div class="col-auto">
                            <input class="form-control" type="date" name="end_date" id="end_date"
                                value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>"
                                onchange="document.getElementById('filterForm').submit();">
                        </div>
                    </div>
                </form>

                <div class="ml-auto mr-2 ">
                    <!-- <a href="Rekap.php?action=export" class="btn btn-success">Export Excel</a> -->
                    <a href="Rekap.php?action=export&start_date=<?= $_GET['start_date'] ?? '' ?>&end_date=<?= $_GET['end_date'] ?? '' ?>"
                        class="btn btn-success">Export Excel</a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTablerekap" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Ambil tanggal dari input filter
                        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
                        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

                        // Query default
                        $sql = "SELECT * FROM v_rekap";

                        // Tambahkan filter jika tanggal diisi
                        if (!empty($start_date) && !empty($end_date)) {
                            $sql .= " WHERE tanggal BETWEEN '$start_date' AND '$end_date'";
                        } elseif (!empty($start_date)) {
                            $sql .= " WHERE tanggal >= '$start_date'";
                        } elseif (!empty($end_date)) {
                            $sql .= " WHERE tanggal <= '$end_date'";
                        }

                        // Eksekusi query
                        $result = $koneksi->query($sql);

                        // Tampilkan hasil
                        if (!empty($rekapByWaliKelas)) {
                            $no = 1;
                            foreach ($rekapByWaliKelas as $row) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['nis'] . "</td>";
                                echo "<td>" . $row['nama'] . "</td>";
                                echo "<td>" . $row['keterangan'] . "</td>";
                                echo "<td>" . $row['jam_datang'] . "</td>";
                                echo "<td>" . $row['jam_pulang'] . "</td>";
                                echo "<td>" . $row['tanggal'] . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include '../template/footerGuru.php' ?>
<?include_once '../controller/presensicontroler.php';?>