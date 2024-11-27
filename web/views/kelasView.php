<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/kelasModel.php';
// use OrtuModel as Ortu;

class KelasService{
    private $db;
    private $kelas;
    // private $pegawai;

    public function __construct($db){
        $this->kelas = new KelasModel($db);
        // $this->pegawai = new KelasModel($db);
    }

    public function createKelas($nama_kelas, $nik_pegawai){
        $this->kelas->nama_kelas = $nama_kelas;
        $this->kelas->nik_pegawai = $nik_pegawai;
        return $this->kelas->create();
    }

    public function getAllKelas(){
        $stmt = $this->kelas->read();
        return $stmt;
    }

    public function getKelasById($id_kelas){
        $stmt = $this->kelas->getById($id_kelas);
        return $stmt;
    }

    public function updateKelas($id_kelas, $nama_kelas, $nik_pegawai){
        $this->kelas->id_kelas = $id_kelas;
        $this->kelas->nama_kelas = $nama_kelas;
        $this->kelas->nik_pegawai = $nik_pegawai;
        return $this->kelas->update();
    }

    public function deletedKelas($id_kelas) {
        $this->kelas->id_kelas = $id_kelas;
        return $this->kelas->delete();
    }

    // public function getPegawai(){
    //     // $this->kelas->getpegawai();
    //     return $this->kelas->getpegawai();
    // }


    public function getPegawaiUntukTambah() {
        return $this->kelas->getPegawaiUntukTambah();
    }


    public function getPegawaiUntukEdit($id_kelas) {
        return $this->kelas->getPegawaiUntukEdit($id_kelas);
    }
}