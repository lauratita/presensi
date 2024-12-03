<?php
class SiswaModel{
    private $koneksi;
    private $table_name ="tb_siswa";
    private $table_kelas = "tb_kelas";
    private $table_ortu = "tb_orangtua";
    // private $table_foto = "tb_foto";

    public $nis;
    public $nama;
    public $tanggal_lahir;
    public $tahun_akademik;
    public $jenis_kelamin;
    public $alamat;
    public $password;
    public $foto;
    public $nik_ortu;
    public $id_kelas;

    public function __construct($db){
        $this->koneksi = $db;
    }

    public function uploadImage($file, $dir = 'uploads/'){

        $base_dir = $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/'; // Folder dasar
        $full_dir = $base_dir . $dir;
        // Membuat folder jika belum ada
        if (!is_dir($full_dir)) {
            mkdir($dir, 0777, true);
        }

        $file_name = basename($file["name"]);
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $unique_name = uniqid() . '.' . $file_type;
        $target_file = $full_dir . $unique_name;
        // Validasi ekstensi file gambar
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_type, $allowed_types)) {
            return false;
        }

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            // $app_name = 'http://' . $_SERVER['HTTP_HOST'] . '/presensi/web'; // Ambil folder aplikasi (contoh: 'presensi')
            // $app_path = "$app_name/$dir$unique_name"; // Gabungkan nama aplikasi ke dalam path
            // return $app_path;
            // var_dump("File uploaded to: " . $target_file); 
            // die();
            $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/presensi/web/';
            $file_url = $base_url . $dir . $unique_name;  // URL lengkap untuk file yang diupload

            // Kembalikan URL yang bisa diakses oleh browser
            return $file_url;
            
        } else {
            // var_dump();
            // die();
            return false;
        }
    }

    public function create(){

        $sql = "INSERT INTO " . $this->table_name . " (`nis`, `nama`, `tanggal_lahir`, `tahun_akademik`, `password`, `jenis_kelamin`, `alamat`, `foto`, `id_kelas`, `nik_ortu`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ssssssssss", $this->nis, $this->nama, $this->tanggal_lahir, $this->tahun_akademik, $this->password, $this->jenis_kelamin, $this->alamat, $this->foto, $this->id_kelas, $this->nik_ortu);
            if ($stmt->execute()) {
                var_dump("Data berhasil disimpan!");
                // die();
                return true;
            }else{
                var_dump("Data ggl disimpan!");
                var_dump($stmt->error); // Debug error
                
                // return false;
            }
        } catch (Exception $e) {
           return false;
        }
    }

    public function read(){
        $sql = "SELECT * FROM " .$this->table_name;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given NIK"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }


    public function update(){
        $sql = "UPDATE " .$this->table_name . " SET nama = '$this->nama', 
        tanggal_lahir = '$this->tanggal_lahir', tahun_akademik = '$this->tahun_akademik', jenis_kelamin = '$this->jenis_kelamin', alamat = '$this->alamat',
          foto = '$this->foto', id_kelas = '$this->id_kelas' , nik_ortu = '$this->nik_ortu' WHERE nis = '$this->nis'";
        $stmt = $this->koneksi->prepare($sql);
        if ($stmt->execute()) {
            // var_dump();
            // die();
            return true;
        }else{
            var_dump($stmt->errorInfo());
            die();
        }
        return false;
    }

    public function getFotoLama($nis) {
        $sql = "SELECT foto FROM " . $this->table_name . " WHERE nis = ?";
        $stmt = $this->koneksi->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $nis); // Bind parameter $nis ke query
            $stmt->execute(); // Eksekusi query
            $result = $stmt->get_result(); // Dapatkan hasil query
    
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['foto']; // Kembalikan nilai kolom foto
            }
        }
    
        return '';// Kembalikan string kosong jika tidak ada data
    }
    
    

    public function delete(){
        $sql = "DELETE FROM " .$this->table_name . " WHERE nis = ?";
        $stmt = $this->koneksi->prepare($sql);

        // $stmt->bindValue(1, $this->nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $this->nis);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // public function getByNIS($nis) {
    //     // Query dengan filter berdasarkan NIS
    //     $sql = "
    //         SELECT 
    //             s.nis,
    //             s.nama,
    //             s.tanggal_lahir,
    //             s.tahun_akademik,
    //             s.password,
    //             s.jenis_kelamin,
    //             s.alamat,
    //             s.id_kelas,
    //             s.nik_ortu,
    //             f.foto_depan,
    //             f.foto_kanan,
    //             f.foto_kiri,
    //             f.foto_atas,
    //             f.foto_bawah
    //         FROM {$this->table_name} s
    //         LEFT JOIN {$this->table_foto} f ON s.nis = f.nis
    //         WHERE s.nis = ?
    //     ";
    
    //     // Persiapkan statement
    //     $stmt = $this->koneksi->prepare($sql);
    
    //     // Bind parameter
    //     $stmt->bind_param('s', $nis);
    
    //     // Jalankan query
    //     $stmt->execute();
    
    //     // Ambil hasil query
    //     $result = $stmt->get_result();
    
    //     // Periksa apakah ada data
    //     if ($result->num_rows > 0) {
    //         // Ambil data siswa
    //         $row = $result->fetch_assoc();
    
    //         // Format data ke dalam struktur JSON yang diinginkan
    //         $formattedData = [
    //             'nis' => $row['nis'],
    //             'nama' => $row['nama'],
    //             'tanggal_lahir' => $row['tanggal_lahir'],
    //             'tahun_akademik' => $row['tahun_akademik'],
    //             'password' => $row['password'],
    //             'jenis_kelamin' => $row['jenis_kelamin'],
    //             'alamat' => $row['alamat'],
    //             'id_kelas' => $row['id_kelas'],
    //             'nik_ortu' => $row['nik_ortu'],
    //             'foto_siswa' => [
    //                 'foto_depan' => $row['foto_depan'] ,
    //                 'foto_kanan' => $row['foto_kanan'] ,
    //                 'foto_kiri' => $row['foto_kiri'] ,
    //                 'foto_atas' => $row['foto_atas'] ,
    //                 'foto_bawah' => $row['foto_bawah'] ,
    //             ]
    //         ];
    
    //         // Kembalikan hasil dalam JSON
    //         return json_encode($formattedData);
    //     } else {
    //         // Tidak ada data ditemukan
    //         http_response_code(404);
    //         return json_encode(["message" => "Data not found for NIS {$nis}"]);
    //     }
    // }

    public function getByNis($nis){
        $sql = "SELECT * FROM " . $this->table_name . " WHERE nis = ?";
        $stmt = $this->koneksi->prepare($sql);
        // $stmt->bindValue(1, $nik, PDO::PARAM_STR);
        $stmt->bind_param("s", $nis);
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
    

    public function getkelas(){
        $sql = "SELECT id_kelas, nama_kelas FROM " . $this->table_kelas;
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return json_encode($data? $data : ["message" => "Data not found for given ID"]);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function getortu(){
        $sql = "SELECT nik_ortu, nama FROM " . $this->table_ortu;
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