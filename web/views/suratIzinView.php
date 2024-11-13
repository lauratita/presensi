<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/suratIzinModel.php';

class suratIzinView
{
    private $koneksi;
    public function __construct($db)
    {
        $this->koneksi = $db;
    }
    
    public function tampilSuratIzin($data, $status) 
    {
        if (!empty($data)) {
            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered" width="100%" cellspacing="0">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>No</th>';
            echo '<th>NIS</th>';
            echo '<th>Nama</th>';
            echo '<th>Keterangan</th>';
            echo '<th>Status</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            $no = 1;
            foreach ($data as $surat) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . $surat['nis'] . '</td>';
                echo '<td>' . $surat['nama'] . '</td>';
                echo '<td>' . $surat['keterangan'] . '</td>';
                echo '<td><span class="badge bg-label-warning">' . ucfirst($surat['status']) . '</span></td>';
                echo '<td>';
                echo '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal' . $surat['id_surat'] . '">View</button>';
                echo '</td>';
                echo '</tr>';
                // Modal for each entry
                echo '<div class="modal fade" id="modal' . $surat['id_surat'] . '" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="modalLabel">Detail Surat Izin</h5>';
                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<h6>NIS: ' . $surat['nis'] . '</h6>';
                echo '<h6>Nama: ' . $surat['nama'] . '</h6>';
                echo '<h6>Keterangan: ' . $surat['keterangan'] . '</h6>';
                echo '<h6>Status: ' . ucfirst($surat['status']) . '</h6>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p class="text-muted">Tidak ada data untuk status ' . ucfirst($status) . '.</p>';
        }
    }

}