<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/dashboardView.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/dashboardModel.php';

class DashboardController
{
    private $dashboardView;

    public function __construct()
    {
        global $koneksi;
        $this->dashboardView = new DashboardView($koneksi);
    }

    public function getJumlahSiswa($nik_pegawai)
    {
        $jumlahSiswa = $this->dashboardView->getJumlahSiswaByWaliKelas($nik_pegawai);
        return $jumlahSiswa;
    }
    public function getJumlahSurat($nik_pegawai)
    {
        $jumlahSurat = $this->dashboardView->getJumlahSuratByWaliKelas($nik_pegawai);
        return $jumlahSurat;
    }
    public function getJumlahSuratHariIni($nik_pegawai)
    {
        $jumlahSurat = $this->dashboardView->getJumlahSuratHariIni($nik_pegawai);
        return $jumlahSurat;
    }
}