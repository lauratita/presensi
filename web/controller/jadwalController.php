<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/jadwalView.php';

class JadwalController{
    private $jadwalService;
    public function __construct(){
        global $koneksi;
        $this->jadwalService = new JadwalService($koneksi);
    }

    public function read(){
        $jadwals = $this->jadwalService->getAllJadwal();
        return $jadwals;
    }

    public function getByIDKelas($id_kelas){
        $mapelkelas = $this->jadwalService->getByIdKelas($id_kelas);
        return $mapelkelas;
    }

}