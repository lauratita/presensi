<?php
class OrtuModel{
    private $con;
    private $table_name ="tb_ortu";

    public $nik;
    public $nama;
    public $email;
    public $password;
    public $no_hp;
    public $alamat;
    public $jenis_kelamin;

    public function __construct($db){
        $this->con = $db;
    }

    public function create(){
        $sql = "INSERT INTO " . $this->table_name . " (`nik`, `nama`, `email`, `password`, `no_hp`, `alamat`, `jenis_kelamin`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->nama, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->email, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->password, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->no_hp, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->alamat, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->jenis_kelamin, PDO::PARAM_STR);
        // $stmt->bind_param("sssssss", $this->nik, $this->nama, $this->email, $this->password, $this->no_hp, $this->alamat, $this->jenis_kelamin);
        if ($stmt->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public function read(){
        $sql = "SELECT * FROM " .$this->table_name;
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function update(){
        $sql = "UPDATE " .$this->table_name . " SET nama = ?, email = ?, password = ?, no_hp = ?, alamat = ?, jenis_kelamin = ? WHERE nik = ?";
        $stmt = $this->con->prepare($sql);
        
        $stmt->bindValue(1, $this->nama, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->email, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->password, PDO::PARAM_STR);
        $stmt->bindValue(4, $this->no_hp, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->alamat, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->jenis_kelamin, PDO::PARAM_STR);
        $stmt->bindValue(7, $this->nik, PDO::PARAM_STR);
        // $stmt->bind_param("sssssss", $nama, $email, $password, $no_hp, $alamat, $jenis_kelamin, $nik);
        // $stmt->bindParam(":nama", $this->nama);
        // $stmt->bindParam(":email", $this->email); 
        // $stmt->bindParam(":password", $this->password);

        // $stmt->bindParam(":alamat", $this->alamat);
        // $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);
        // $stmt->bindParam(":nik", $this->nik);
        var_dump($sql);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE nik = ?";
        $stmt = $this->con->prepare($sql);

        $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByNik($nik){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nik = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(1, $nik, PDO::PARAM_STR);
        $stmt->execute();
        // $result = $stmt->get_result();
        // return $result->fetch_assoc();
        // return $stmt;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}