<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/rekapmodel.php';

class RekapController{

    private $rekapmodel; // Model untuk rekapitulasi data
    private $koneksi; 
    
        // Konstruktor untuk menginisialisasi koneksi dan model
    public function __construct() {
        global $koneksi;
        $this->koneksi = $koneksi;
        $this->rekapmodel = new RekapModel($koneksi); // Inisialisasi model dengan koneksi
    }
    
        // Fungsi untuk membaca data rekap
    public function read() {
        $rekaps = $this->rekapmodel->readvrekap(); // Ambil data rekap dari model
        return json_encode($rekaps); // Kembalikan dalam format JSON
    }
    

    public function rekapGetByWaliKelas($nik_pegawai, $start_date = null, $end_date = null)
    {
        $sql = "SELECT * FROM v_rekap WHERE nik_pegawai = ?";
        $params = [$nik_pegawai];
        $types = "s";

        if (!empty($start_date) && !empty($end_date)) {
            $sql .= " AND tanggal BETWEEN ? AND ?";
            $params[] = $start_date;
            $params[] = $end_date;
            $types .= "ss";
        } elseif (!empty($start_date)) {
            $sql .= " AND tanggal >= ?";
            $params[] = $start_date;
            $types .= "s";
        } elseif (!empty($end_date)) {
            $sql .= " AND tanggal <= ?";
            $params[] = $end_date;
            $types .= "s";
        }

        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }


}