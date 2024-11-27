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
        if ($newPassword !== $confirmPassword) {
            return false; // Pastikan password cocok
        }

        // Hash password baru
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Kirim hash ke model untuk update
        return $this->password->update($nik_pegawai, $hashedPassword);
    }
    
}