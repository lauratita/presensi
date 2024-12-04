<?php
class PegawaiModel{
    private $koneksi;
    private $table_name ="tb_pegawai";
    private $table_jpegawai = "tb_jenispegawai";
    private $table_view = "v_pegawai_detail";
    public $nik_pegawai;
    public $nama;
    public $alamat;
    public $jenis_kelamin;
    public $password;
    public $no_hp;
    public $email;

    public $id_jenis;

    public function __construct($db){
        $this->koneksi = $db;
    }


    public function create() {
        $sql = "INSERT INTO " . $this->table_name . " (nik_pegawai, nama, alamat, jenis_kelamin, password, no_hp, email, id_jenis)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param(
                "ssssssss",
                $this->nik_pegawai,
                $this->nama,
                $this->alamat,
                $this->jenis_kelamin,
                $this->password,
                $this->no_hp,
                $this->email,
                $this->id_jenis
            );
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }    

    public function read(){
        $sql = "SELECT * FROM " .$this->table_view;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function update() {
        $sql = "UPDATE " . $this->table_name . " SET nama = ?, alamat = ?, jenis_kelamin = ?, password = ?, no_hp = ?, email = ?, id_jenis = ?
                WHERE nik_pegawai = ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param(
                "ssssssss",
                $this->nama,
                $this->alamat,
                $this->jenis_kelamin,
                $this->password,
                $this->no_hp,
                $this->email,
                $this->id_jenis,
                $this->nik_pegawai
            );
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);


        // $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $this->nik_pegawai);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByNik($nik_pegawai){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bindValue(1, $nik, PDO::PARAM_STR);
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

    public function getjpegawai(){
        $sql = "SELECT id_jenis, nama FROM " . $this->table_jpegawai;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }
}