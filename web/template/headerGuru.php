<?php 
ob_start();
require_once ('../config/config.php');
include_once '../controller/passwordController.php';
$controller = new PasswordController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'ubahPassword') {
    include_once 'config/config.php';
    include_once 'controllers/PasswordController.php';

    $controller = new PasswordController($koneksi);

    // Ambil data JSON dari request
    $request = json_decode(file_get_contents('php://input'), true);

    header('Content-Type: application/json');
    echo $controller->ubahPassword($request);
    exit();
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

    <title>Dashboard Wali Kelas</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- link bootstrap 5 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->



</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar accordion" id="accordionSidebar" style="background-color: #ffffff;">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="../img/logo2.png" alt="iconDashboard">
                </div>
                <div class="sidebar-brand-text mx-3" style="color: #f48a4e;">Presence+</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="bi bi-house" style="color: #f48a4e;"></i>
                    <span class="text-secondary">Dashboard</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">SISWA</div>
            <!-- Nav Item -Presensi -->
            <li class="nav-item">
                <a class="nav-link" href="presensi.php">
                    <i class="bi bi-calendar2-check" style="color: #f48a4e;"></i>
                    <span class="text-secondary">Presensi</span>
                </a>
            </li>
            <!-- Nav Item - Surat Izin -->
            <li class="nav-item">
                <a class="nav-link" href="suratIzin.php">
                    <i class="bi bi-file-earmark-check" style="color: #f48a4e;"></i>
                    <span class="text-secondary">Surat Izin</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">LAPORAN</div>
            <!-- Nav Item - Rekap -->
            <li class="nav-item">
                <a class="nav-link" href="rekap.php">
                    <i class="bi bi-file-earmark-text" style="color: #f48a4e;"></i>
                    <span class="text-secondary">Rekap</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <h5 class="m-0" style="color: #f48a4e;">Welcome
                            <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Wali Kelas'; ?>,
                            Have
                            a Nice
                            Day!!!</h5>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Wali Kelas'; ?></span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalUbahPassword">
                                    <i class="bi bi-key-fill fa-sm fa-fw mr-2" style="color: #f48a4e;"></i>
                                    Ubah Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="btn-logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2" style="color: #f48a4e;"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>

                    <!-- modal ubah password -->
                    <div class="modal fade" id="modalUbahPassword" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formUbahPassword">
                                        <input type="hidden" name="nik_pegawai" id="nikPegawai"
                                            value="<?php echo $_SESSION['nik_pegawai']; ?>">
                                        <div class="form-group">
                                            <label for="newPassword">Password Baru</label>
                                            <input type="password" class="form-control" id="newPassword"
                                                name="newPassword" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmPassword">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" id="confirmPassword"
                                                name="confirmPassword" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" id="btnUbahPassword" class="btn btn-primary">Ubah
                                        Password</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </nav>

                <!-- End of Topbar -->