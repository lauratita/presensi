<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/suratIzinView.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

class SuratIzinController
{
    private $model;
    
    public function __construct($model)
    {
        global $koneksi;
        $this->model = $model;
    }

    public function tampilSuratIzin($nik_pegawai, $status)
    {
        return $this->model->getSuratIzinByWaliKelas($nik_pegawai, $status);
        
        // $unverified = $this->model->getSuratIzinByWaliKelas($nik_pegawai, 'unverified');
        // $verified = $this->model->getSuratIzinByWaliKelas($nik_pegawai, 'verified');
        // $disable = $this->model->getSuratIzinByWaliKelas($nik_pegawai, 'disable');
        // return [
        //     'unverified' => $unverified,
        //     'verified' => $verified,
        //     'disable' => $disable
        // ];
    }

    public function updateStatus($id_surat, $new_status)
    {
        return $this->model->updateStatusSuratIzin($id_surat, $new_status);
    }
}