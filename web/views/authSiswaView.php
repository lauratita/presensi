<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/authSiswaModel.php';

class LoginSiswaService {
    private $koneksi;
    private $login;

    public function __construct($db) {
        $this->koneksi = $db;
        $this->login = new LoginSiswaModel($db);
    }

    public function getLogin($nisSiswa, $password) {
        $user = $this->login->login($nisSiswa, $password);
        
        if ($user) {
            $storedPassword = $user['password'];
            if($this->isPlainTextPassword($storedPassword)){
                $hash = password_hash($storedPassword, PASSWORD_DEFAULT);
                $this->updatePasswordHash($nisSiswa, $hash);
                $storedPassword = $hash;
            }
            if(password_verify($password, $storedPassword)){
                return $user;
            } else {
                return false;
            }
        }else {
            return false;
        }

    }

    private function isPlainTextPassword($password){
        return strlen($password) < 60;
    }

    private function updatePasswordHash($nisSiswa, $hash){
        $sql = "UPDATE tb_siswa SET password = ? WHERE nis = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $hash, $nisSiswa);
        $stmt->execute();
    }
}