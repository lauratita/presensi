<?php 
require ('./config/config.php');

session_start();

if (isset($_POST['submit'])) {
    $nik = $_POST['txt_nikPegawai'];
    $pass = $_POST['txt_passPegawai'];

    if (!empty(trim($nik)) && !empty(trim($pass))) {
        // select data berdasarkan nik dari db
        $query = "SELECT * FROM tb_pegawai WHERE nik = '$nik'";
        $result = mysqli_query($koneksi, $query);
        $num = mysqli_num_rows($result);
        
        if ($row = mysqli_fetch_array($result)) {
            $nikPegawai = $row['nik'];
            $namaPegawai = $row['nama'];
            $password = $row['password'];
            $jenis_kelamin = $row['jenis_kelamin'];
            $id_jenis = $row['id_jenis'];
        }

        if ($num != 0) {
            if ($nikPegawai == $nik && $password == $pass) {
                header('Location: ./guru/index.php');
            }else {
                echo "<script>alert('NIK or Password is Wrong.');window.location.href='login.php'</script>";
            }
        }else{
            echo "<script>alert('User tidak ditemukan.');window.location.href='login.php'</script>";
        }
    }else{
        echo "<script>alert('Data tidak boleh kosong.');window.location.href='login.php'</script>";
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

    <title>Wali Kelas CekInOut</title>

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
                                <form class="user" action="" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="txt_nikPegawai" class="form-control form-control-user"
                                            id="nikPegawai" aria-describedby=""
                                            placeholder="Nomor Induk Karyawan (NIK)">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="txt_passPegawai"
                                            class="form-control form-control-user" id="exampleInputPassword"
                                            placeholder="Password">
                                    </div>
                                    <div class="mb-3 text-right">
                                        <a class="small" href="../forgotPassword/forgot-password.php"
                                            style="color: #f48a4e;">Forgot
                                            Password?</a>
                                    </div>
                                    <button type="sumbit" name="submit" class="btn text-white btn-user btn-block"
                                        style="background-color: #f48a4e;">
                                        Login
                                    </button>
                                </form>
                            </div>
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

</body>

</html>