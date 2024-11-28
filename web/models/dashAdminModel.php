<?php

class DashboardAdminModel
{
    private $koneksi;
    private $table_kelas = "tb_kelas";
    private $table_siswa = "tb_siswa";
    private $table_pegawai = "tb_pegawai";

    public function __construct($db)
    {
        $this->koneksi = $db;
    }

    public function getJumlahSiswa()
    {
        // SELECT COUNT(*) AS total FROM tb_siswa;
        $sql = "SELECT COUNT(*) AS total_siswa 
        FROM " . $this->table_siswa;
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bind_param('s');
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc(); // Ambil satu baris data
            return json_encode($data); 
        } else {
            return json_encode(["message" => "Data not found for"]);
        }

        $stmt->close();
    }
    
    public function getJumlahKelas()
    {
        // SELECT COUNT(*) AS total_surat FROM tb_kelas; 
        $sql = "SELECT COUNT(*) AS total_kelas FROM " . $this->table_kelas;
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bind_param("s"); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc(); // Ambil satu baris data
            return json_encode($data); 
        } else {
            return json_encode(["message" => "Data not found"]);
        }

        $stmt->close();
    }
    
    public function getJumlahPegawai()
    {
        // SELECT COUNT(*) AS total_pegawai FROM tb_pegawai; 
        $sql = "SELECT COUNT(*) AS total_pegawai FROM " . $this->table_pegawai;
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bind_param("s"); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc(); // Ambil satu baris data
            return json_encode($data); 
        } else {
            return json_encode(["message" => "Data not found"]);
        }

        $stmt->close();
    }

    public function getJumlahPresensiHariIni()
    {
        // SELECT SUM(CASE WHEN status = 'unverified' THEN 1 ELSE 0 END) AS unverified, SUM(CASE WHEN status = 'verified' 
        // THEN 1 ELSE 0 END) AS verified, SUM(CASE WHEN status = 'disable' THEN 1 ELSE 0 END) AS disable FROM v_suratizin 
        // WHERE DATE(tanggal) = CURDATE() AND nik_pegawai = '6611552244';
        $sql = "SELECT SUM(CASE WHEN p.keterangan = 'hadir' THEN 1 ELSE 0 END) AS hadir, 
        SUM(CASE WHEN p.keterangan = 'izin' THEN 1 ELSE 0 END) AS izin, 
        SUM(CASE WHEN p.keterangan = 'sakit' THEN 1 ELSE 0 END) AS sakit, 
        SUM(CASE WHEN p.keterangan = 'alpa' THEN 1 ELSE 0 END) AS alpa 
        FROM tb_presensi p JOIN tb_siswa s ON p.nis = s.nis
        WHERE DATE(p.tanggal) = CURDATE()";
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bind_param("s");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return ["hadir" => 0, "izin" => 0, "sakit" => 0, "alpha" => 0];
        }
    }
    
}