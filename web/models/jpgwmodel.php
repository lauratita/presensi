<?php
class jpgwModel{
    private $koneksi;
    private $table_name ="tb_jenispegawai";

    public $idJenis;
    public $nama;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create(){
        $sql = "INSERT INTO " . $this->table_name . " (nama) VALUES (?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("s", $this->nama);
            if ($stmt->execute()) {
                return true;
            } else{
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

    public function update($id_jenis, $nama){
        $sql = "UPDATE " . $this->table_name . " SET nama = ? WHERE id_jenis = ?";
        $stmt = $this->koneksi->prepare($sql);
        if ($stmt->execute([$nama, $id_jenis])) {
            return true;
        }
        return false;
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE id_jenis = ?";
        $stmt = $this->koneksi->prepare($sql);

        $stmt->bind_param("s", $this->idJenis);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByIdJenis($idJenis){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_jenis = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $idJenis);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data); 
        } else {
            echo json_encode(["message" => "Data not found for given ID"]);
        }
    
        $stmt->close();
    }
}
