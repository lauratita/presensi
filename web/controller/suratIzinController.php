<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/suratIzinView.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

class SuratIzinController
{
    private $suratModel;
    private $suratView;
    
    public function __construct()
    {
        global $koneksi;
        $this->suratModel = new SuratIzinModel($koneksi);
        $this->suratView = new suratIzinView($koneksi);
    }

    public function create($request)
    {
        try {
            $keterangan = $request['keterangan'];
            $status = $request['status'];
            $tanggal = $request['tanggal'];
            $tenggat = $request['tenggat'];
            $foto_surat = $request['foto_surat'];
            $nik_ortu = $request['nik_ortu'];
            $nik_pegawai = $request['nik_pegawai'];
            $nis = $request['nis'];
          
            if ($this->suratView->createSuratIzin($keterangan, $status, $tanggal, $tenggat, $foto_surat, $nik_ortu, $nik_pegawai, $nis)) {
                return json_encode(["message" => "Berhasil menambahkan surat izin"]);
            }
            return json_encode(["message" => "Gagal menambah surat izin"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
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

    public function getSiswaByNIKOrtu($nik_ortu) {
        return $this->suratModel->getSiswaByNIKOrtu($nik_ortu);
    }

    public function updateStatusSuratIzin($request)
    {
        $id_surat = $request['id_surat'] ?? null;
        // $keterangan = $request['keterangan'] ?? null;
        $status = $request['status'] ?? null;
        // $nis = $request['nis'] ?? null;
        // $tanggal = $request['tanggal'] ?? null;
        // $foto_surat = $request['foto_surat'] ?? null;
        // $nik_ortu = $request['nik_ortu'] ?? null;
        // $nik_pegawai = $request['nik_pegawai'] ?? null;

        // Panggil fungsi update dari model
        $data = $this->suratView->updateStatusSuratIzin($id_surat, $status);
        if ($data) {
            return json_encode(["message" => "Berhasil Perbarui Surat Izin"]);
        } else {
            return json_encode(["message" => "Gagal Memperbarui Surat Izin"]);
        }
    }

}