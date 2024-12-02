<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/rekapmodel.php';

class RekapController{
    private $rekapmodel;
    private $koneksi;

    public function __construct($db)
    {
        global $koneksi;
        $this->rekapmodel = new RekapModel($koneksi);
        $this->koneksi = $db;
    }
    //menampilkan data rekap
    public function read(){
        $rekaps = $this->rekapmodel->readvrekap();
        return json_encode($rekaps);
    }
    
    public function readFiltered($start_date, $end_date) {
        $query = "SELECT * FROM v_rekap";
        
        if (!empty($start_date) && !empty($end_date)) {
            $query .= " WHERE tanggal BETWEEN ? AND ?";
            $params = [$start_date, $end_date];
        } elseif (!empty($start_date)) {
            $query .= " WHERE tanggal >= ?";
            $params = [$start_date];
        } elseif (!empty($end_date)) {
            $query .= " WHERE tanggal <= ?";
            $params = [$end_date];
        } else {
            $params = [];
        }
    
        // Jalankan query dengan parameter
        return $this->runQuery($query, $params);
    }
    
    // public function rekapGetByWaliKelas($nik_pegawai)
    // {
    //     $rekapnik = $this->rekapmodel->rekapByWaliKelas($nik_pegawai);
    //     return $rekapnik;
    // }

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