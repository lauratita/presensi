<?php
namespace Web;
class Auth {
    private $db;
    private $errorNik;
    private $errorPass;
    private $error;
    
    public function __construct($db_conn)
    {
        $this->db = $db_conn;
        session_start();
        
    }

    public function login($nik, $pass) {
        try {
            // Cek jika NIK kosong
            if (empty(trim($nik))) {
                $this->error = "NIK wajib diisi";
                return false;
            }
            
            // Cek jika password kosong
            if (empty(trim($pass))) {
                $this->error = "Password wajib diisi";
                return false;
            }

            // Ambil data dari database berdasarkan NIK
            $stmt = $this->db->prepare("SELECT * FROM tb_pegawai WHERE nik = :nik");
            $stmt->bindParam(":nik", $nik);
            $stmt->execute();
            $data = $stmt->fetch();

            // Jika data ditemukan
            if ($stmt->rowCount() > 0) {
                // Jika password sesuai
                if ($data['password'] === $pass) {
                    $_SESSION['namaPegawai'] = $data['nik'];
                    $_SESSION['id_jenis'] = $data['id_jenis'];
                    return $data['id_jenis']; // Mengembalikan id_jenis jika berhasil
                } else {
                    $this->error = "Password salah";
                    return false;
                }
            } else {
                $this->error = "NIK tidak terdaftar";
                return false;
            }
        } catch (\PDOException $e) {
            $this->error = "Kesalahan sistem: " . $e->getMessage();
            return false;
        }
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['namaPegawai'])) {
            return true;
        }
    }

    public function getUser()
    {
        if(!$this->isLoggedIn()){
            return false;
        }
        
        try{
            // ambil data pengguna dari session
            $stmt = $this->db->prepare("SELECT * FROM tb_pegawai WHERE nik = :nik");
            $stmt->bindParam(":nik", $_SESSION['namaPegawai']);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['namaPegawai']);
        return true;
    }

    public function getLastError()
    {
        return $this->error;
    }
}