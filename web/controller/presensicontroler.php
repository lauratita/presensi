<?php
include_once '../config/config.php';
include_once '../models/presensimodel.php';

class PresensiControler{
    private $presensimodel;

    public function __construct()
    {
        global $koneksi;
        $this->presensimodel = new PresensiModel($koneksi);
    }

    public function create($request){
        $id_presensi = $request['id_presensi'];
        $tanggal = $request['tanggal'];
        $jam_datang = $request['jam_datang'];
        $jam_pulang = $request['jam_pulang'];
        $valid_foto_datang = $request['valid_foto_datang'];
        $valid_foto_pulang = $request['valid_foto_pulang'];
        $id_jadwal = $request['id_jadwal'];
        $nis = $request['nis'];
        $id_surat = $request['id_surat'];
        if ($this->presensimodel->createPresensi($id_presensi, $tanggal, $jam_datang, $jam_pulang, $valid_foto_datang, $valid_foto_pulang, $id_jadwal, $nis, $id_surat)) {
            return json_encode(["message" => "Berhasil tambah data"]);
        }
        return json_encode(["message" => "Gagal menambah data"]);
    }

    public function read(){
        $presensis = $this->presensimodel->readvpresensi();
        return json_encode($presensis);
    }

    public function presensigetid_presensi($id_presensi){
        $presensigetid_presensi = $this->presensimodel->getPresensiById_presensi($id_presensi);
        // return json_encode($ortugetnik);
        if (!$presensigetid_presensi) {
            // Jika data tidak ditemukan, tampilkan pesan di sini untuk debugging
            var_dump("Data tidak ditemukan untuk Id Presensi:", $id_presensi);
        }
        return $presensigetid_presensi;
    }

    public function update($request){
        $id_presensi = $request['id_presensi'];
        $tanggal = $request['tanggal'];
        $jam_datang = $request['jam_datang'];
        $jam_pulang = $request['jam_pulang'];
        $valid_foto_datang = $request['valid_foto_datang'];
        $valid_foto_pulang = $request['valid_foto_pulang'];
        $id_jadwal = $request['id_jadwal'];
        $nis = $request['nis'];
        $id_surat = $request['id_surat'];
        if ($this->presensimodel->updatePresensi($id_presensi, $tanggal, $jam_datang, $jam_pulang, $valid_foto_datang, $valid_foto_pulang, $id_jadwal, $nis, $id_surat)) 
        {
            return json_encode(["message" => "Berhasil Perbarui Presensi"]);
        }
        return json_encode(["message" => "Gagal Memeperbarui Presensi"]);
    }

    public function delete($request){
        $id_presensi = $request['id_presensi'];
        if ($this->presensimodel->deletedPresensi($id_presensi)) {
            return json_encode(["message" => "Berhasil Hapus Presensi"]);
        }
        return json_encode(["message" => "Gagal hapus Presensi"]);
    }
}