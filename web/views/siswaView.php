<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/siswaModel.php';
use OrtuModel as Ortu;

class SiswaService{
    private $db;
    private $siswa;
    private $ortu;
    private $kelas;

    public function __construct($db){
        $this->siswa = new SiswaModel($db);
        $this->ortu = new SiswaModel($db);
        $this->kelas = new SiswaModel($db);
    }

    public function createSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $id_kelas, $nik_ortu){
        $this->siswa->nis = $nis;
        $this->siswa->nama = $nama;
        $this->siswa->tanggal_lahir = $tanggal_lahir;
        $this->siswa->tahun_akademik = $tahun_akademik;
        $this->siswa->password = $password;
        $this->siswa->jenis_kelamin = $jenis_kelamin;
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

    public function updateSiswa($nis, $nama, $tanggal_lahir, $tahun_akademik, $password, $jenis_kelamin, $alamat, $id_kelas, $nik_ortu){
        $this->siswa->nis = $nis;
        $this->siswa->nama = $nama;
        $this->siswa->tanggal_lahir = $tanggal_lahir;
        $this->siswa->tahun_akademik = $tahun_akademik;
        $this->siswa->password = $password;
        $this->siswa->jenis_kelamin = $jenis_kelamin;
        $this->siswa->alamat = $alamat;
        $this->siswa->id_kelas = $id_kelas;
        $this->siswa->nik_ortu = $nik_ortu;
        return $this->siswa->update();
    }

    public function deletedSiswa($nis) {
        $this->siswa->nis = $nis;
        return $this->siswa->delete();
    }

    public function getOrtu(){
        $stmt = $this->ortu->getortu();
        return $stmt;
    }

    public function getKelas(){
        $stmt = $this->kelas->getkelas();
        return $stmt;
    }
}