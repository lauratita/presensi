<?php
class KelasModel{
    private $koneksi;
    private $table_name ="tb_kelas";
    private $v_table = "v_wali_kelas";
    private $table_pegawai = "tb_pegawai";

    public $id_kelas;
    public $nama_kelas;
    public $nik_pegawai;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create(){
        $result = $this->koneksi->query("SELECT MAX(id_kelas) AS max_id FROM " . $this->table_name);
            if ($result) {
                $row = $result->fetch_assoc();
                $max_id = $row['max_id'] ?? 'KLS000';
                $new_id = 'KLS' . str_pad(((int) substr($max_id, 3)) + 1, 3, '0', STR_PAD_LEFT);
            } else {
                return false;
            }

        $sql = "INSERT INTO " . $this->table_name . " (`id_kelas`, `nama_kelas`, `nik_pegawai`)
                                                    VALUES (?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sss", $new_id, $this->nama_kelas, $this->nik_pegawai);
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
        $sql = "SELECT * FROM " .$this->v_table;
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
        $sql = "UPDATE " . $this->table_name . " SET nama_kelas = ?, nik_pegawai = ? WHERE id_kelas = ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sss", $this->nama_kelas, $this->nik_pegawai, $this->id_kelas);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE id_kelas = ?";
        $stmt = $this->koneksi->prepare($sql);

        // $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $this->id_kelas);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getById($id_kelas){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_kelas = ?";
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bindValue(1, $nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $id_kelas);
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

    // public function getpegawai(){
    //     $sql = "SELECT nik_pegawai, nama FROM " . $this->table_pegawai . " WHERE id_jenis = 2 
    //     AND nik_pegawai NOT IN (SELECT nik_pegawai FROM " . $this->table_name.")";
    //     $result = $this->koneksi->query($sql);
    //     if ($result->num_rows > 0) {
    //         $data = $result->fetch_all(MYSQLI_ASSOC);
    //         return json_encode($data? $data : ["message" => "Data not found for given ID"]);
    //     } else {
    //         http_response_code(404);
    //         return json_encode(["message" => "Data not found"]);
    //     }
    // }

    public function getPegawaiUntukTambah() {
        $sql = "SELECT nik_pegawai, nama FROM " . $this->table_pegawai . " 
                WHERE id_jenis = 2 
                AND nik_pegawai NOT IN (SELECT nik_pegawai FROM " . $this->table_name . ")";
        $result = $this->koneksi->query($sql);
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    // public function getPegawaiUntukEdit($id_kelas) {
    //     $sql = "SELECT p.nik_pegawai, p.nama 
    //             FROM " . $this->table_pegawai . " p
    //             LEFT JOIN " . $this->table_name . " k ON p.nik_pegawai = k.nik_pegawai 
    //             WHERE p.id_jenis = 2 
    //             AND (k.id_kelas IS NULL OR k.id_kelas = ?)";
    //     $stmt = $this->koneksi->prepare($sql);
    //     $stmt->bind_param("i", $id_kelas);  // Bind id_kelas untuk mengedit
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    
    //     if ($result->num_rows > 0) {
    //         $data = $result->fetch_all(MYSQLI_ASSOC);
    //         return json_encode($data);
    //     } else {
    //         http_response_code(404);
    //         return json_encode(["message" => "Data not found"]);
    //     }
    // }
    
    
    
}