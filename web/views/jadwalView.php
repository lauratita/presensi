<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/jadwalModel.php';
// use OrtuModel as Ortu;

class JadwalService{
    private $db;
    private $jadwal;
    // private $pegawai;

    public function __construct($db){
        $this->jadwal = new JadwalModel($db);
        // $this->pegawai = new KelasModel($db);
    }
    
    public function getAllJadwal(){
        $stmt = $this->jadwal->read();
        return $stmt;
    }

}