<?php
class PresensiModel
{
    private $koneksi;
    private $table_name = "tb_presensi";
    private $view_name = "v_presensi";

  
    public   $id_presensi ;
    public   $tanggal ;
    public   $jam_datang; 
    public   $jam_pulang;
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
//     public function readvpresensi(){
//         $sql = "SELECT * FROM " . $this->view_name Where tanggal = today();
//         $result = $this->koneksi->query($sql);
//         if ($result->num_rows > 0) {
//             $data = $result->fetch_all(MYSQLI_ASSOC);
//             return $data;
//         } else {
//             http_response_code(404);
//             return json_encode(["message" => "Data not found"]);
//         }
//     }
        public function readvpresensi() {
            // Menyusun query dengan benar
            $sql = "SELECT * FROM " . $this->view_name . " WHERE tanggal = CURDATE()";
            
            // Menjalankan query
            $result = $this->koneksi->query($sql);
            
            // Mengecek apakah data ditemukan
            if ($result->num_rows > 0) {
                // Mengambil semua data dalam bentuk array asosiatif
                $data = $result->fetch_all(MYSQLI_ASSOC);
                return $data;
            } else {
                // Mengembalikan error jika tidak ada data
                http_response_code(404);
                return json_encode(["message" => "Data not found"]);
            }
        }

    public function create(){
        $sql = "INSERT INTO " . $this->view_name . "  `tanggal`, `jam_datang`, `jam_pulang`, `id_jadwal`, `nis`, `id_surat`, `keterangan`)
                                                    VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssiisss", $this->tanggal, $this->jam_datang, $this->jam_pulang, $this->id_jadwal, $this->nis, $this->id_surat, $this->keterangan);
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
        $sql = "UPDATE `tb_presensi` SET `tanggal` = ?,`jam_datang`= ?,`jam_pulang`= ?,`id_jadwal`= ?,`nis`= ?,`id_surat`= ?,`keterangan`= ? WHERE `id_presensi`= ?";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssiisss", $this->tanggal, $this->jam_datang, $this->jam_pulang, $this->id_jadwal, $this->nis, $this->id_surat, $this->keterangan, $this->id_presensi);
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