<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/jpgwmodel.php';
use jpgwModel as JPGW;

class jpgwService{
    private $db;
    private $jpgw;

    public function __construct($db){
        $this->jpgw = new jpgwModel($db);
    }

    public function createJPGW($nama) {
        $this->jpgw->nama = $nama;
        return $this->jpgw->create();
    }

    public function getAllJPGW(){
        $stmt = $this->jpgw->read();
        return $stmt;
    }

    public function getJPGWByID($idJenis){
        $stmt = $this->jpgw->getByIdJenis($idJenis);
        return $stmt;
    }

    public function updateJPGW($id_jenis, $nama){
        return $this->jpgw->update($id_jenis, $nama);
    }

    public function deletedJPGW($idJenis) {
        $this->jpgw->idJenis = $idJenis;
        if ($this->jpgw->delete()) {
            return $this->jpgw->delete();
        }
    }
}
