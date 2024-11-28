<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/dashAdminView.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/dashAdminModel.php';

class DashboardAdminController
{
    private $dashAdminView;

    public function __construct()
    {
        global $koneksi;
        $this->dashAdminView = new DashboardAdminView($koneksi);
    }

    public function getJumlahSiswa()
    {
        $jumlahSiswa = $this->dashAdminView->getJumlahSiswaByAdmin();
        return $jumlahSiswa;
    }
    public function getJumlahKelas()
    {
        $jumlahKelas = $this->dashAdminView->getJumlahKelasByAdmin();
        return $jumlahKelas;
    }
    public function getJumlahPegawai()
    {
        $jumlahPegawai = $this->dashAdminView->getJumlahPegawaiByAdmin();
        return $jumlahPegawai;
    }
    public function getJumlahPresensiHariIni()
    {
        $jumlahPresensi = $this->dashAdminView->getJumlahPresensiHariIni();
        return $jumlahPresensi;
    }
}