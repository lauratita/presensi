<?php

include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/pgwModel.php';
// use PegawaiModel as pgw;

class PegawaiService{
    private $db;
    private $pgw;

    // private $pegawai;

    public function __construct($db){
        $this->pgw = new PegawaiModel($db);
        // $this->pegawai = new PegawaiModel($db);
    }

    public function createPegawai($nik_pegawai, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $id_jenis){
        $this->pgw->nik_pegawai = $nik_pegawai;
        $this->pgw->nama = $nama;
        $this->pgw->alamat = $alamat;
        $this->pgw->jenis_kelamin = $jenis_kelamin;
        $this->pgw->password = $password;
        $this->pgw->no_hp = $no_hp;
        $this->pgw->email = $email;
        $this->pgw->id_jenis = $id_jenis;
        return $this->pgw->create();
    }

    public function getAllPegawai(){
        $stmt = $this->pgw->read();
        return $stmt;
    }

    public function getPegawaiByNik($nik_pegawai){
        $stmt = $this->pgw->getByNik($nik_pegawai);
        return $stmt;
    }

    public function updatePegawai($nik_pegawai, $nama, $alamat, $jenis_kelamin, $password, $no_hp, $email, $id_jenis){
        $this->pgw->nik_pegawai = $nik_pegawai;
        $this->pgw->nama = $nama;
        $this->pgw->alamat = $alamat;
        $this->pgw->jenis_kelamin = $jenis_kelamin;
        $this->pgw->password = $password;
        $this->pgw->no_hp = $no_hp;
        $this->pgw->email = $email;
        $this->pgw->id_jenis = $id_jenis;
        return $this->pgw->update();
    }

    public function deletedPegawai($nik_pegawai) {
        $this->pgw->nik_pegawai = $nik_pegawai;
        return $this->pgw->delete();
    }

    public function getjpegawai(){
        // $this->pgw->getpegawai();
        return $this->pgw->getJPegawai();
    }
}