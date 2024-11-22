<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/siswaView.php';

class SiswaController{
    private $siswaService;
    public function __construct(){
        global $koneksi;
        $this->siswaService = new SiswaService($koneksi);
    }

    public function create($request){
        try {
            $nis = $request['nis'];
            $nama = $request['nama'];
            $tanggal_lahir = $request['tanggal_lahir'];
            $tahun_akademik = $request['tahun_akademik'];
            $password = $request['password'];
            $jenis_kelamin = $request['jenis_kelamin'];
            $alamat = $request['alamat'];
            $id_kelas = $request['id_kelas'];
            $nik_ortu = $request['nik_ortu'];
            if ($this->siswaService->createSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $id_kelas, $nik_ortu)) {
                return json_encode(["message" => "Berhasil tambah data"]);
            }
            return json_encode(["message" => "Gagal menambah data"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function read(){
        $siswas = $this->siswaService->getAllSiswa();
        return $siswas;
    }

    public function getByNis($nis){
        $siswanis = $this->ortuService->getSiswaByNis($nis);
        return $siswanis;
    }

    public function update($request){
        $nis = $request['editnik'];
        $nama = $request['editnama'];
        $tanggal_lahir = $request['editalamat'];
        $tahun_akademik = $request['editno_hp'];
        $password = $request['editjenis_kelamin'];
        $jenis_kelamin = $request['editemail'];
        $alamat = $request['editpassword'];
        $id_kelas = $request['id_kelas'];
        $nik_ortu = $request['nik_ortu'];
        $data = $this->siswaService->updateSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $id_kelas, $nik_ortu);
        if ($data) {
            return json_encode(["message" => "Berhasil Perbarui Siswa"]);
        }else{
            return json_encode(["message" => "Gagal Memeperbarui Siswa"]);
        }
    }

    public function delete($nis){
        if ($this->siswaService->deletedSiswa($nis)) {
            return json_encode(["message" => "Berhasil Hapus Siswa"]);
        }
        return json_encode(["message" => "Gagal hapus Siswa"]);
    }

    public function getortu(){
        $ortu = $this->siswaService->getOrtu();
        return $ortu;
    }

    public function getkelas(){
        $kelas = $this->siswaService->getKelas();
        return $kelas;
    }
}