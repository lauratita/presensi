<?php
class OrtuModel{
    private $koneksi;
    private $table_name ="tb_orangtua";

    public $nik;
    public $nama;
    public $alamat;
    public $no_hp;
    public $jenis_kelamin;
    public $email;
    public $password;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create(){
        $sql = "INSERT INTO " . $this->table_name . " (`nik_ortu`, `nama`, `alamat`, `no_hp`, `jenis_kelamin`, `email`, `password`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssssss", $this->nik, $this->nama, $this->alamat, $this->no_hp, $this->jenis_kelamin, $this->email, $this->password);
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
            return json_encode($data? $data : ["message" => "Data not found for given NIK"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function update(){
        $sql = "UPDATE " .$this->table_name . " SET nama = '$this->nama', alamat = '$this->alamat', no_hp = '$this->no_hp', jenis_kelamin = '$this->jenis_kelamin', email = '$this->email', password = '$this->password' WHERE nik_ortu = '$this->nik'";
        $stmt = $this->koneksi->prepare($sql);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);

        // $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $this->nik);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByNik($nik){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bindValue(1, $nik, PDO::PARAM_STR);
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