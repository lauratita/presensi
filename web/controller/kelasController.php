<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/kelasView.php';

class KelasController{
    private $kelasService;
    public function __construct(){
        global $koneksi;
        $this->kelasService = new KelasService($koneksi);
    }

    public function create($request){
        try {
            // $nama_kelas = $request['nama_kelas'];
            $idjenis = $request['kelas'];
            $jurusan = $request['jurusan'];
            $nik_pegawai = $request['nik_pegawai'];
            
            if ($this->kelasService->createKelas( $idjenis, $jurusan, $nik_pegawai)) {
                return json_encode(["message" => "Berhasil tambah data"]);
            }
            return json_encode(["message" => "Gagal menambah data"]);
        } catch (Exception $e) {
            return json_encode(["message" => $e->getMessage()]);
        }
    }

    public function read(){
        $kelass = $this->kelasService->getAllKelas();
        return $kelass;
    }

    public function getAll(){
        $kelas = $this->kelasService->getAll();
        return $kelas;
    }

    public function getById($id_kelas){
        $kelasid = $this->kelasService->getKelasById($id_kelas);
        return $kelasid;
    }

    public function update($request){
        $id_kelas = $request['id_kelas'];
        // $nama_kelas = $request['editnama_kelas'];
        $jenis_kelas = $request['editkelas'];
        $jurusan = $request['editjurusan'];
        $nik_pegawai = $request['editnik_pegawai'];
        $data = $this->kelasService->updateKelas($id_kelas,  $jenis_kelas, $jurusan, $nik_pegawai);
        if ($data) {
            return json_encode(["message" => "Berhasil Perbarui Kelas"]);
        }else{
            return json_encode(["message" => "Gagal Memeperbarui Kelas"]);
        }
    }

    public function delete($id_kelas){
        if ($this->kelasService->deletedKelas($id_kelas)) {
            return json_encode(["message" => "Berhasil Hapus Kelas"]);
        }
        return json_encode(["message" => "Gagal hapus Kelas"]);
    }

    // public function getpegawai(){
    //     $pegawai = $this->kelasService->getPegawai();
    //     return $pegawai;
    // }

    public function pegawaiTambah() {
        $datapegawaitambah = $this->kelasService->getPegawaiUntukTambah();
        return $datapegawaitambah;
    }

    public function pegawaiEdit($id_kelas) {
        $datapegawaiedit = $this->kelasService->getPegawaiUntukEdit($id_kelas);
        return $datapegawaiedit;
         // Mengirim data pegawai ke view
    }

    public function getjenis(){
        $jenis = $this->kelasService->getidjenis();
        return $jenis;
    }

    public function getjurusan(){
        $jurusan = $this->kelasService->getjurusan();
        return $jurusan;
    }

}