<?php
class SiswaModel{
    private $koneksi;
    private $table_name ="tb_siswa";
    private $table_kelas = "tb_kelas";
    private $table_ortu = "tb_orangtua";

    public $nis;
    public $nama;
    public $tanggal_lahir;
    public $tahun_akademik;
    public $jenis_kelamin;
    public $alamat;
    public $password;
    public $nik_ortu;
    public $id_kelas;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create(){
        $sql = "INSERT INTO " . $this->table_name . " (`nis`, `nama`, `tanggal_lahir`, `tahun_akademik`, `password`, `jenis_kelamin`, `alamat`, `id_kelas`, `nik_ortu`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssssssss", $this->nis, $this->nama, $this->tanggal_lahir, $this->tahun_akademik, $this->password, $this->jenis_kelamin, $this->alamat, $this->id_kelas, $this->nik_ortu);
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
            return json_encode($data? $data : ["message" => "Data not found for given NIS"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function update(){
        $sql = "UPDATE " .$this->table_name . " SET nama = '$this->nama', tanggal_lahir = '$this->tanggal_lahir', tahun_akademik = '$this->tahun_akademik', password = '$this->password', jenis_kelamin = '$this->jenis_kelamin', alamat = '$this->alamat', id_kelas = '$this->id_kelas' , nik_ortu = '$this->nik' WHERE nis = '$this->nis'";
        $stmt = $this->koneksi->prepare($sql);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE nis = ?";
        $stmt = $this->koneksi->prepare($sql);

        // $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $this->nis);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByNis($nis){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nis = ?";
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bindValue(1, $nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $nis);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data); 
        } else {
            echo json_encode(["message" => "Data not found for given NIS"]);
        }
    
        $stmt->close();
    }

    public function getkelas(){
        $sql = "SELECT id_kelas, nama_kelas FROM " . $this->table_kelas;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function getortu(){
        $sql = "SELECT nik_ortu, nama FROM " . $this->table_ortu;
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