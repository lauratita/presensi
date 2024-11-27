<?php

class LoginSiswaModel {
    private $koneksi;
    private $table_name = "tb_siswa";
    
    public function __construct($db) {
        $this->koneksi = $db;   
    }

    public function login($nis,$password) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nis = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nis);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
}