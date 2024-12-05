<?php
class LoginOrtuModel {
    private $koneksi;
    private $table_name = "tb_orangtua";
    private $table_siswa = "tb_siswa";

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function verifyLogin($nikOrtu, $password) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nikOrtu);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return password_verify($password, $user['password']) ? $user : null;
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
}