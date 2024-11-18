<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/suratIzinView.php';

class SuratIzinController
{
    private $suratView;
    
    public function __construct()
    {
        global $koneksi;
        $this->suratView = new suratIzinView($koneksi);
    }

    public function read()
    {
        $surats = $this->suratView->getAllSurat();
        return $surats;
    }

    public function getByWaliKelas($nik_pegawai)
    {
        $suratnik = $this->suratView->getSuratIzinByWaliKelas($nik_pegawai);
        return $suratnik;
    }

    public function updateStatusSuratIzin($request)
    {
        $status = $request['status'];
        $data = $this->suratView->updateStatusSuratIzin($status);
        if ($data) {
            return json_encode(["message" => "Berhasil Update Status Surat"]);
        }else{
            return json_encode(["message" => "Gagal Update Status Surat"]);
        }
    }

}