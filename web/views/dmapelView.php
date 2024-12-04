<?php
include_once $_SERVER['DOCUMENT_ROOT']. '/presensi/web/models/dmapelmodel.php';

class dmapelService{
    private $db;
    private $dmpl;

    public function __construct($db){
        $this->dmpl = new dmapelModel($db);
    }

    public function createDMPL($hari, $jam_awal, $jam_akhir, $id_kelas, $kd_mapel, $nik_pegawai){
        $this->dmpl->hari = $hari;
        $this->dmpl->jam_awal = $jam_awal;
        $this->dmpl->jam_akhir = $jam_akhir;
        $this->dmpl->id_kelas = $id_kelas;
        $this->dmpl->kd_mapel = $kd_mapel;
        $this->dmpl->nik_pegawai = $nik_pegawai;
        return $this->dmpl->create();
    }

    public function getAllDMPL(){
        $stmt = $this->dmpl->read();
        return $stmt;
    }

    public function getDMPLByID($id_jadwal_mapel){
        $stmt = $this->dmpl->getByID($id_jadwal_mapel);
        return $stmt;
    }

    public function updateDMPL($id_jadwal_mapel, $hari, $jam_awal, $jam_akhir, $id_kelas, $kd_mapel, $nik_pegawai){
        $this->dmpl->id_jadwal_mapel = $id_jadwal_mapel;
        $this->dmpl->hari = $hari;
        $this->dmpl->jam_awal = $jam_awal;
        $this->dmpl->jam_akhir = $jam_akhir;
        $this->dmpl->id_kelas = $id_kelas;
        $this->dmpl->kd_mapel = $kd_mapel;
        $this->dmpl->nik_pegawai = $nik_pegawai;
        return $this->dmpl->update();
    }

    public function deletedDMPL($id_jadwal_mapel) {
        $this->dmpl->id_jadwal_mapel = $id_jadwal_mapel;
        return $this->dmpl->delete();
    }

    public function getkelas(){
        return $this->dmpl->getKelas();
    }

    public function getmapel(){
        return $this->dmpl->getMapel();
    }

    public function getguru(){
        return $this->dmpl->getGuru();
    }
}