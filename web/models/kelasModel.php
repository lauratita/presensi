<?php
class KelasModel{
    private $koneksi;
    private $table_name ="tb_kelas";
    private $v_table = "v_wali_kelas";
    private $table_pegawai = "tb_pegawai";

    private $table_jenis = "tb_jeniskelas";

    private $table_jurusan = "tb_jurusan";

    public $id_kelas;
    public $nama_kelas;
    public $nik_pegawai;
    public $idjenis;
    
    public $jurusan;

    public $jenis_kelas;

    public $nama_jurusan;
    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create(): bool {
        // Mengambil ID kelas terakhir
        $result = $this->koneksi->query("SELECT MAX(id_kelas) AS max_id FROM " . $this->table_name);
        if ($result) {
            $row = $result->fetch_assoc();
            $max_id = $row['max_id'] ?? 'KLS000';
            $new_id = 'KLS' . str_pad(((int) substr($max_id, 3)) + 1, 3, '0', STR_PAD_LEFT);
        } else {
            return false;
        }
    
        // Ambil nama jenis kelas dan jurusan
        $query = "SELECT j.kelas, k.nama_jurusan 
                  FROM " . $this->table_jenis . " j
                  JOIN " . $this->table_jurusan . " k 
                  ON j.id_jeniskelas = ? AND k.id_jurusan = ?";
        $stmt = $this->koneksi->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ii", $this->idjenis, $this->jurusan);
            $stmt->execute();
    
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $jenis_kelas = $row['kelas'];
                $nama_jurusan = $row['nama_jurusan'];
                $this->nama_kelas = $jenis_kelas . " " . $nama_jurusan;
            } else {
                return false; // Jika data tidak ditemukan
            }
              
        } else {
            return false;
        }
    
        // Masukkan data kelas baru
        $sql = "INSERT INTO " . $this->table_name . " 
                (`id_kelas`, `nama_kelas`, `id_jeniskelas`, `id_jurusan`, `nik_pegawai`) 
                VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ssiis", $new_id, $this->nama_kelas, $this->idjenis, $this->jurusan, $this->nik_pegawai);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
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

    public function getAll(){
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
        $query = "SELECT j.kelas, k.nama_jurusan 
        FROM " . $this->table_jenis . " j
        JOIN " . $this->table_jurusan . " k 
        ON j.id_jeniskelas = ? AND k.id_jurusan = ?";
        $stmt = $this->koneksi->prepare($query);
        if ($stmt) {
        $stmt->bind_param("ii", $this->jenis_kelas, $this->jurusan);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->nama_kelas = $row['kelas'] . " " . $row['nama_jurusan'];
        } else {
            return false; // Data jenis kelas atau jurusan tidak ditemukan
        }
        } else {
            return false; // Gagal menjalankan query
        }
        $sql = "UPDATE " . $this->table_name . " SET nama_kelas = ?, id_jeniskelas = ?, id_jurusan = ?, nik_pegawai = ? WHERE id_kelas = ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("siiss", $this->nama_kelas, $this->jenis_kelas, $this->jurusan, $this->nik_pegawai, $this->id_kelas);
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
        // $sql = "SELECT nik_pegawai, nama FROM " . $this->table_pegawai . " 
        //         WHERE id_jenis = 2 
        //         AND nik_pegawai NOT IN (SELECT nik_pegawai FROM " . $this->table_name . ")";
        $sql = "SELECT p.nama, p.nik_pegawai 
        FROM " . $this->table_pegawai . " p
        LEFT JOIN " . $this->table_name . " k ON p.nik_pegawai = k.nik_pegawai
        WHERE p.id_jenis = 2 AND k.id_kelas IS NULL";
        $result = $this->koneksi->query($sql);
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    
    public function getPegawaiUntukEdit($id_kelas) {
        $sql = "
            SELECT nik_pegawai, nama 
            FROM " . $this->table_pegawai . " 
            WHERE id_jenis = 2 
            AND nik_pegawai NOT IN (SELECT nik_pegawai FROM " . $this->table_name . " WHERE id_kelas != ?)
            
            UNION
            
            SELECT nik_pegawai, nama 
            FROM " . $this->table_pegawai . " 
            WHERE id_jenis = 2 
            AND nik_pegawai = (SELECT nik_pegawai FROM " . $this->table_name . " WHERE id_kelas = ?)
        ";
    
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $id_kelas, $id_kelas);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }
    
    public function getjeniskelas(){
        $sql = "SELECT id_jeniskelas, kelas FROM " . $this->table_jenis;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function getjurusan(){
        $sql = "SELECT id_jurusan, nama_jurusan FROM " . $this->table_jurusan;
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