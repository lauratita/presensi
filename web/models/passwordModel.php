<?php
class PasswordModel {
    private $koneksi;
    public $table_name = 'tb_pegawai';
    public $password;
    public $nik_pegawai;

    public function __construct($db) 
    {
        $this->koneksi = $db;
    }
    
    public function update() 
    {
        $sql = "UPDATE " . $this->table_name . " SET password = :password WHERE nik_pegawai = :nik_pegawai";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':nik_pegawai', $this->nik_pegawai);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}