<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/mapelView.php';

class MapelController{
    private $MapelService;

    public function __construct(){
        global $koneksi;
        $this->MapelService = new mapelService($koneksi);
    }

    public function create($request){
        try {
            $kode = $request['kd_mapel'];  
            $nama = $request['nama'];     
    
            if (empty($kode) || empty($nama)) {
                return json_encode(["message" => "Kode atau Nama tidak boleh kosong"]);
            }
    
            return $this->MapelService->createMapel($kode, $nama);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }
    
    public function read(){
        return $this->MapelService->getAllMapel();
    }

    public function getByKode($kode){
        return $this->MapelService->getMapelByKode($kode);
    }

    public function update($request) {
        try {
            $kd_mapel = $request['kd_mapel'];  
            $nama = $request['nama'];     
    
            if (empty($kd_mapel) || empty($nama)) {
                return json_encode(["message" => "Kode atau Nama tidak boleh kosong"]);
            }
    
            return $this->MapelService->updateMapel($kd_mapel, $nama);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }
    
    public function delete($kode){
        return $this->MapelService->deletedMapel($kode);
    }
}