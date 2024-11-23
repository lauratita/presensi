<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/pgwmodel.php';
use PegawaiModel as pgw;

class PegawaiService{
    private $db;
    private $pgw;
    private $jpgw;

    public function __construct($db){
        $this->pgw = new PegawaiModel($db);
    }

    public function createPegawai($nik, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $idJenis){
        $this->pgw->nik = $nik;
        $this->pgw->nama = $nama;
        $this->pgw->alamat = $alamat;
        $this->pgw->jenis_kelamin = $jenis_kelamin;
        $this->pgw->password = $password;
        $this->pgw->no_hp = $no_hp;
        $this->pgw->email = $email;
        $this->pgw->idJenis = $idJenis;
        return $this->pgw->create();
    }

    public function getAllPegawai(){
        $stmt = $this->pgw->read();
        return $stmt;
    }

    public function getPegawaiByNik($nik) {
        $stmt = $this->pgw->getByNik($nik);
        return $stmt;
    }

    public function updatePegawai($nik, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $idJenis){
        $this->pgw->nik = $nik;
        $this->pgw->nama = $nama;
        $this->pgw->alamat = $alamat;
        $this->pgw->jenis_kelamin = $jenis_kelamin;
        $this->pgw->password = $password;
        $this->pgw->no_hp = $no_hp;
        $this->pgw->email = $email;
        $this->pgw->idJenis = $idJenis;
        return $this->pgw->update();
    }

    public function deletedPegawai($nik) {
        $this->pgw->nik = $nik;
        return $this->pgw->delete();
    }
}