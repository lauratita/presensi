<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/authView.php';

class LoginController
{
    private $loginService;

    public function __construct()
    {
        global $koneksi;
        $this->loginService = new LoginService($koneksi);
    }

    public function login($nikPegawai, $password)
    {
        if (strlen($nikPegawai) < 10) {
            return json_encode(['message' => 'NIK minimal 10 karakter', 'status' => 'error']);
        }
        // Validate password
        if (empty($password)) {
            return json_encode(['message' => 'Password wajib diisi', 'status' => 'error']);
        }
        $loginResult = $this->loginService->getLogin($nikPegawai, $password);
        var_dump($loginResult);
        if ($loginResult == false) {
            return json_encode(['message' => 'Email Atau Password Tidak Ditemukan', 'status' => 'error']);
        }else{
            return json_encode(['message' => 'login Berhasil','data'=> $loginResult, 'status' => 'success']);
        }
    }
}