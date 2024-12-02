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
        $sql = "SELECT * FROM " . $this->view_name. " WHERE DATE(tanggal) = CURDATE()";
        $result = $this->koneksi->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function getById(String $nis){
        $sql = "SELECT * FROM " . $this->table_name. " WHERE nis = '$nis'";
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given NIK"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }
    
    public function create($tanggal, $jam_datang, $jam_pulang, $nis, $id_surat, $keterangan, $id_kelas) {
        $hariIni = date('l');
        $hariMapping = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $hari = $hariMapping[$hariIni]; 
    
        $jadwalSql = "SELECT * FROM `v_detail_jadwal_mapel`
                    WHERE id_kelas = ? AND hari = ?";
        $jadwalStmt = $this->koneksi->prepare($jadwalSql);
        $jadwalStmt->bind_param("ss", $id_kelas, $hari);
        $jadwalStmt->execute();
        $jadwalResult = $jadwalStmt->get_result();
        $jadwal = $jadwalResult->fetch_assoc();
        if (!$jadwal || !$jadwal['jam_masuk']) {
            return ["status" => false, "message" => "Jadwal masuk untuk hari ini tidak ditemukan."];
        }
    
        // Hitung batas keterlambatan (jam_masuk + 5 menit)
        $jamMasuk = $jadwal['jam_masuk'];
        $batasTerlambat = date('H:i:s', strtotime($jamMasuk . ' +5 minutes'));
        // Validasi keterlambatan
        if ($jam_datang > $batasTerlambat) {
            return ["status" => false, "message" => "Anda terlambat, absen masuk hanya berlaku hingga $batasTerlambat."];
        }
    
        // Validasi jika data sudah ada
        $checkSql = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE tanggal = ? AND nis = ?";
        $checkStmt = $this->koneksi->prepare($checkSql);
        $checkStmt->bind_param("ss", $tanggal, $nis);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $row = $checkResult->fetch_assoc();
    
        if ($row['count'] > 0) {
            return ["status" => false, "message" => "Anda sudah melakukan absen masuk pada tanggal ini."];
        }
    
        // Proses insert data
        $sql = "INSERT INTO " . $this->table_name . " (`tanggal`, `jam_datang`, `jam_pulang`, `nis`, `id_surat`, `keterangan`, `id_kelas`)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssssss", $tanggal, $jam_datang, $jam_pulang, $nis, $id_surat, $keterangan, $id_kelas);
            if ($stmt->execute()) {
                return ["status" => true, "message" => "Berhasil melakukan absen."];
            } else {
                return ["status" => false, "message" => "Gagal menambahkan data."];
            }
        } catch (Exception $e) {
            return ["status" => false, "message" => "Terjadi kesalahan: " . $e->getMessage()];
        }
    }
    
    public function absenPulang($tanggal, $jam_pulang, $nis, $id_kelas) {
        // Cek apakah data absen masuk sudah ada
        $checkSql = "SELECT jam_pulang FROM " . $this->table_name . " WHERE tanggal = ? AND nis = ? AND id_kelas = ?";
        $checkStmt = $this->koneksi->prepare($checkSql);
        $checkStmt->bind_param("sss", $tanggal, $nis, $id_kelas);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $row = $checkResult->fetch_assoc();
    
        if (!$row) {
            return ["status" => false, "message" => "Data absen masuk tidak ditemukan untuk tanggal ini."];
        }
    
        // Validasi apakah jam_pulang sudah diisi
        if (!empty($row['jam_pulang'])) {
            return ["status" => false, "message" => "Anda sudah melakukan absen pulang sebelumnya."];
        }
    
        // Ambil jadwal berdasarkan kelas dan hari
        $hariIni = date('l');
        $hariMapping = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $hari = $hariMapping[$hariIni];
    
        $jadwalSql = "SELECT jam_pulang FROM `v_detail_jadwal_mapel`
                    WHERE id_kelas = ? AND hari = ?";
        $jadwalStmt = $this->koneksi->prepare($jadwalSql);
        $jadwalStmt->bind_param("ss", $id_kelas, $hari);
        $jadwalStmt->execute();
        $jadwalResult = $jadwalStmt->get_result();
        $jadwal = $jadwalResult->fetch_assoc();
    
        if (!$jadwal || !$jadwal['jam_pulang']) {
            return ["status" => false, "message" => "Jadwal pulang untuk hari ini tidak ditemukan."];
        }
    
        // Hitung batas keterlambatan (jam_pulang + 30 menit)
        $jamPulangJadwal = $jadwal['jam_pulang'];
        $batasTerlambat = date('H:i:s', strtotime($jamPulangJadwal . ' +5 minutes'));
    
        // Validasi jika melewati batas keterlambatan
        if ($jam_pulang > $batasTerlambat) {
            return ["status" => false, "message" => "Anda terlambat, absen pulang hanya berlaku hingga $batasTerlambat."];
        }
    
        // Lakukan update jam_pulang
        $updateSql = "UPDATE " . $this->table_name . " SET jam_pulang = ? WHERE tanggal = ? AND nis = ? AND id_kelas = ?";
        try {
            $updateStmt = $this->koneksi->prepare($updateSql);
            $updateStmt->bind_param("ssss", $jam_pulang, $tanggal, $nis, $id_kelas);
            if ($updateStmt->execute()) {
                return ["status" => true, "message" => "Berhasil Melakukan Absen Pulang"];
            } else {
                return ["status" => false, "message" => "Gagal Melakukan Absen Pulang"];
            }
        } catch (Exception $e) {
            return ["status" => false, "message" => "Terjadi kesalahan: " . $e->getMessage()];
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

    public function getByWaliKelasHariIni($nik_pegawai)
    {
        $sql = "SELECT * FROM " . $this->view_name . " WHERE nik_pegawai = ? AND DATE(tanggal) = CURDATE()";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nik_pegawai);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
        // $stmt->close();
    }

}