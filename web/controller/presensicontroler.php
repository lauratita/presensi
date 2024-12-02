<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/service/presensiservice.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/presensimodel.php';

class PresensiControler{
    private $presensimodel;
    private $presensiservice;

    public function __construct()
    {
        global $koneksi;
        $this->presensimodel = new PresensiModel($koneksi);
        $this->presensiservice = new PresensiService($koneksi);
    }

    public function create($request){
        $tanggal = $request['tanggal'];
        $jam_datang = $request['jam_datang'];
        $jam_pulang = $request['jam_pulang'] ?? null;
        $nis = $request['nis'];
        $id_surat = $request['id_surat'] ?? null;
        $keterangan = $request['keterangan'] ?? null;
        $id_kelas = $request['id_kelas'];
        $data = $this->presensimodel->create($tanggal, $jam_datang, $jam_pulang, $nis, $id_surat,$keterangan,$id_kelas);
        return json_encode($data);
    }

    public function read(){
        $presensis = $this->presensimodel->readvpresensi();
        return json_encode($presensis);
    }
    public function getallpresensi($nis){
        $presensis = $this->presensimodel->getById($nis);
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
        $tanggal = $request['tanggal'];
        $jam_pulang = $request['jam_pulang'];
        $nis = $request['nis'];
        $id_kelas = $request['id_kelas'];
        $data = $this->presensimodel->absenPulang($tanggal, $jam_pulang, $nis, $id_kelas);
        return json_encode($data);
    }

    public function delete($request){
        $id_presensi = $request['id_presensi'];
        if ($this->presensimodel->deletedPresensi($id_presensi)) {
            return json_encode(["message" => "Berhasil Hapus Presensi"]);
        }
        return json_encode(["message" => "Gagal hapus Presensi"]);
    }

    public function getByWaliKelasHariIni($nik_pegawai)
    {
        $presensinik = $this->presensiservice->getSuratIzinByWaliKelasHariIni($nik_pegawai);
        return $presensinik;
    }
}