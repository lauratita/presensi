<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/authortuModel.php';

class LoginOrtuService {
    private $koneksi;
    private $login;

    public function __construct($db) {
        $this->koneksi = $db;
        $this->login = new LoginOrtuModel($db);
    }

    public function getLogin($nikOrtu, $password) {
        $user = $this->login->login($nikOrtu, $password);
        
        if ($user) {
            $storedPassword = $user['password'];
            if($this->isPlainTextPassword($storedPassword)){
                $hash = password_hash($storedPassword, PASSWORD_DEFAULT);
                $this->updatePasswordHash($nikOrtu, $hash);
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

    private function updatePasswordHash($nikOrtu, $hash){
        $sql = "UPDATE tb_orangtua SET password = ? WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $hash, $nikOrtu);
        $stmt->execute();
    }
}