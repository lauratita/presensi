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
            $nik_pegawai = $request['nik_pegawai'];
            $nama = $request['nama'];
            $alamat = $request['alamat'];
            $jenis_kelamin = $request['jenis_kelamin'];
            $password = $request['password'];
            $no_hp = $request['no_hp'];
            $email = $request['email'];
            $id_jenis = $request['id_jenis'];
            if ($this->pegawaiService->createPegawai($nik_pegawai, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $id_jenis)) {
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

    public function getByNik($nik_pegawai){
        $pgwnik = $this->pegawaiService->getPegawaiByNik($nik_pegawai);
        return $pgwnik;
    }

    public function update($request){
        $nik_pegawai = $request['editnikp'];
        $nama = $request['editnama'];
        $alamat = $request['editalamat'];
        $jenis_kelamin = $request['editjk'];
        $password = $request['editpw'];
        $no_hp = $request['editnohp'];
        $email = $request['editemail'];
        $id_jenis = $request['editjpgw'];
        $data = $this->pegawaiService->updatePegawai($nik_pegawai, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $id_jenis);
        if ($data) {
            return json_encode(["message" => "Berhasil perbarui pegawai"]);
        }else{
            return json_encode(["message" => "Gagal perbarui pegawai"]);
        }
    }

    public function delete($nik_pegawai){
        if ($this->pegawaiService->deletedPegawai($nik_pegawai)) {
            return json_encode(["message" => "Berhasil hapus pegawai"]);
        }
        return json_encode(["message" => "Gagal hapus pegawai"]);
    }

    public function getjpegawai(){
        $jpegawai = $this->pegawaiService->getJPegawai();
        return $jpegawai;
    }
}