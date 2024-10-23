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
                $_SESSION['namaPegawai'] = $namaPegawai; //menyimpan nama pegawai
                if ($id_jenis == 1) {
                    header('Location: ./admin/index.php');
                } elseif ($id_jenis == 2) {
                    header('Location: ./guru/index.php');
                } else {
                    echo "<script>alert('Pegawai tidak ditemukan');window.location.href='login.php'</script>";
                }
            } else {
                $errorPass = 'Password salah';
            }
        } else {
            $errorNik = 'NIK salah';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CekInOut</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="login-page bg-gradient" style="background-color: #DB7A43">

    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="d-flex justify-content-center align-items-center vh-100 col-lg-6">
                            <img src="./img/Logo.png" alt="Logo" class="img-fluid">
                        </div>
                        <div class="col-lg-6" style="padding-top: 100px;">
                            <div class="p-5">
                                <div class="text-center logo-login">
                                    <h1 class="h4 text-warning-900 mb-4" style="color: #f48a4e"><img
                                            src="./img/logo2.png" alt="">CekInOut
                                    </h1>
                                </div>
                                <!-- form login -->
                                <form class="user" action="" method="POST">
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
                                    <!-- end NIK -->
                                    <!-- password -->
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
                                        <a class="small" href="../forgotPassword/forgot-password.php"
                                            style="color: #f48a4e;">Forgot Password?</a>
                                    </div>
                                    <button type="submit" name="submit" class="btn text-white btn-user btn-block"
                                        style="background-color: #f48a4e;" id="btn-login">
                                        Login
                                    </button>
                                </form>
                                <!-- end form login -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- SweetAlert -->
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="./assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>