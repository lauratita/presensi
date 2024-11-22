<?php
class PresensiModel
{
    private $koneksi;
    private $table_name = "tb_presensi";
    private $view_name = "v_presensi_jadwal_siswa";

  
    public $id_presensi ;
    public   $tanggal ;
    public   $jam_datang; 
    public   $jam_pulang;
    public   $valid_foto_datang; 
    public   $valid_foto_pulang;
    public   $id_jadwal;
    public   $nis;
    public   $id_surat;  
    public   $keterangan;  

    public function __construct($db)
    {
        $this->koneksi = $db;
    }

    public function read(){
        $sql = "SELECT * FROM " . $this->view_name;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given NIK"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }
    public function readvpresensi(){
        $sql = "SELECT * FROM " . $this->view_name;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data;
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }
    public function create(){
        $sql = "INSERT INTO " . $this->view_name . "  `tanggal`, `jam_datang`, `jam_pulang`, `valid_foto_datang`, `valid_foto_pulang`, `id_jadwal`, `nis`, `id_surat`, `keterangan`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssiisss", $this->tanggal, $this->jam_datang, $this->jam_pulang, $this->valid_foto_datang,
             $this->valid_foto_pulang, $this->id_jadwal, $this->nis, $this->id_surat, $this->keterangan);
            if ($stmt->execute()) {
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
           return false;
        }
    }
    public function update(){
        $sql = "UPDATE `tb_presensi` SET `tanggal` = ?,`jam_datang`= ?,`jam_pulang`= ?,`valid_foto_datang`= ?,
        `valid_foto_pulang`= ?,`id_jadwal`= ?,`nis`= ?,`id_surat`= ?,`keterangan`= ? WHERE `id_presensi`= ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssiisss", $this->tanggal, $this->jam_datang, $this->jam_pulang, $this->valid_foto_datang, 
            $this->valid_foto_pulang, $this->id_jadwal, $this->nis, $this->id_surat, $this->keterangan, $this->id_presensi);
            if ($stmt->execute()) {
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
           return false;
        }
    }
    public function delete(){
        $sql = "DELETE FROM " .$this->view_name . " WHERE id_presensi = ?";
        $stmt = $this->koneksi->prepare($sql);

        // $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $this->id_presensi);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}