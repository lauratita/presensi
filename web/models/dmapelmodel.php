<?php
class dmapelModel{
    private $koneksi;
    private $table_name ="detail_jadwal_mapel";
    private $table_view ="v_jadwal_mapel_detail";
    private $table_kelas = "tb_kelas";
    private $table_mapel = "tb_mapel";
    private $table_guru = "tb_pegawai";

    public $id_jadwal_mapel;
    public $hari;
    public $jam_awal;
    public $jam_akhir;
    public $id_kelas;
    public $kd_mapel;
    public $nik_pegawai;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create() {
        $sql = "INSERT INTO " . $this->table_name . " (hari, jam_awal, jam_akhir, id_kelas, kd_mapel, nik_pegawai)
                VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param(
                "ssssss",
                $this->hari,
                $this->jam_awal,
                $this->jam_akhir,
                $this->id_kelas,
                $this->kd_mapel,
                $this->nik_pegawai
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
        $sql = "UPDATE " . $this->table_name . " SET hari = ?, jam_awal = ?, jam_akhir = ?, id_kelas = ?, kd_mapel = ?, nik_pegawai = ?
                WHERE id_jadwal_mapel = ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param(
                "sssssss", 
                $this->hari,
                $this->jam_awal,
                $this->jam_akhir,
                $this->id_kelas,
                $this->kd_mapel,
                $this->nik_pegawai,
                $this->id_jadwal_mapel 
            );
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE id_jadwal_mapel = ?";
        $stmt = $this->koneksi->prepare($sql);


        // $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $this->id_jadwal_mapel);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByID($id_jadwal_mapel) {
        $sql = "SELECT * FROM detail_jadwal_mapel WHERE id_jadwal_mapel = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $id_jadwal_mapel);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return json_encode($data); // Mengembalikan JSON
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

    public function getmapel(){
        $sql = "SELECT kd_mapel, nama FROM " . $this->table_mapel;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function getguru(){
        $sql = "SELECT nik_pegawai, nama FROM " . $this->table_guru . " WHERE id_jenis = '2'";
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