<?php
class LoginOrtuModel {
    private $koneksi;
    private $table_name = "tb_orangtua";
    private $table_siswa = "tb_siswa";
    

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function login($nikortu, $password) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nikortu);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Periksa jika password belum di-hash
            if ($this->isPlainTextPassword($user['password'])) {
                $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
                $this->updatePasswordHash($nikortu, $hashedPassword);
                $user['password'] = $hashedPassword; // Update password dalam memori
            }

            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return null;
    }

    public function getSiswaByNikOrtu($nikOrtu) {
        $sql = "SELECT * FROM " . $this->table_siswa . " WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nikOrtu);
        $stmt->execute();
        $result = $stmt->get_result();

        $dataSiswa = [];
        while ($row = $result->fetch_assoc()) {
            $dataSiswa[] = $row;
        }

        return $dataSiswa;
    }

    private function isPlainTextPassword($password) {
        return strlen($password) < 60; // Panjang hash bcrypt sekitar 60 karakter
    }

    private function updatePasswordHash($nikOrtu, $hashedPassword) {
        $sql = "UPDATE " . $this->table_name . " SET password = ? WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $hashedPassword, $nikOrtu);
        $stmt->execute();
    }
}