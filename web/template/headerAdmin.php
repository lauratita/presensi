<?php
require_once ('../config/config.php');
session_start();

if(!isset($_SESSION['nik'])){
    header("location: ");
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

    <title>Dashboard Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <script src="../assets/js/jquery-3.7.1.min.js"></script>
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
                <div class="sidebar-brand-text mx-3" style="color: #f48a4e;">CekInOut</div>
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

            <div class="sidebar-heading">DATA</div>

            <!-- Nav Item - Data -->
            <li class="nav-item">
                <a class="nav-link collapsed <?php echo ($activeMenu == 'siswa') ? 'active' : ''; ?>" href="#"
                    data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true"
                    aria-controls="collapseUtilities">
                    <i class="bi bi-mortarboard" style="color: #f48a4e"></i>
                    <span class="text-secondary">Siswa</span>
                </a>
                <div id="collapseUtilities" class="collapse <?php echo ($activeMenu == 'siswa') ? 'show' : ''; ?>"
                    aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded" style="background-color: #ffb347">
                        <a class="collapse-item <?php echo ($activeSubmenu == 'siswa') ? 'active' : ''; ?>"
                            href="siswa.php">Siswa</a>
                        <a class="collapse-item <?php echo ($activeSubmenu == 'kelas') ? 'active' : ''; ?>"
                            href="kelas.php">Kelas</a>
                        <a class="collapse-item <?php echo ($activeSubmenu == 'jadwal') ? 'active' : ''; ?>"
                            href="jadwal.php">Jadwal</a>
                        <a class="collapse-item <?php echo ($activeSubmenu == 'other') ? 'active' : ''; ?>"
                            href="">Other</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Orang Tuas -->
            <li class="nav-item">
                <a class="nav-link" href="orangTua.php">
                    <i class="bi bi-people" style="color: #f48a4e;"></i>
                    <span class="text-secondary <?php echo ($activeSubmenu == 'ortu') ? 'active' : ''; ?>">Wali
                        Murid</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->

            <div class="sidebar-heading">PEGAWAI</div>

            <!-- Nav Item - Pages Pegawai -->
            <li class="nav-item">
                <a class="nav-link collapsed <?php echo ($activeMenu == 'pegawai') ? 'active' : ''; ?>" href="#"
                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="bi bi-person-badge" style="color : #f48a4e "></i>
                    <span class="text-secondary">Pegawai</span>
                </a>
                <div id="collapseTwo" class="collapse <?php echo ($activeMenu == 'pegawai') ? 'show' : ''; ?>"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded " style="background-color: #ffb347">
                        <a class="collapse-item <?php echo ($activeSubmenu == 'pegawai') ? 'active' : ''; ?>"
                            href="pegawai.php">Pegawai</a>
                        <a class="collapse-item <?php echo ($activeSubmenu == 'jenispegawai') ? 'active' : ''; ?>"
                            href="jenisPegawai.php">Jenis Pegawai</a>
                    </div>
                </div>
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
                        <h5 class="m-0" style="color: #f48a4e;">Welcome Admin, Have a Nice Day!!!</h5>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item">
                                    <i class="fas fa-user fa-sm fa-fw mr-2" style="color: #f48a4e;"></i>
                                    <span>Admin</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="btn-logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2" style="color: #f48a4e;"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->