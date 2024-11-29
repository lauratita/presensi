<?php
class PasswordModel {
    private $koneksi;
    public $table_name = 'tb_pegawai';
    public $password;
    public $nik_pegawai;
    public $newPassword;
    public $confirmPassword;

    public function __construct($db) 
    {
        $this->koneksi = $db;
    }
    
    public function update() 
    {
        $sql = "UPDATE " . $this->table_name . " SET password = '$this->newPassword' WHERE nik_pegawai = '$this->nik_pegawai'"; // Pastikan menggunakan newPassword
        $stmt = $this->koneksi->prepare($sql);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByNik($nik_pegawai)
    {
        $sql = "SELECT password FROM " . $this->table_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nik_pegawai);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data); 
        } else {
            echo json_encode(["message" => "Data not found for given NIK"]);
        }
    
        $stmt->close();
    }
}