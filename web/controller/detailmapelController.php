<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/detailmapelView.php';

class detailMapelController{
    private $detailMapelService;
    public function __construct(){
        global $koneksi;
        $this->detailMapelService = new DetailMapelService($koneksi);
    }


    public function getByIDKelas($id_kelas){
        $mapelkelas = $this->detailMapelService->getByIdKelas($id_kelas);
        return $mapelkelas;
    }
    
}