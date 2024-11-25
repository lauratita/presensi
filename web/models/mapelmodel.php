<?php
class MapelModel{
    private $koneksi;
    private $table_name = "tb_mapel";

    public $kode;  
    public $nama;

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function create() {
        $sql = "INSERT INTO " . $this->table_name . " (kd_mapel, nama)
                VALUES (?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ss", $this->kode, $this->nama);  
            if ($stmt->execute()) {
                return true; 
            } else {
                return false; 
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage()); 
            return false; 
        }
    }

    public function read(){
        $sql = "SELECT * FROM " .$this->table_name;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given Kode"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function update($kd_mapel, $nama){
        $sql = "UPDATE " . $this->table_name . " SET nama = ? WHERE kd_mapel = ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ss", $nama, $kd_mapel);
    
            if ($stmt->execute()) {
                return true;  
            } else {
                return false; 
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());  
            return false; 
        }
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE kd_mapel = ?";
        $stmt = $this->koneksi->prepare($sql);

        $stmt->bind_param("s", $this->kode);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByKode($kode){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE kd_mapel = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $kode); 
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data); 
        } else {
            return json_encode(["message" => "Data not found for given Kode"]);
        }
    }
}