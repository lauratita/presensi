<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/rekapmodel.php';

class RekapController{
    private $rekapmodel;

    public function __construct()
    {
        global $koneksi;
        $this->rekapmodel = new RekapModel($koneksi);
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
    
    public function rekapGetByWaliKelas($nik_pegawai)
    {
        $rekapnik = $this->rekapmodel->rekapByWaliKelas($nik_pegawai);
        return $rekapnik;
    }



}