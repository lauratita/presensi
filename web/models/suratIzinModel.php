<?php
class SuratIzinModel
{
    private $koneksi;
    private $view_name = "v_suratizin_ket";

    public $nik_pegawai;
    public $nis;
    public $nama_siswa;
    public $keterangan;
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

    public function getByWaliKelas($nik_pegawai)
    {
        $sql = "SELECT * FROM " . $this->view_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ss", $nik_pegawai);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data); 
        } else {
            echo json_encode(["message" => "Data not found for given NIK Pegawai"]);
        }
    
        $stmt->close();
    }

    public function update()
    {
        // UPDATE `v_suratizin_ket` SET `status` = 'verified' WHERE `v_suratizin_ket`.`id_surat` = '1' AND `v_suratizin_ket`.`nis` = 'pplg2303';
        $sql = "UPDATE " . $this->view_name . " SET status = '$this->status' WHERE id_surat = '$this->id_surat' AND nis = '$this->nis'";
        $stmt = $this->koneksi->prepare($sql);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}