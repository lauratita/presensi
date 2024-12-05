<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/authortuView.php';
class LoginOrtuController
{
    private $loginService;
    public function __construct()
    {
        global $koneksi;
        $this->loginService = new LoginOrtuService($koneksi);
    }

    public function login($request)
    {
        $nikortu = $request['nik_ortu'];
        $password = $request['password'];

        if (empty($password)) {
            return json_encode(['message' => 'Password wajib diisi', 'status' => 'error']);
        }

        $loginResult = $this->loginService->getLogin($nikortu, $password);            // var_dump($loginResult);
            if ($loginResult == false) {
                return json_encode(['message' => 'Email Atau Password Tidak Ditemukan', 'status' => 'error']);
            }else{
                $dataSiswa = $this->loginService->getSiswaByOrtu($nikortu);
                return json_encode(['message' => 'login Berhasil',
                'data'=> $loginResult, 
                'siswa' => $dataSiswa, 
                'status' => 'success']);
            }
        }
    }