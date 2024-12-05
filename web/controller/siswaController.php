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
            $password = $request['nis'];
            $jenis_kelamin = $request['jenis_kelamin'];
            $alamat = $request['alamat'];
            $foto = $_FILES['foto'];
            $tanggal_masuk = $request['tanggal_masuk'];
            $tanggal_akhir = $request['tanggal_berakhir'];
            $id_kelas = $request['id_kelas'];
            $nik_ortu = $request['nik_ortu'];
            
            var_dump($request);
            if ($this->siswaService->createSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $foto, $tanggal_masuk, $tanggal_akhir, $id_kelas, $nik_ortu)) {
                return json_encode(["message" => "Berhasil tambah data"]);
            }
            return json_encode(["message" => "Gagal menambah data"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function naikKelas() {
        $result = $this->siswaService->naikKelas();
        if ($result) {
            echo json_encode(["message" => "Naik kelas berhasil"]);
        } else {
            echo json_encode(["message" => "Gagal naik kelas"]);
        }
    }

    public function read(){
        $siswas = $this->siswaService->getAllSiswa();
        return $siswas;
    }

    public function view(){
        $siswas = $this->siswaService->getview();
        return $siswas;
    }

    public function getByNis($nis){
        $siswanis = $this->siswaService->getSiswaByNis($nis);
        return $siswanis;
    }

    public function update($request){
        $nis = $request['edit_nis'];
        $nama = $request['edit_nama'];
        $tanggal_lahir = $request['edit_tanggal_lahir'];
        $tahun_akademik = $request['edit_tahun_akademik'];
        $jenis_kelamin = $request['edit_jenis_kelamin'];
        $alamat = $request['edit_alamat'];
        $foto = $_FILES['edit_foto'];
        $tanggal_masuk = $request['edttanggal_masuk'];
        $tanggal_akhit = $request['edttanggal_berakhir'];
        $id_kelas = $request['edit_id_kelas'];
        $nik_ortu = $request['edit_nik_ortu'];
        $data = $this->siswaService->updateSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $jenis_kelamin, $alamat, $foto, $tanggal_masuk, $tanggal_akhit, $id_kelas, $nik_ortu);
        if ($data) {
            // var_dump($data);
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