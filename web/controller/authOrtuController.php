<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/views/authortuView.php';
class LoginOrtuController {
    private $service;

    public function __construct($db) {
        $this->service = new LoginOrtuService($db);
    }

    public function login($nikOrtu, $password) {
        // Validasi NIK
        if (strlen($nikOrtu) != 16 || !ctype_digit($nikOrtu)) {
            return json_encode(['status' => 'error', 'message' => 'NIK harus 16 digit angka']);
        }

        // Validasi password
        if (empty($password)) {
            return json_encode(['status' => 'error', 'message' => 'Password wajib diisi']);
        }

        // Proses login
        $loginResult = $this->service->getLogin($nikOrtu, $password);

        if ($loginResult === false) {
            return json_encode([
                'status' => 'error', 
                'message' => 'NIK atau Password tidak valid'
            ]);
        } else {
            return json_encode([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => $loginResult
            ]);
        }
    }
}