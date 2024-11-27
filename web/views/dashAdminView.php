<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/dashAdminModel.php';

class DashboardAdminView
{
    private $dashAdmin;

    public function __construct($db)
    {
        $this->dashAdmin = new DashboardAdminModel($db);   
    }

    public function getJumlahSiswaByAdmin()
    {
        $stmt = $this->dashAdmin->getJumlahSiswa();
        return $stmt;

        if (isset($result['total_siswa'])) {
            return $result['total_siswa']; // Return jumlah siswa
        } else {
            return isset($result['message']) ? $result['message'] : 'Unknown error';
        }
    }
    
    public function getJumlahKelasByAdmin()
    {
        $stmt = $this->dashAdmin->getJumlahKelas();
        return $stmt;

        if (isset($result['total_kelas'])) {
            return $result['total_kelas']; // Return jumlah siswa
        } else {
            return isset($result['message']) ? $result['message'] : 'Unknown error';
        }
    }
    
    public function getJumlahPegawaiByAdmin()
    {
        $stmt = $this->dashAdmin->getJumlahPegawai();
        return $stmt;

        if (isset($result['total_pegawai'])) {
            return $result['total_pegawai']; // Return jumlah siswa
        } else {
            return isset($result['message']) ? $result['message'] : 'Unknown error';
        }
    }
    
    public function getJumlahPresensiHariIni()
    {
        $stmt = $this->dashAdmin->getJumlahPresensiHariIni();
        return $stmt;

        if (isset($result['total_siswa'])) {
            return $result['total_siswa']; // Return jumlah siswa
        } else {
            return isset($result['message']) ? $result['message'] : 'Unknown error';
        }
    }
} 