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
        
        if ($user) {
            $storedPassword = $user['password'];
            if($this->isPlainTextPassword($storedPassword)){
                $hash = password_hash($storedPassword, PASSWORD_DEFAULT);
                $this->updatePasswordHash($nikPegawai, $hash);
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

    private function updatePasswordHash($nikPegawai, $hash){
        $sql = "UPDATE tb_pegawai SET password = ? WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $hash, $nikPegawai);
        $stmt->execute();
    }
}