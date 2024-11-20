<?php
include_once '../model/presensimodel.php';
use PresensiModel as Presensi;

class PresensiService{
    private $db;
    private $Presensi;

    public function __construct($db){
        $this->presensi = new PresensiModel($db);
    }

    public function createOrtu($id_presensi, $tanggal, $jam_datang, $jam_pulang, $valid_foto_datang, $valid_foto_pulang, $id_jadwal, $nis, $id_surat){
        $this->presensi->id_presensi = $id_presensi;
        $this->presensi->tanggal = $tanggal;
        $this->presensi->jam_datang = $jam_datang;
        $this->presensi->jam_pulang = $jam_pulang;
        $this->presensi->valid_foto_datang = $valid_foto_datang;
        $this->presensi->valid_foto_pulang = $valid_foto_pulang;
        $this->presensi->id_jadwal = $id_jadwal;
        $this->presensi->nis = $nis;
        $this->presensi->id_surat = $id_surat;
        return $this->presensi->create();
    }

    public function getAllPresensi(){
        // $stmt = $this->ortu->read();
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $ortus = $result->fetch_all(MYSQLI_ASSOC);
        // return $ortus;
        $stmt = $this->presensi->read();
        $presensis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $presensis;
    }
    

    public function getByPresensi($id_presensi){
        $presensigetid_presensi = $this->presensi->GetByPresensi($id_presensi);
        // $ortugetnik = $stmt->fetch(PDO::FETCH_ASSOC);
        return $presensigetid_presensi;
        // $ortus = $result->fetch_assoc();
        // return $ortus;
    }

    public function updatePresensi($id_presensi, $tanggal, $jam_datang, $jam_pulang, $valid_foto_datang, $valid_foto_pulang, $id_jadwal, $nis, $id_surat){
        $this->presensi->id_presensi = $id_presensi;
        $this->presensi->tanggal = $tanggal;
        $this->presensi->jam_datang = $jam_datang;
        $this->presensi->jam_pulang = $jam_pulang;
        $this->presensi->valid_foto_datang = $valid_foto_datang;
        $this->presensi->valid_foto_pulang = $valid_foto_pulang;
        $this->presensi->id_jadwal = $id_jadwal;
        $this->presensi->$nis = $nis;
        $this->presensi->$id_surat = $id_surat;
        return $this->presensi->update();
    }

    public function deletedPresensi($id_presensi) {
        $this->presensi->id_presensi = $id_presensi;
        return $this->presensi->delete();
    }
}