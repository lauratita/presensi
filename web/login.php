<?php
session_start();

// Cek apakah sesi sudah ada, artinya pengguna sudah login
if (isset($_SESSION['nik_pegawai']) && isset($_SESSION['id_jenis'])) {
    // Arahkan ke halaman sesuai dengan id_jenis
    if ($_SESSION['id_jenis'] == 1) {
        header('Location: ./admin/index.php');
        exit();
    } elseif ($_SESSION['id_jenis'] == 2) {
        header('Location: ./guru/index.php');
        exit();
    }
}

use Web\Auth;
require_once ('./config/config.php');
include_once "./controller/authController.php";

// Inisialisasi variabel error
$errorNik = $errorPassword = $errorMessage = '';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dari form
    $nikPegawai = trim($_POST['txt_nikPegawai']);
    $password = trim($_POST['txt_passPegawai']);

    // Validasi input
    if (empty($nikPegawai)) {
        $errorNik = 'NIK wajib diisi';
    }
    if (empty($password)) {
        $errorPassword = 'Password wajib diisi';
    }

    // Jika tidak ada error, proses login
    if (empty($errorNik) && empty($errorPassword)) {
        // Validasi panjang NIK
        if (strlen($nikPegawai) < 10) {
            $errorNik = 'NIK minimal 10 karakter';
        } else {
            $controller = new LoginController();
            $loginResult = $controller->login($nikPegawai, $password);
            $login = json_decode($loginResult, true);
            if ($login['status'] === 'success') {
                // loginResult berhasil
                $idJenis = $login['data']['id_jenis'];
                
                // Set session
                $_SESSION['nik_pegawai'] = $login['data']['nik_pegawai'];
                $_SESSION['nama'] = $login['data']['nama'];
                $_SESSION['id_jenis'] = $idJenis;
    
                // Arahkan ke halaman yang sesuai berdasarkan id_jenis
                if ($idJenis == 1) {
                    // Arahkan ke halaman admin
                    header('Location: ./admin/index.php'); 
                    exit();
                } elseif ($idJenis == 2) {
                    // Arahkan ke halaman guru
                    header('Location: ./guru/index.php'); 
                    exit();
                }
                exit();
            } else {
                // Pesan kesalahan berdasarkan hasil loginResult
                if ($login['message'] == 'Password salah') {
                    $errorPassword = 'Password salah';
                } elseif ($login['message'] == 'NIK tidak terdaftar') {
                    $errorNik = 'NIK tidak terdaftar';
                }
            }
        }
    } else {
        // Tampilkan pesan error jika ada
        $errorMessage = isset($errorMessage) ? $errorMessage : 'Terjadi kesalahan, silakan coba lagi';
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CekInOut</title>
    <!-- Custom fonts for this template-->
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Sweetalert 2 CSS -->
    <link rel="stylesheet" href="./assets/plugins/sweetalert2/sweetalert2.min.css">
</head>

<body>
    <img class="wave" src="./img/wave.png" alt="Wave Image">
    <div class="container">
        <div class="img">
            <img src="./img/bg.svg" alt="Background Image">
        </div>
        <div class="login-content">
            <form action="" method="POST" class="user">
                <img src="./img/logo-skaga.jpeg" alt="Logo">
                <h2 class="title" style="color: #f48a4e;">Presence+</h2>

                <!-- NIK -->
                <div class="form-group has-validation">
                    <input type="text" name="txt_nikPegawai"
                        class="form-control form-control-user <?php echo !empty($errorNik) ? 'is-invalid' : ''; ?>"
                        id="nikPegawai" aria-describedby="" placeholder="Nomor Induk Karyawan (NIK)"
                        value="<?php echo isset($nik) ? htmlspecialchars($nik) : ''; ?>">
                    <!-- Tampilkan error NIK -->
                    <?php if (!empty($errorNik)): ?>
                    <div class="invalid-feedback">
                        <?php echo $errorNik; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div class="form-group form-group-pass">
                    <input type="password" name="txt_passPegawai"
                        class="form-control form-control-user <?php echo !empty($errorPassword) ? 'is-invalid' : ''; ?>"
                        id="password" placeholder="Password"
                        value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>">
                    <img src="./img/eye-close.png" id="eyeIcon">
                    <!-- Tampilkan error password -->
                    <?php if (!empty($errorPassword)): ?>
                    <div class=" invalid-feedback">
                        <?php echo $errorPassword; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- end password -->

                <div class="mb-3 text-right">
                    <a class="small" href="../forgotPassword/forgot-password.php" style="color: #f48a4e;">Forgot
                        Password?</a>
                </div>
                <button type="submit" name="submit" class="btn text-white btn-user btn-block" id=" btn-login">
                    Login
                </button>
            </form>
        </div>
    </div>

    <!-- show and hide password -->
    <script>
    let eyeIcon = document.getElementById("eyeIcon");
    let password = document.getElementById("password");

    eyeIcon.onclick = function() {
        if (password.type == "password") {
            password.type = "text"
            eyeIcon.src = "img/eye.png"
        } else {
            password.type = "password"
            eyeIcon.src = "img/eye-close.png"
        }
    }
    </script>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Sweetalert2 JS -->
    <script src="./assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Main JS -->
    <script src="./js/main.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- SweetAlert -->
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>