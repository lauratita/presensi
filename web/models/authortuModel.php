<?php

class LoginOrtuModel {
    private $koneksi;
    private $table_name = "tb_orangtua";
    
    public function __construct($db) {
        $this->koneksi = $db;   
    }

    public function login($nikortu,$password) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nikortu);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return null;
    }
}