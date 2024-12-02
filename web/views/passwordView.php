<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/passwordModel.php';

class PasswordView
{
    private $password;

    public function __construct($db)
    {
        $this->password = new PasswordModel($db);
    }

    public function getGuruByNik($nik_pegawai)
    {
        $stmt = $this->password->getByNik($nik_pegawai);
        return $stmt;
    }
    
    public function ubahPassword($nik_pegawai, $newPassword, $confirmPassword) 
    {
        // Validasi jika password dan konfirmasi password cocok
        if (trim($newPassword) !== trim($confirmPassword)) {  // Pastikan spasi dihilangkan
            return ['success' => false, 'message' => 'Password dan konfirmasi password tidak cocok.'];
        }

        // Mengatur data password
        $this->password->nik_pegawai = $nik_pegawai;
        $this->password->newPassword = $newPassword; // Simpan password baru tanpa hashing
        return $this->password->update() ? ['success' => true, 'message' => 'Password kamu sudah berubah'] : ['success' => false, 'message' => 'Gagal memperbarui password.'];
    }
    
}