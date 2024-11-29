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
        
    }


 
    
    