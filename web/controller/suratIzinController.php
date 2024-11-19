<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/suratIzinView.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

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

    public function getByWaliKelas($nik_pegawai, $status)
    {
        $suratnik = $this->suratView->getSuratIzinByWaliKelas($nik_pegawai, $status);
        return $suratnik;
    }

    public function updateStatusSuratIzin($id_surat, $status)
    {
        $result = $this->suratView->updateStatusSuratIzin($id_surat, $status);
        if ($result) {
            return json_encode(["message" => "Status berhasil diperbarui"]);
        } else {
            return json_encode(["message" => "Gagal memperbarui status"]);
        }
    }

}