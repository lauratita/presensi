<?php
include_once '../admin/model/ortumodel.php';
use OrtuModel as Ortu;

class OrtuService{
    private $db;
    private $ortu;

    public function __construct($db){
        $this->ortu = new OrtuModel($db);
    }

    public function createOrtu($nik, $nama, $email, $password, $no_hp, $alamat, $jenis_kelamin){
        $this->ortu->nik = $nik;
        $this->ortu->nama = $nama;
        $this->ortu->email = $email;
        $this->ortu->password = $password;
        $this->ortu->no_hp = $no_hp;
        $this->ortu->alamat = $alamat;
        $this->ortu->jenis_kelamin = $jenis_kelamin;
        return $this->ortu->create();
    }

    public function getAllOrtu(){
        $stmt = $this->ortu->read();
        $stmt->execute();
        $result = $stmt->get_result();
        $ortus = $result->fetch_all(MYSQLI_ASSOC);
        return $ortus;
    }

    public function getOrtuByNik(){
        $this->ortu->nik = $nik;
        return $this->ortu->getByNik();
    }

    public function updateOrtu($nik, $nama, $email, $password, $no_hp, $alamat, $jenis_kelamin){
        $this->ortu->nik = $nik;
        $this->ortu->nama = $nama;
        $this->ortu->email = $email;
        $this->ortu->password = $password;
        $this->ortu->no_hp = $no_hp;
        $this->ortu->alamat = $alamat;
        $this->ortu->jenis_kelamin = $jenis_kelamin;
        return $this->ortu->update();
    }

    public function deletedOrtu($nik) {
        $this->ortu->nik = $nik;
        return $this->ortu->delete();
    }
}