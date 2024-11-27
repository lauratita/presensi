<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/authortuView.php';


class LoginController
{
    private $loginmodel;

    public function __construct()
    {
        global $koneksi;
        $this->loginmodel = new LoginOrtuModel($koneksi);
    }

    public function login($request)
    {
        $nikortu = $request['nik_ortu'];
        $password = $request['password'];
        if (empty($password)) {
            return json_encode(['message' => 'Password wajib diisi', 'status' => 'error']);
        }
        $loginResult = $this->loginmodel->login($nikortu, $password);
        // var_dump($loginResult);
        if ($loginResult == false) {
            return json_encode(['message' => 'Email Atau Password Tidak Ditemukan', 'status' => 'error']);
        }else{
            return json_encode(['message' => 'login Berhasil','data'=> $loginResult, 'status' => 'success']);
        }
    }
}