<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/authModel.php';

class LoginService {
    private $koneksi;
    private $login;

    public function __construct($db) {
        $this->koneksi = $db;
        $this->login = new LoginModel($db);
    }

    public function getLogin($nikPegawai, $password) {
        $user = $this->login->login($nikPegawai);

        // Jika NIK tidak ditemukan
        if (!$user) {
            return ['error' => 'NIK Pegawai tidak ditemukan'];
        }

        
        $storedPassword = $user['password'];

        // Jika password disimpan dalam plaintext, hash dan perbarui
        if ($this->isPlainTextPassword($storedPassword)) {
            $hashedPassword = password_hash($storedPassword, PASSWORD_DEFAULT);
            if (!$this->updatePasswordHash($nikPegawai, $hashedPassword)) {
                return ['error' => 'Gagal memperbarui password hash'];
            }
            $storedPassword = $hashedPassword;
        }

        // Verifikasi password
        if (!password_verify($password, $storedPassword)) {
            return ['error' => 'Password salah'];
        }

        return $user;

    }

    private function isPlainTextPassword($password){
        return strlen($password) < 60;
    }

    private function updatePasswordHash($nikPegawai, $hash){
        $sql = "UPDATE tb_pegawai SET password = ? WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $hash, $nikPegawai);
        $stmt->execute();
    }
}