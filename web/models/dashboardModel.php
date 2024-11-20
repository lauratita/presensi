<?php

class DashboardModel
{
    private $koneksi;
    private $table_presensi = "v_surat";
    private $table_siswa = "tb_siswa";

    public function __construct($db)
    {
        $this->koneksi = $db;
    }

    public function getJumlahSiswa($nik_pegawai)
    {
        // SELECT COUNT(*) AS total FROM tb_siswa JOIN tb_kelas 
        // ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE tb_kelas.nik_pegawai = '0987654321';
        $sql = "SELECT COUNT(*) AS statistik_siswa 
        FROM " . $this->table_siswa . " 
        JOIN tb_kelas 
        ON tb_siswa.id_kelas = tb_kelas.id_kelas 
        WHERE tb_kelas.nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nik_pegawai); // Perbaikan: hanya satu "s"
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc(); // Ambil satu baris data
            return json_encode($data); 
        } else {
            return json_encode(["message" => "Data not found for given NIK"]);
        }

        $stmt->close();
    }
    
    public function getJumlahSurat($nik_pegawai)
    {
        // SELECT COUNT(*) AS statistik_surat FROM v_surat WHERE nik_pegawai = '0987654321'; 
        $sql = "SELECT COUNT(*) AS statistik_surat FROM " . $this->table_presensi . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nik_pegawai); // Perbaikan: hanya satu "s"
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc(); // Ambil satu baris data
            return json_encode($data); 
        } else {
            return json_encode(["message" => "Data not found for given NIK"]);
        }

        $stmt->close();
    }
}