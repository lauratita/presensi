<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/ortumodel.php';
use OrtuModel as Ortu;

class OrtuService{
    private $db;
    private $ortu;

    public function __construct($db){
        $this->ortu = new OrtuModel($db);
    }

    public function createOrtu($nik, $nama, $alamat, $no_hp, $jenis_kelamin, $email, $password){
        $this->ortu->nik = $nik;
        $this->ortu->nama = $nama;
        $this->ortu->alamat = $alamat;
        $this->ortu->no_hp = $no_hp;
        $this->ortu->jenis_kelamin = $jenis_kelamin;
        $this->ortu->email = $email;
        $this->ortu->password = $password;
        return $this->ortu->create();
    }

    public function getAllOrtu(){
        $stmt = $this->ortu->read();
        return $stmt;
    }

    public function getOrtuByNik($nik){
        $stmt = $this->ortu->getByNik($nik);
        return $stmt;
    }

    public function updateOrtu($nik, $nama, $alamat, $no_hp, $jenis_kelamin, $email){
        $this->ortu->nik = $nik;
        $this->ortu->nama = $nama;
        $this->ortu->alamat = $alamat;
        $this->ortu->no_hp = $no_hp;
        $this->ortu->jenis_kelamin = $jenis_kelamin;
        $this->ortu->email = $email;
        
        return $this->ortu->update();
    }

    public function deletedOrtu($nik) {
        $this->ortu->nik = $nik;
        return $this->ortu->delete();
    }
}