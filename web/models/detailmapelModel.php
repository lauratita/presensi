<?php
class DetailMapelModel{
    private $koneksi;
    private $table_name ="v_detail_mapel";
    
    public $id_kelas;

    public function __construct($db){
        $this->koneksi = $db;
    }

    
    public function getByIdKelas($id_kelas){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_kelas = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $id_kelas);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data); 
        } else {
            echo json_encode(["message" => "Data not found for given NIK"]);
        }
    
        $stmt->close();
    }
    

}