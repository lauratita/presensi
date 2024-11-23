<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/jpgwView.php';

class JPGWController{
    private $jpgwService;

    public function __construct(){
        global $koneksi;
        $this->jpgwService = new JPGWService($koneksi);
    }

    public function create($request){
        try {
            $nama = $request['nama'];

            if (empty($nama)) {
                return json_encode(["message" => "Nama tidak boleh kosong"]);
            }

            if ($this->jpgwService->createJPGW($nama)) {
                return json_encode(["message" => "Berhasil tambah data"]);
            }
            return json_encode(["message" => "Gagal menambah data"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function read(){
        return $this->jpgwService->getAllJPGW();
    }

    public function getByIdJenis($idJenis){
        return $this->jpgwService->getJPGWByID($idJenis);
    }

    public function update($request) {
        $id_jenis = $request['id_jenis'];
        $nama = $request['editjenisPegawai'];
    
        return $this->jpgwService->updateJPGW($id_jenis, $nama);
    }
    
    public function delete($idJenis){
        return $this->jpgwService->deletedJPGW($idJenis);
    }
}
