<?php
class SiswaModel{
    private $koneksi;
    private $table_name ="tb_siswa";
    private $table_kelas = "tb_kelas";
    private $table_ortu = "tb_orangtua";
    // private $table_foto = "tb_foto";
    private $table_view = "v_siswa_ortu_kelas";

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
    public $tanggal_masuk;

    public $tanggal_akhir;

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

        $sql = "INSERT INTO " . $this->table_name . " (`nis`, `nama`, `tanggal_lahir`, `tahun_akademik`, `password`, `jenis_kelamin`, `alamat`, `foto`, `tanggal_masuk`, `tanggal_berakhir`, `id_kelas`, `nik_ortu`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("ssssssssssss", $this->nis, $this->nama, $this->tanggal_lahir, $this->tahun_akademik, $this->password, $this->jenis_kelamin, $this->alamat, $this->foto, $this->tanggal_masuk, $this->tanggal_akhir, $this->id_kelas, $this->nik_ortu);
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

    public function view(){
        $sql = "SELECT * FROM " .$this->table_view;
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
          foto = '$this->foto', tanggal_masuk = '$this->tanggal_masuk', tanggal_berakhir = '$this->tanggal_akhir', id_kelas = '$this->id_kelas' , nik_ortu = '$this->nik_ortu' WHERE nis = '$this->nis'";
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

    public function naikKelas() {
        // Ambil tanggal sekarang
        $today = date("Y-m-d");
    
        // Cari siswa dengan `tanggal_berakhir` sudah lewat
        $sql = "SELECT nis, id_kelas FROM " . $this->table_name . " WHERE tanggal_berakhir <= ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) {
            $nis = $row['nis'];
            $currentKelas = $row['id_kelas'];
    
            // Cari kelas berikutnya untuk siswa ini
            $nextKelas = $this->getNextKelas($currentKelas);
    
            if ($nextKelas) {
                // Update ID kelas siswa ke kelas baru
                $updateSql = "UPDATE " . $this->table_name . " SET id_kelas = ? WHERE nis = ?";
                $updateStmt = $this->koneksi->prepare($updateSql);
                $updateStmt->bind_param("ss", $nextKelas, $nis);
                $updateStmt->execute();
            }
        }
    }
    

    public function getNextKelas($currentKelasId) {
        // Cari data kelas saat ini
        $sql = "SELECT id_jeniskelas, id_jurusan FROM " . $this->table_kelas . " WHERE id_kelas = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("i", $currentKelasId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $idJenis = $row['id_jeniskelas'] + 1; // Naik kelas
            $idJurusan = $row['id_jurusan'];
    
            // Cari kelas baru dengan `id_jenis` yang meningkat, tetapi `id_jurusan` sama
            $nextKelasSql = "SELECT id_kelas FROM " . $this->table_kelas . " WHERE id_jeniskelas = ? AND id_jurusan = ? LIMIT 1";
            $nextStmt = $this->koneksi->prepare($nextKelasSql);
            $nextStmt->bind_param("ii", $idJenis, $idJurusan);
            $nextStmt->execute();
            $nextResult = $nextStmt->get_result();
    
            if ($nextResult->num_rows > 0) {
                $nextRow = $nextResult->fetch_assoc();
                return $nextRow['id_kelas']; // Mengembalikan ID kelas baru
            }
        }
    
        return null; // Jika tidak ada kelas baru
    }
}