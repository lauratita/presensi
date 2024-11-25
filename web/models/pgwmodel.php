<?php
class PegawaiModel{
    private $koneksi;
    private $table_name ="tb_pegawai";
    private $table_jenispegawai ="tb_jenispegawai";

    public $nik;
    public $nama;
    public $alamat;
    public $jenis_kelamin;
    public $password;
    public $no_hp;
    public $email;
    public $idJenis;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create(){
        $sql = "INSERT INTO " . $this->table_name . " (nik_pegawai, nama, alamat, jenis_kelamin, password, no_hp email, id_jenis)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ssssssss", $this->nik, $this->nama, $this->alamat, $this->jenis_kelamin, $this->password, $this->no_hp, $this->email, $this->idJenis);
            if ($stmt->execute()) {
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
           return false;
        }
    }

    public function read(){
        $sql = "SELECT * FROM " .$this->table_name;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function update(){
        $sql = "UPDATE " . $this->table_name . "SET nama = ?, alamat = ?, jenis_kelamin = ?, password = ?, no_hp = ?, email = ?, id_jenis = ? WHERE nik_pegawai= ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ssssssss", $new_id, $this->nik_pegawai, $this->nama, $this->alamat, $this->jenis_kelamin, $this->password, $this->no_hp, $this->email, $this->id_jenis);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);

        $stmt->bind_param("s", $this->nik);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByNikp($nik){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);

        $stmt->bind_param("s", $nik);
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