<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/detailmapelModel.php';


class DetailMapelService{
    private $db;
    private $mapel;


    public function __construct($db){
        $this->mapel = new DetailMapelModel($db);
        
    }

    public function getByIdKelas($id_kelas){
        $stmt = $this->mapel->getByIdKelas($id_kelas);
        return $stmt;
    }

}