<?php
class LoginModel {
    private $koneksi;
    private $table_name = "tb_pegawai";
    
    public function __construct($db) {
        $this->koneksi = $db;   
    }

    public function login($nikPegawai) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nikPegawai);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
}