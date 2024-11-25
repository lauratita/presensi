<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/pgwView.php';

class PegawaiController{
    private $pegawaiService;
    public function __construct(){
        global $koneksi;
        $this->pegawaiService = new PegawaiService($koneksi);
    }

    public function create($request){
        try {
            $nik = $request['nik'];
            $nama = $request['nama'];
            $alamat = $request['alamat'];
            $jenis_kelamin = $request['jenis_kelamin'];
            $password = $request['password'];
            $no_hp = $request['no_hp'];
            $email = $request['email'];
            $idJenis = $request['idJenis'];
            if ($this->pegawaiService->createPegawai($nik, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $idJenis)) {
                return json_encode(["message" => "Berhasil tambah data"]);
            }
            return json_encode(["message" => "Gagal menambah data"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function read(){
        $pgws = $this->pegawaiService->getAllPegawai();
        return $pgws;
    }

    public function update($request){
        $nik = $request['nik'];
        $nama = $request['nama'];
        $alamat = $request['alamat'];
        $jenis_kelamin = $request['jenis_kelamin'];
        $password = $request['password'];
        $no_hp = $request['no_hp'];
        $email = $request['email'];
        $idJenis = $request['idJenis'];
        $data = $this->pegawaiService->updatePegawai($nik, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $idJenis);
        if ($data) {
            return json_encode(["message" => "Berhasil Perbarui Data Pegawai"]);
        }else{
            return json_encode(["message" => "Gagal Perbarui Data Pegawai"]);
        }
    }

    public function delete($nik){
        if ($this->ortuService->deletedPegawai($nik)) {
            return json_encode(["message" => "Berhasil Hapus Data Pegawai"]);
        }
        return json_encode(["message" => "Gagal Data Pegawai"]);
    }
}