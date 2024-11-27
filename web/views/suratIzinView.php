<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

class suratIzinView
{
    private $db;
    private $surat;
    public function __construct($db)
    {
        $this->surat = new SuratIzinModel($db);
    }

    public function createSuratIzin($id_surat, $keterangan, $status, $tanggal, $foto_surat, $nik_ortu, $nik_pegawai)
    {
        $this->surat->id_surat = $id_surat;
        $this->surat->keterangan = $keterangan;
        $this->surat->status = $status;
        $this->surat->tanggal = $tanggal;
        $this->surat->foto_surat = $foto_surat;
        $this->surat->nik_ortu = $nik_ortu;
        $this->surat->nik_pegawai = $nik_pegawai;
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