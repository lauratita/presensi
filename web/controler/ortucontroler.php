<?php
include_once '../config/config.php';
include_once '../service/ortuservice.php';

class OrtuControler{
    private $ortuService;

    public function __construct($con){
        $this->ortuService = new OrtuService($con);
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
            return json_encode(["message" => "Berhasil tambah data"]);
        }
        return json_encode(["message" => "Gagal menambah data"]);
    }

    public function read(){
        $ortus = $this->ortuService->getAllOrtu();
        return json_encode($ortus);
    }

    public function getByNik($nik){
        $ortugetnik = $this->ortuService->getOrtuByNik($nik);
        // return json_encode($ortugetnik);
        if (!$ortugetnik) {
            // Jika data tidak ditemukan, tampilkan pesan di sini untuk debugging
            var_dump("Data tidak ditemukan untuk NIK:", $nik);
        }
        return $ortugetnik;
    }

    public function update($request){
        $nik = $request['nik'];
        $nama = $request['nama'];
        $email = $request['email'];
        $password = $request['password'];
        $no_hp = $request['no_hp'];
        $alamat = $request['alamat'];
        $jenis_kelamin = $request['jenis_kelamin'];
        if ($this->ortuService->updateOrtu($nik, $nama, $email, $password, $no_hp, $alamat, $jenis_kelamin)) {
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