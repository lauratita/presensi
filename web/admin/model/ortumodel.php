<?php
class OrtuModel{
    private $koneksi;
    private $table_name ="tb_ortu";

    public $nik;
    public $nama;
    public $email;
    public $password;
    public $no_hp;
    public $alamat;
    public $jenis_kelamin;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function create(){
        $sql = "INSERT INTO " . $this->table_name . " (`nik`, `nama`, `email`, `password`, `no_hp`, `alamat`, `jenis_kelamin`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->koneksi->prepare($sql);
        $stmt ->bind_param("sssssss", $this->nik, $this->nama, $this->email, $this->password, $this->no_hp, $this->alamat, $this->jenis_kelamin);
        if ($stmt->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public function read(){
        $sql = "SELECT * FROM " .$this->table_name;
        $stmt = $this->koneksi->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function update(){
        $sql = "UPDATE" .$this->table_name . " SET nama = ?, email = ?, password = ?, no_hp = ?, alamat = ?, jenis_kelamin = ? WHERE nik = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("sssssss", $nama, $email, $password, $no_hp, $alamat, $jenis_kelamin, $nik);
        // $stmt->bindParam(":nama", $this->nama);
        // $stmt->bindParam(":email", $this->email); 
        // $stmt->bindParam(":password", $this->password);

        // $stmt->bindParam(":alamat", $this->alamat);
        // $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);
        // $stmt->bindParam(":nik", $this->nik);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE nik = ?";
        $stmt = $this->koneksi->prepare($sql);

        $stmt->bind_param("s", $this->nik);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByNik(){
        $sql = "SELECT * FROM" . $this->table_name . " WHERE nik = ?";
        $stmt = $this->koneksi->prepare($sql);

        $stmt->bind_param("s", $nik);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}