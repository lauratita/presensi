<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/siswaModel.php';


class SiswaService{
    private $db;
    private $siswa;


    public function __construct($db){
        $this->siswa = new SiswaModel($db);
        
    }

    public function createSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $foto, $id_kelas, $nik_ortu){
        $this->siswa->nis = $nis;
        $this->siswa->nama = $nama;
        $this->siswa->tanggal_lahir = $tanggal_lahir;
        $this->siswa->tahun_akademik = $tahun_akademik;
        $this->siswa->password = $password;
        $this->siswa->jenis_kelamin = $jenis_kelamin;
        $this->siswa->alamat = $alamat;
        $foto_path = $this->siswa->uploadImage($foto);
        $this->siswa->foto = $foto_path;
        $this->siswa->id_kelas = $id_kelas;
        $this->siswa->nik_ortu = $nik_ortu;
        return $this->siswa->create();
    }

    public function getAllSiswa(){
        $stmt = $this->siswa->read();
        return $stmt;
    }

    public function getSiswaByNis($nis){
        $stmt = $this->siswa->getByNis($nis);
        return $stmt;
    }

    public function updateSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $foto, $id_kelas, $nik_ortu){
        var_dump($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $foto, $id_kelas, $nik_ortu);

        $this->siswa->nis = $nis;
        $this->siswa->nama = $nama;
        $this->siswa->tanggal_lahir = $tanggal_lahir;
        $this->siswa->tahun_akademik = $tahun_akademik;
        $this->siswa->password = $password;
        $this->siswa->jenis_kelamin = $jenis_kelamin;
        $this->siswa->alamat = $alamat;
        if (!empty($foto['name'])) {
            $foto_path = $this->siswa->uploadImage($foto);
            $this->siswa->foto = $foto_path;
        } else {
            $this->siswa->foto = $this->getFotoLama($nis); 
        }
        $this->siswa->id_kelas = $id_kelas;
        $this->siswa->nik_ortu = $nik_ortu;
        return $this->siswa->update();
    }

    public function deletedSiswa($nis) {
        $this->siswa->nis = $nis;
        return $this->siswa->delete();
    }

    public function getOrtu(){
        $stmt = $this->siswa->getortu();
        return $stmt;
    }

    public function getKelas(){
        $stmt = $this->siswa->getkelas();
        return $stmt;
    }
    
    public function getFotoLama($nis) {
        return $this->siswa->getFotoLama($nis); // Delegasikan ke model Siswa
    }
}