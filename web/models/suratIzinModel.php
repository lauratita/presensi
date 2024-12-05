<?php
class SuratIzinModel
{
    private $koneksi;
    private $view_name = "v_suratizin";
    private $table_name = "tb_suratizin";
    private $table_siswa = "tb_siswa";

    public $nik_pegawai;
    public $nis;
    public $nama_siswa;
    public $keterangan;
    public $tanggal;
    public $tenggat;
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
        $sql = "INSERT INTO " . $this->table_name . 
        " (`keterangan`, `status`, `tanggal`, `tenggat`, `foto_surat`, `nik_ortu`, `nik_pegawai`, `nis`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ssssssss",
             $this->keterangan, $this->status, $this->tanggal, $this->tenggat, $this->foto_surat, $this->nik_ortu, $this->nik_pegawai, $this->nis);
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
    
    public function getSiswaByNIKOrtu($nik_ortu) 
    {
       /* SELECT 
            s.nis,
            s.nama AS nama_siswa,
            s.tanggal_lahir,
            s.tahun_akademik,
            s.jenis_kelamin,
            s.alamat,
            s.foto,
            s.nik_ortu,
            k.nama_kelas,
            k.nik_pegawai
        FROM 
            tb_siswa s
        LEFT JOIN 
            tb_kelas k
        ON 
            s.id_kelas = k.id_kelas
        WHERE 
            s.nik_ortu = '1237646';*/
        $query = "SELECT nis, nama AS nama_siswa, nik_ortu, nama_kelas, nik_pegawai FROM tb_siswa
                    JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("s", $nik_ortu);
        $stmt->execute();
        $result = $stmt->get_result();
        $siswa = [];
        while ($row = $result->fetch_assoc()) {
            $siswa[] = $row;
        }
        
        return $siswa;
    }

    public function getSuratIzinByOrtu($nik_ortu)
    {
        $sql = "SELECT * FROM " . $this->view_name . " WHERE nik_ortu = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nik_ortu);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function update()
    {
        // UPDATE tb_suratizin SET status = 'verified' WHERE id_surat = ?';
        $sql = "UPDATE " . $this->table_name . " SET status = ? WHERE id_surat = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param('si', $this->status, $this->id_surat);
        if ($stmt->execute()) {
            return ["message" => "Status surat izin berhasil diperbarui"];
        } else {
            return ["message" => "Gagal memperbarui status surat izin"];
        }
    }
}