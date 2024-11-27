<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/passwordView.php';

class PasswordController {
    private $passwordView;

    public function __construct() {
        global $koneksi;
        $this->passwordView = new PasswordView($koneksi);
    }

    public function getByNik($nik_pegawai)
    {
        $passwordnik = $this->passwordView->getGuruByNik($nik_pegawai);
        return $passwordnik;
    }

    public function ubahPassword($request) {
        $nik_pegawai = $request['nik_pegawai'];
        $newPassword = $request['newPassword'];
        $confirmPassword = $request['confirmPassword'];
        $data = $this->passwordView->ubahPassword($nik_pegawai, $newPassword, $confirmPassword);
        
        if ($data) {
            return json_encode(["message" => "Berhasil Perbarui Password"]);
        }else{
            return json_encode(["message" => "Gagal Memperbarui Password"]);
        }
    }
    
}