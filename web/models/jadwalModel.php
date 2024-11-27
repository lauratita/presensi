<?php
class JadwalModel{
    private $koneksi;
    private $table_name ="v_detail_jadwal_mapel_new";


    public function __construct($db){
        $this->koneksi = $db;
    }

    public function read(){
        $sql = "SELECT * FROM " . $this->table_name;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }
    
}