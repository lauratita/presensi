<?php 
include '../template/headerAdmin.php';
?>

<!DOCTYPE html>
<html lang="en">

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- SweetAlert jika login berhasil -->
                    <?php if(isset($_SESSION['login_success'])): ?>
                    <script src="../assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: '<?php echo $_SESSION['login_success']; ?>',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    </script>
                    <!-- menghapus session setelah ditampilkan -->
                    <?php unset($_SESSION['login_success']); ?>
                    <?php endif ?>
                    <!-- Informasi  -->
                    <div class="row">
                        <!-- Siswa -->
                        <div class="col-sm-10 col-md-8">
                            <div class="">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div
                                                    class="h5 font-weight-bold text-warning text-uppercase mb-1 m-0 me-2">
                                                    Siswa</div>
                                                <div class="h2 mb-3 me-2 mt-4 font-weight-bold text-gray-800">1800</div>
                                                <span>Total Siswa</span>
                                            </div>
                                            <div class="col-auto">

                                                <i class="bi bi-mortarboard text-gray-300" style="font-size: 5rem"></i>

                                            </div>
                                        </div>
                                        <ul class="p-0 m-0 mt-5">
                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <i class="text-success bi bi-person-fill-check mr-2"></i>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0" style="font-weight: bold;">Hadir</h6>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small class="fw-semibold">36</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <i class="text-primary bi bi-person-fill-dash mr-2"></i>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0" style="font-weight: bold;">Sakit</h6>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small class="fw-semibold">2</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <i class="text-warning bi bi-person-fill-exclamation mr-2"></i>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0" style="font-weight: bold;">Izin</h6>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small class="fw-semibold">1</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-4 pb-1">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <i class="text-danger bi bi-person-fill-slash mr-2"></i>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0" style="font-weight: bold;">Alpha</h6>
                                                    </div>
                                                    <div class="user-progress">
                                                        <small class="fw-semibold">1</small>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Siswa -->
                        <!--Kelas dan Pegawai  -->
                        <div class="col-sm-4 col-md-4">
                            <!-- kelas -->
                            <div class="card shadow mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div
                                                    class="h5 font-weight-bold text-warning text-uppercase mb-1 m-0 me-2">
                                                    Kelas</div>
                                                <div class="h2 mb-3 me-2 mt-4 font-weight-bold text-gray-800">24</div>
                                                <br>
                                                <span>Total Kelas</span>
                                            </div>
                                            <div class="col-auto">
                                                <i class="bi bi-easel fa-2x text-gray-300" style="font-size: 4rem"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pegawai -->

                            <div class="card shadow mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div
                                                    class="h5 font-weight-bold text-warning text-uppercase mb-1 m-0 me-2">
                                                    Pegawai</div>
                                                <div class="h2 mb-3 me-2 mt-4 font-weight-bold text-gray-800">500</div>
                                                <br>
                                                <span>Total Pegawai</span>
                                            </div>
                                            <div class="col-auto">
                                                <i class="bi bi-person-badge text-gray-300" style="font-size: 4rem"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

</body>


</html>

<?php include '../template/footerAdmin.php'; ?>