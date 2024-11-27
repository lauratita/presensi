<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/passwordModel.php';

class PasswordView
{
    private $password;

    public function __construct($db)
    {
        $this->password = new PasswordModel($db);
    }
    public function ubahPassword($nik_pegawai, $newPassword, $confirmPassword) {
        // Validasi input
        if ($newPassword !== $confirmPassword) {
            return ["success" => false, "message" => "Konfirmasi password tidak sesuai."];
        }

        // Hash password sebelum disimpan
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Set nilai di model
        $this->password->nik_pegawai = $nik_pegawai;
        $this->password->password = $hashedPassword;

        if ($this->password->update()) {
            return ["success" => true, "message" => "Password berhasil diperbarui."];
        }

        return ["success" => false, "message" => "Gagal memperbarui password."];
    }
    
}