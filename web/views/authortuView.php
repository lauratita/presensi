<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/authortuModel.php';

class LoginOrtuService {
    private $model;
    private $koneksi;

    public function __construct($db) {
        $this->model = new LoginOrtuModel($db);
        $this->koneksi = $db;
    }

    public function getLogin($nikOrtu, $password) {
        $user = $this->model->verifyLogin($nikOrtu, $password);

        if ($user) {
            // Hanya perbarui hash jika password masih plain text
            $storedPassword = $user['password'];
            if (strlen($storedPassword) < 60) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $this->updatePasswordHash($nikOrtu, $hash);
                $user['password'] = $hash;
            }

            $dataSiswa = $this->model->getSiswaByNikOrtu($nikOrtu);
            return ['ortu' => $user, 'siswa' => $dataSiswa];
        }
        
        return false;
    }

    private function updatePasswordHash($nikOrtu, $hash) {
        $sql = "UPDATE tb_orangtua SET password = ? WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $hash, $nikOrtu);
        $stmt->execute();
    }
}