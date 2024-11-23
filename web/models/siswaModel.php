<?php
class SiswaModel{
    private $koneksi;
    private $table_name ="tb_siswa";
    private $table_kelas = "tb_kelas";
    private $table_ortu = "tb_orangtua";
    private $table_foto = "tb_foto";

    public $nis;
    public $nama;
    public $tanggal_lahir;
    public $tahun_akademik;
    public $jenis_kelamin;
    public $alamat;
    public $password;
    public $nik_ortu;
    public $id_kelas;
    public $id_foto;
    public $foto_depan;
    public $foto_kiri;
    public $foto_kanan;
    public $foto_atas;
    public $foto_bawah;

    public function __construct($db){
        $this->koneksi = $db;
    }

    private function uploadImage($file, $dir = 'uploads/'){
        // Membuat folder jika belum ada
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $target_file = $dir . basename($file["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi ekstensi file gambar
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_type, $allowed_types)) {
            return false;
        }

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            return false;
        }
    }

    public function create(){
        $foto_depan = $this->foto_depan ? $this->uploadImage($this->foto_depan) : null;
        $foto_kiri = $this->foto_kiri ? $this->uploadImage($this->foto_kiri) : null;
        $foto_kanan = $this->foto_kanan ? $this->uploadImage($this->foto_kanan) : null;
        $foto_atas = $this->foto_atas ? $this->uploadImage($this->foto_atas) : null;
        $foto_bawah = $this->foto_bawah ? $this->uploadImage($this->foto_bawah) : null;

        $sql = "INSERT INTO " . $this->table_name . " (`nis`, `nama`, `tanggal_lahir`, `tahun_akademik`, `password`, `jenis_kelamin`, `alamat`, `id_kelas`, `nik_ortu`)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->koneksi->prepare($sql);
            $stmt->bind_param("sssssssss", $this->nis, $this->nama, $this->tanggal_lahir, $this->tahun_akademik, $this->password, $this->jenis_kelamin, $this->alamat, $this->id_kelas, $this->nik_ortu);
            if ($stmt->execute()) {
                // $siswa_id = $this->koneksi->insert_id;

                // // Simpan data foto ke tabel tb_foto
                // $sql_foto = "INSERT INTO tb_foto (id_foto, foto_depan, foto_kiri, foto_kanan, foto_atas, foto_bawah, nis)
                //             VALUES (?, ?, ?, ?, ?, ?, ?)";
                // $stmt_foto = $this->koneksi->prepare($sql_foto);
                // $stmt_foto->bind_param("sssssss", $id_foto, $foto_depan, $foto_kiri, $foto_kanan, $foto_atas, $foto_bawah, $nis_siswa);
                // $stmt_foto->execute();
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
           return false;
        }
    }

    public function read(){
        $sql = "
        SELECT 
            s.nis,
            s.nama,
            s.tanggal_lahir,
            s.tahun_akademik,
            s.password,
            s.jenis_kelamin,
            s.alamat,
            s.id_kelas,
            s.nik_ortu,
            f.foto_depan,
            f.foto_kanan,
            f.foto_kiri,
            f.foto_atas,
            f.foto_bawah
        FROM {$this->table_name} s
        LEFT JOIN {$this->table_foto} f ON s.nis = f.nis
    ";
        $result = $this->koneksi->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
             // Format ulang data
        $formattedData = array_map(function ($row) {
            return [
                'nis' => $row['nis'],
                'nama' => $row['nama'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'tahun_akademik' => $row['tahun_akademik'],
                'password' => $row['password'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'alamat' => $row['alamat'],
                'id_kelas' => $row['id_kelas'],
                'nik_ortu' => $row['nik_ortu'],
                'foto_siswa' => [
                    'foto_depan' => $row['foto_depan'] ,
                    'foto_kanan' => $row['foto_kanan'] ,
                    'foto_kiri' => $row['foto_kiri'] ,
                    'foto_atas' => $row['foto_atas'] ,
                    'foto_bawah' => $row['foto_bawah'] ,
                ]
            ];
        }, $data);

        // Kembalikan hasil dalam JSON
        return json_encode($formattedData);
        } else {
            http_response_code(404);
            return json_encode(["message" => "Data not found"]);
        }
    }

    public function update(){
        $sql = "UPDATE " .$this->table_name . " SET nama = '$this->nama', tanggal_lahir = '$this->tanggal_lahir', tahun_akademik = '$this->tahun_akademik', password = '$this->password', jenis_kelamin = '$this->jenis_kelamin', alamat = '$this->alamat', id_kelas = '$this->id_kelas' , nik_ortu = '$this->nik' WHERE nis = '$this->nis'";
        $stmt = $this->koneksi->prepare($sql);
        if ($stmt->execute()) {
            return true;
        }
        return false;
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

    public function getByNIS($nis) {
        // Query dengan filter berdasarkan NIS
        $sql = "
            SELECT 
                s.nis,
                s.nama,
                s.tanggal_lahir,
                s.tahun_akademik,
                s.password,
                s.jenis_kelamin,
                s.alamat,
                s.id_kelas,
                s.nik_ortu,
                f.foto_depan,
                f.foto_kanan,
                f.foto_kiri,
                f.foto_atas,
                f.foto_bawah
            FROM {$this->table_name} s
            LEFT JOIN {$this->table_foto} f ON s.nis = f.nis
            WHERE s.nis = ?
        ";
    
        // Persiapkan statement
        $stmt = $this->koneksi->prepare($sql);
    
        // Bind parameter
        $stmt->bind_param('s', $nis);
    
        // Jalankan query
        $stmt->execute();
    
        // Ambil hasil query
        $result = $stmt->get_result();
    
        // Periksa apakah ada data
        if ($result->num_rows > 0) {
            // Ambil data siswa
            $row = $result->fetch_assoc();
    
            // Format data ke dalam struktur JSON yang diinginkan
            $formattedData = [
                'nis' => $row['nis'],
                'nama' => $row['nama'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'tahun_akademik' => $row['tahun_akademik'],
                'password' => $row['password'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'alamat' => $row['alamat'],
                'id_kelas' => $row['id_kelas'],
                'nik_ortu' => $row['nik_ortu'],
                'foto_siswa' => [
                    'foto_depan' => $row['foto_depan'] ? 'http://yourdomain.com/uploads/' . $row['foto_depan'] : null,
                    'foto_kanan' => $row['foto_kanan'] ? 'http://yourdomain.com/uploads/' . $row['foto_kanan'] : null,
                    'foto_kiri' => $row['foto_kiri'] ? 'http://yourdomain.com/uploads/' . $row['foto_kiri'] : null,
                    'foto_atas' => $row['foto_atas'] ? 'http://yourdomain.com/uploads/' . $row['foto_atas'] : null,
                    'foto_bawah' => $row['foto_bawah'] ? 'http://yourdomain.com/uploads/' . $row['foto_bawah'] : null,
                ]
            ];
    
            // Kembalikan hasil dalam JSON
            return json_encode($formattedData);
        } else {
            // Tidak ada data ditemukan
            http_response_code(404);
            return json_encode(["message" => "Data not found for NIS {$nis}"]);
        }
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