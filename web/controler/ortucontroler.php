<?php
include_once '../config/config.php';
include_once '../admin/service/ortuservice.php';

class OrtuControler{
    private $ortuService;
    public function __construct(){
        global $koneksi;
        $this->ortuService = new OrtuService($koneksi);
    }

    public function create($request){
        $nik = $request['nik'];
        $nama = $request['nama'];
        $email = $request['email'];
        $password = $request['password'];
        $no_hp = $request['no_hp'];
        $alamat = $request['alamat'];
        $jenis_kelamin = $request['jenis_kelamin'];
        if ($this->ortuService->createOrtu($nik, $nama, $email, $password, $no_hp, $alamat, $jenis_kelamin)) {
            return true;
        }
        return false;
    }

    public function read(){
        $ortus = $this->ortuService->getAllOrtu();
        return json_encode($ortus);
    }

    public function getByNik($request){
        $ortunik = $this->ortuService->getOrtuByNik();
        return json_encode($ortunik);
    }

    public function update($request){
        $nik = $request['nik'];
        $nama = $request['nama'];
        $email = $request['email'];
        $password = $request['password'];
        $no_hp = $request['no_hp'];
        $alamat = $request['alamat'];
        $jenis_kelamin = $request['jenis_kelamin'];
        if ($this->ortuService->updateOrtu($nik, $nama, $email, $password, $alamat, $jenis_kelamin)) {
            return json_encode(["message" => "Berhasil Perbarui Ortu"]);
        }
        return json_encode(["message" => "Gagal Memeperbarui Ortu"]);
    }

    public function delete($request){
        $nik = $request['nik'];
        if ($this->ortuService->deletedOrtu($nik)) {
            return json_encode(["message" => "Berhasil Hapus Ortu"]);
        }
        return json_encode(["message" => "Gagal hapus Ortu"]);
    }
}