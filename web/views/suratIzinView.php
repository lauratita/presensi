<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

class suratIzinService
{
    private $db;
    private $surat;
    public function __construct($db)
    {
        $this->surat = new SuratIzinModel($db);
    }

    public function createSuratIzin($keterangan, $status, $tanggal, $tenggat, $foto_surat, $nik_ortu, $nik_pegawai, $nis)
    {
        $this->surat->keterangan = $keterangan;
        $this->surat->status = $status;
        $this->surat->tanggal = $tanggal;
        $this->surat->tenggat = $tenggat;
        $this->surat->foto_surat = $foto_surat;
        $this->surat->nik_ortu = $nik_ortu;
        $this->surat->nik_pegawai = $nik_pegawai;
        $this->surat->nis = $nis;
        return $this->surat->create();
    }
    
    public function getAllSurat()
    {
        $stmt = $this->surat->read();
        return $stmt;
    }

    public function getSuratIzinByWaliKelas($nik_pegawai, $status)
    {
        $stmt = $this->surat->getByWaliKelas($nik_pegawai, $status);
        return $stmt;
    }

    // public function updateStatusSuratIzin($id_surat, $status)
    // {
    //     $this->surat->update($id_surat, $status);
    //     return $this->surat->update();
    // }
}