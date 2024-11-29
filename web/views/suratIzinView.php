<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

class suratIzinView
{
    private $db;
    private $surat;
    public $id_surat;
    public $status;
    public $nik_ortu;


    public function __construct($db)
    {
        $this->surat = new SuratIzinModel($db);
    }

    public function createSuratIzin($keterangan, $status, $tanggal, $foto_surat, $nik_ortu, $nik_pegawai, $nis)
    {
        $this->surat->keterangan = $keterangan;
        $this->surat->status = $status;
        $this->surat->tanggal = $tanggal;
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

    public function getSiswaByNIKOrtu($nik_ortu)
    {
        $stmt = $this->surat->getSiswaByNIKOrtu($nik_ortu);
        return $stmt;
    }

    public function updateStatusSuratIzin($id_surat, $status)
    {
        $this->surat->id_surat = $id_surat;
        // $this->surat->keterangan = $keterangan;
        $this->surat->status = $status;
        // $this->surat->nis = $nis;
        // $this->surat->tanggal = $tanggal;
        // $this->surat->foto_surat = $foto_surat;
        // $this->surat->nik_ortu = $nik_ortu;
        // $this->surat->nik_pegawai = $nik_pegawai;
        return $this->surat->update();
    }
}