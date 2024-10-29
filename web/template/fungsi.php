<?php
class Fungsi {
    protected $ci;

    public function count_siswa(){
        $this->ci->load->model('siswa');
        return $this->ci->siswa->get()->num_rows();
    } 
    public function count_surat(){
        $this->ci->load->model('surat_izin');
        return $this->ci->surat_izin->get()->num_rows();
    } 
}