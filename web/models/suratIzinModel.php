<?php
class SuratIzinModel
{
    private $koneksi;

    public function __construct($db)
    {
        $this->koneksi = $db;
    }

    public function getSuratIzinByWaliKelas($nik_pegawai, $status)
    {
        $sql = "SELECT si.id_surat, si.keterangan, si.status, si.tanggal, si.foto_surat, s.nis, s.nama
                  FROM tb_suratizin si
                  JOIN tb_orangtua o ON si.nik_ortu = o.nik_ortu
                  JOIN tb_siswa s ON o.nik_ortu = s.nik_ortu
                  JOIN tb_kelas k ON s.id_kelas = k.id_kelas
                  WHERE k.nik_pegawai = ? AND si.status = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param('ss', $nik_pegawai, $status);
        $stmt->execute();
        // $result = $stmt->get_result();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatusSuratIzin($id_surat, $new_status)
    {
        $sql = "UPDATE tb_suratizin SET status = ? WHERE id_surat = ?";
        $stmt = $this->koneksi->prepare($sql);
        return $stmt->execute([$new_status, $id_surat]);
    }
}