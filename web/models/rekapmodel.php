<?php

class RekapModel
{
    private $koneksi;
    private $view_name = "v_rekap";


    public $nis;
    public $nama;
    public $keterangan;
    public $jam_datang;
    public $jam_pulang;
    public $tanggal;

    public function __construct($db)
    {
        $this->koneksi = $db;
    }

    public function readvrekap(){
        $sql = "SELECT * FROM " . $this->view_name;
        $result = $this->koneksi->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    

    }

    public function rekapByWaliKelas($nik_pegawai)
    {
        $sql = "SELECT * FROM " . $this->view_name . " WHERE nik_pegawai = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nik_pegawai);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }    
        
}


 
    
    