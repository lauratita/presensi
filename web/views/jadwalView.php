<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/jadwalModel.php';
// use OrtuModel as Ortu;

class JadwalService{
    private $db;
    private $jadwal;

    public function __construct($db){
        $this->jadwal = new JadwalModel($db);
        
    }
    
    public function getAllJadwal(){
        $stmt = $this->jadwal->read();
        return $stmt;
    }

    public function getByIdKelas($id_kelas){
        $stmt = $this->jadwal->getByIdKelas($id_kelas);
        return $stmt;
    }

}