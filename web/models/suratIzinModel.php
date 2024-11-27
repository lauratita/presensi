<?php
class SuratIzinModel
{
    private $koneksi;
    private $view_name = "v_suratizin";
    private $table_name = "tb_suratizin";

    public $nik_pegawai;
    public $nis;
    public $nama_siswa;
    public $keterangan;
    public $tanggal;
    public $foto_surat;
    public $status;
    public $nik_ortu;
    public $id_kelas;
    public $id_surat;

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

    public function create()
    {
        $sql = "INSERT INTO " . $this->table_name . " (`keterangan`, `status`, `tanggal`, `foto_surat`, `nik_ortu`, `nik_pegawai`)
                VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssssss", $this->keterangan, $this->status, $this->tanggal, $this->foto_surat, $this->nik_ortu, $this->nik_pegawai);
            if ($stmt->execute()) {
                return ["status" => true, "message" => "Berhasil menambahkan surat izin."];
            } else {
                return ["status" => false, "message" => "Gagal menambahkan surat izin."];
            }
        } catch (Exception $e) {
            return ["status" => false, "message" => "Terjadi kesalahan: " . $e->getMessage()];
        }
    }

    public function getByWaliKelas($nik_pegawai, $status)
    {
        $sql = "SELECT * FROM " . $this->view_name . " WHERE nik_pegawai = ? AND status = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $nik_pegawai, $status);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
        // $stmt->close();
    }

    public function update($status, $id_surat, $nis, $nik_ortu, $nik_pegawai)
    {
        // UPDATE v_suratizin_ket SET status = 'verified' WHERE v_suratizin_ket.id_surat = '1' AND v_suratizin_ket.nis = 'pplg2303';
        $sql = "UPDATE " . $this->view_name . " SET status = ? WHERE id_surat = ? AND nis = ? AND nik_ortu AND id_kelas = ? AND nik_pegawai = ?";
        try {
            $updateStmt = $this->koneksi->prepare($sql);
            $updateStmt->bind_param("ssss", $status, $id_surat, $nis, $nik_ortu, $nik_pegawai);
            if ($updateStmt->execute()) {
                return ["status" => true, "message" => "Surat Izin Berhasil Verifikasi"];
            } else {
                return ["status" => false, "message" => "Gagal Verifikasi Surat Izin"];
            }
        } catch (Exception $e) {
            return ["status" => false, "message" => "Terjadi kesalahan: " . $e->getMessage()];
        }
    }
}