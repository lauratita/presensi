<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/dmapelView.php';

class DMapelController{
    private $Service;
    public function __construct(){
        global $koneksi;
        $this->DMapelService = new dmapelService($koneksi);
    }

    public function create($request){
        try {
            $hari = $request['hari'];
            $jam_awal = $request['jam_awal'];
            $jam_akhir = $request['jam_akhir'];
            $id_kelas = $request['id_kelas'];
            $kd_mapel = $request['kd_mapel'];
            $nik_pegawai = $request['nik_pegawai'];
            if ($this->DMapelService->createDMPL($hari, $jam_awal, $jam_akhir, $id_kelas, $kd_mapel, $nik_pegawai)) {
                return json_encode(["message" => "Berhasil menambah data"]);
            }
            return json_encode(["message" => "Gagal menambah data"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function read(){
        $dmpls = $this->DMapelService->getAllDMPL();
        return $dmpls;
    }

    public function getByID($id_jadwal_mapel){
        $dmplid = $this->DMapelService->getDMPLByID($id_jadwal_mapel);
        return $dmplid;
    }

    public function update($request){
        $hari = $request['edithari'];
        $jam_awal = $request['editjamawal'];
        $jam_akhir = $request['editjamakhir'];
        $id_kelas = $request['editkelas'];
        $kd_mapel = $request['editmapel'];
        $nik_pegawai = $request['editguru'];
        
        // Ambil id_jadwal_mapel dari URL atau form sebelumnya
        $id_jadwal_mapel = $_GET['id']; // Atau cara lain untuk mendapatkan ID
    
        $data = $this->DMapelService->updateDMPL($id_jadwal_mapel, $hari, $jam_awal, $jam_akhir, $id_kelas, $kd_mapel, $nik_pegawai);
        
        if ($data) {
            return json_encode(["message" => "Berhasil perbarui data"]);
        } else {
            return json_encode(["message" => "Gagal perbarui data"]);
        }
    }

    public function delete($id_jadwal_mapel){
        if ($this->DMapelService->deletedDMPL($id_jadwal_mapel)) {
            return json_encode(["message" => "Berhasil hapus data"]);
        }
        return json_encode(["message" => "Gagal hapus data"]);
    }

    public function getkelas(){
        $kelas = $this->DMapelService->getKelas();
        return $kelas;
    }

    public function getmapel(){
        $mapel = $this->DMapelService->getMapel();
        return $mapel;
    }

    public function getguru(){
        $guru = $this->DMapelService->getGuru();
        return $guru;
    }
}