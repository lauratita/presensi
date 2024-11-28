<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/suratIzinView.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

class SuratIzinController
{
    private $suratModel;
    
    public function __construct()
    {
        global $koneksi;
        $this->suratModel = new SuratIzinModel($koneksi);
    }

    public function create($request)
    {
        try {
            $keterangan = $request['keterangan'];
            $status = $request['status'];
            $tanggal = $request['tanggal'];
            $foto_surat = $request['foto_surat'];
            $nik_ortu = $request['nik_ortu'];
            $nik_pegawai = $request['nik_pegawai'];
            if ($this->suratModel->create($keterangan, $status, $tanggal, $foto_surat, $nik_ortu, $nik_pegawai)) {
                return json_encode(["message" => "Berhasil menambahkan surat izin"]);
            }
            return json_encode(["message" => "Gagal menambah surat izin"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function read()
    {
        $surats = $this->suratModel->read();
        return $surats;
    }

    public function getByWaliKelas($nik_pegawai, $status)
    {
        $suratnik = $this->suratModel->getByWaliKelas($nik_pegawai, $status);
        return $suratnik;
    }

    public function updateStatusSuratIzin($request)
    {
        $id_surat = $request['id_surat'];
        $nis = $request['nis'];
        $status = $request['keterangan'];
        $nik_ortu = $request['nik_ortu'];
        $nik_pegawai = $request['nik_pegawai'];
        $data = $this->suratModel->update($status, $id_surat, $nis, $nik_ortu, $nik_pegawai);
        return json_encode($data);
    }

}