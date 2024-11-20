<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/dashboardModel.php';

class DashboardView
{
    private $dashboard;

    public function __construct($db)
    {
        $this->dashboard = new DashboardModel($db);   
    }

    public function getJumlahSiswaByWaliKelas($nik_pegawai)
    {
        $stmt = $this->dashboard->getJumlahSiswa($nik_pegawai);
        return $stmt;

        if (isset($result['statistik_siswa'])) {
            return $result['statistik_siswa']; // Return jumlah siswa
        } else {
            return isset($result['message']) ? $result['message'] : 'Unknown error';
        }
    }
    public function getJumlahSuratByWaliKelas($nik_pegawai)
    {
        $stmt = $this->dashboard->getJumlahSurat($nik_pegawai);
        return $stmt;

        if (isset($result['statistik_surat'])) {
            return $result['statistik_surat']; // Return jumlah siswa
        } else {
            return isset($result['message']) ? $result['message'] : 'Unknown error';
        }
    }
    public function getJumlahSuratHariIni($nik_pegawai)
    {
        $stmt = $this->dashboard->getJumlahSuratHariIni($nik_pegawai);
        return $stmt;

        if (isset($result['statistik_surat'])) {
            return $result['statistik_surat']; // Return jumlah siswa
        } else {
            return isset($result['message']) ? $result['message'] : 'Unknown error';
        }
    }
} 