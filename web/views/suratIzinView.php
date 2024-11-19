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

    public function updateStatusSuratIzin($status)
    {
        $this->surat->status = $status;
        return $this->surat->update();
    }
}