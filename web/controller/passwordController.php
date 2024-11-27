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
        $newPassword = trim($request['newPassword']);  // Menghapus spasi yang tidak terlihat
        $confirmPassword = trim($request['confirmPassword']);  // Menghapus spasi yang tidak terlihat

        var_dump($newPassword, $confirmPassword);
    
        // Validasi input
        if (empty($nik_pegawai) || empty($newPassword) || empty($confirmPassword)) {
            return json_encode(["success" => false, "message" => "Semua field harus diisi."]);
        }
    
        // Validasi password dan konfirmasi password
        if ($newPassword !== $confirmPassword) {
            return json_encode(["success" => false, "message" => "Password baru dan konfirmasi password tidak cocok."]);
        }
    
        // Panggil service untuk ubah password
        $data = $this->passwordView->ubahPassword($nik_pegawai, $newPassword, $confirmPassword);
    
        if ($data['success']) {
            return json_encode(["success" => true, "message" => $data['message']]);
        }
        return json_encode(["success" => false, "message" => $data['message']]);
    }
    
}