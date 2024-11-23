<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/mapelmodel.php';
use MapelModel as Mapel;

class MapelService {
    private $db;
    private $mpl;

    public function __construct($db) {
        $this->mpl = new MapelModel($db);
    }

    public function createMapel($kode, $nama) {
        $this->mpl->kode = $kode;  
        $this->mpl->nama = $nama;  
    
        if ($this->mpl->create()) {
            return json_encode(["message" => "Berhasil menambah pelajaran"]);
        } else {
            return json_encode(["message" => "Gagal menambah pelajaran"]);
        }
    }
    
    public function getAllMapel(){
        $stmt = $this->mpl->read();
        return $stmt;
    }

    public function getMapelByKode($kode){
        $stmt = $this->mpl->getByKode($kode);
        return $stmt;
    }

    public function updateMapel($kode, $nama) {
        if ($this->mpl->update($kode, $nama)) {
            return json_encode(["message" => "Berhasil mengubah data"]);
        }
        return json_encode(["message" => "Gagal mengubah data"]);
    }

    public function deletedMapel($kode) {
        $this->mpl->kode = $kode;
        if ($this->mpl->delete()) {
            return json_encode(["message" => "Berhasil hapus pelajaran"]);
        }
        return json_encode(["message" => "Gagal hapus pelajaran"]);
    }
}
?>