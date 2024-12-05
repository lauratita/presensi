<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/config/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/presensi/web/models/authModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari body POST
    $nikPegawai = isset($_POST['nik_pegawai']) ? $_POST['nik_pegawai'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validasi input
    if (empty($nikPegawai) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'NIK dan Password wajib diisi']);
        exit();
    }

    // Cek login
    $loginService = new LoginModel($koneksi);
    $loginResult = $loginService->login($nikPegawai);

    // Cek apakah NIK ditemukan
    if ($loginResult == false) {
        echo json_encode(['status' => 'error', 'message' => 'NIK tidak terdaftar']);
        exit();
    }

    $storedPassword = $loginResult['password'];

    // Periksa apakah password belum dalam bentuk hash (plaintext)
    $isPlainText = strlen($storedPassword) < 60; // Panjang hash bcrypt biasanya 60 karakter

    if ($isPlainText) {
        // Bandingkan password plaintext langsung
        if ($password === $storedPassword) {
            // Hash password dan perbarui di database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateSql = "UPDATE tb_pegawai SET password = ? WHERE nik_pegawai = ?";
            $stmt = $koneksi->prepare($updateSql);
            $stmt->bind_param("ss", $hashedPassword, $nikPegawai);
            if (!$stmt->execute()) {
                echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui password hash']);
                exit();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Password salah']);
            exit();
        }
    } else {
        // Password sudah di-hash, lakukan verifikasi dengan password_verify
        if (!password_verify($password, $storedPassword)) {
            echo json_encode(['status' => 'error', 'message' => 'Password salah']);
            exit();
        }
    }

    // Berhasil login, kirim data
    echo json_encode([
        'status' => 'success',
        'message' => 'Login berhasil',
        'data' => [
            'nik_pegawai' => $loginResult['nik_pegawai'],
            'nama' => $loginResult['nama'],
            'id_jenis' => $loginResult['id_jenis']
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Request method harus POST']);
}
?>