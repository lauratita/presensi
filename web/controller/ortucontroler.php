<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/ortuView.php';

class OrtuControler{
    private $ortuService;
    public function __construct(){
        global $koneksi;
        $this->ortuService = new OrtuService($koneksi);
    }

    public function create($request){
        try {
            $nik = $request['nik'];
            $nama = $request['nama'];
            $alamat = $request['alamat'];
            $no_hp = $request['no_hp'];
            $jenis_kelamin = $request['jenis_kelamin'];
            $email = $request['email'];
            $password = $request['nik'];
            if ($this->ortuService->createOrtu($nik, $nama, $alamat, $no_hp, $jenis_kelamin, $email, $password)) {
                return json_encode(["message" => "Berhasil tambah data"]);
            }
            return json_encode(["message" => "Gagal menambah data"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function read(){
        $ortus = $this->ortuService->getAllOrtu();
        return $ortus;
    }

    public function getByNik($nik){
        $ortunik = $this->ortuService->getOrtuByNik($nik);
        return $ortunik;
    }

    public function update($request){
        $nik = $request['editnik'];
        $nama = $request['editnama'];
        $alamat = $request['editalamat'];
        $no_hp = $request['editno_hp'];
        $jenis_kelamin = $request['editjenis_kelamin'];
        $email = $request['editemail'];
        $password = $request['editpassword'];
        $data = $this->ortuService->updateOrtu($nik, $nama, $alamat, $no_hp, $jenis_kelamin, $email, $password);
        if ($data) {
            return json_encode(["message" => "Berhasil Perbarui Ortu"]);
        }else{
            return json_encode(["message" => "Gagal Memeperbarui Ortu"]);
        }
    }

    public function delete($nik){
        if ($this->ortuService->deletedOrtu($nik)) {
            return json_encode(["message" => "Berhasil Hapus Ortu"]);
        }
        return json_encode(["message" => "Gagal hapus Ortu"]);
    }
}