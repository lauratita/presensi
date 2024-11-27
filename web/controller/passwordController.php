<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/passwordView.php';

class PasswordController {
    private $passwordView;

    public function __construct() {
        global $koneksi;
        $this->passwordView = new PasswordView($koneksi);
    }

    public function ubahPassword($request) {
        $nik_pegawai = $request['nik_pegawai'];
        $newPassword = $request['newPassword'];
        $confirmPassword = $request['confirmPassword'];

        return json_encode($this->passwordView->ubahPassword($nik_pegawai, $newPassword, $confirmPassword));
    }
    
}