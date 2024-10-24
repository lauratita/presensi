<?php 
require ('./config/config.php');

session_start();

// Inisialisasi variabel pesan error
$errorNik = '';
$errorPass = '';
$errorMsg = '';

if (isset($_POST['submit'])) {
    $nik = $_POST['txt_nikPegawai'];
    $pass = $_POST['txt_passPegawai'];

    // Validasi apakah NIK atau password kosong
    if (empty(trim($nik))) {
        $errorNik = 'NIK wajib diisi';
    } elseif (strlen($nik) < 10) {
        $errorNik = 'NIK minimal 10 digit';
    }

    if (empty(trim($pass))) {
        $errorPass = 'Password wajib diisi';
    }

    // Jika tidak ada error, lanjutkan ke validasi database
    if (empty($errorNik) && empty($errorPass)) {
        // select data berdasarkan nik dari db
        $query = "SELECT * FROM tb_pegawai WHERE nik = '$nik'";
        $result = mysqli_query($koneksi, $query);
        $num = mysqli_num_rows($result);

        if ($num != 0) {
            if ($row = mysqli_fetch_array($result)) {
                $nikPegawai = $row['nik'];
                $namaPegawai = $row['nama'];
                $password = $row['password'];
                $jenis_kelamin = $row['jenis_kelamin'];
                $id_jenis = $row['id_jenis'];
            }

            if ($nikPegawai == $nik && $password == $pass) {
                // set session untuk menyimpan pesan suskses login
                $_SESSION['login_success'] = 'Login Berhasil!';
                $_SESSION['namaPegawai'] = $namaPegawai; // menyimpan nama pegawai
                if ($id_jenis == 1) {
                    header('Location: ./admin/index.php');
                } elseif ($id_jenis == 2) {
                    header('Location: ./guru/index.php');
                } else {
                    echo "<script>alert('Pegawai tidak ditemukan');window.location.href='login.php'</script>";
                }
            } else {
                // NIK ada, pass salah
                $errorPass = 'Password salah';
            }
        } else {
            // NIK tidak ada
            $errorNik = 'NIK tidak terdaftar';
        }
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
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
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
                <h2 class="title" style="color: #f48a4e;">CekInOut</h2>

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
                <div class="form-group">
                    <input type="password" name="txt_passPegawai"
                        class="form-control form-control-user <?php echo !empty($errorPass) ? 'is-invalid' : ''; ?>"
                        id="exampleInputPassword" placeholder="Password">
                    <!-- Tampilkan error password -->
                    <?php if (!empty($errorPass)): ?>
                    <div class="invalid-feedback">
                        <?php echo $errorPass; ?>
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