</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../vendor/chart.js/Chart.min.js"></script>
<script src="../js/demo/chart-area-demo.js"></script>
<script src="../js/demo/chart-pie-demo.js"></script>

<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../js/demo/datatables-demo.js"></script>


<!-- Tab Data Table -->
<script>
$("#dataTablepresensi").DataTable();
$("#dataTablerekap").DataTable();
$("#dataTable-verified").DataTable();
$("#dataTable-unVerified").DataTable();
$("#dataTable-disable").DataTable();
</script>

<!-- SweetAlert -->
<script src="../assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- sweetalert logout -->
<script>
document.getElementById('btn-logout').addEventListener('click', function(e) {
    e.preventDefault(); // Mencegah default action dari tombol logout

    // Menampilkan SweetAlert untuk konfirmasi
    Swal.fire({
        title: 'Apakah anda ingin keluar halaman?',
        text: "Anda akan keluar dari sesi ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika pengguna mengklik "Ya", arahkan ke logout.php
            window.location.href = '../logout.php';
        }
    });
});
</script>

<!-- SweetAlert Ubah Password -->
<script>
document.getElementById('formUbahPassword').addEventListener('submit', function(e) {
    e.preventDefault(); // Hentikan pengiriman form sementara

    // Ambil nilai input
    const newPassword = document.getElementById('newPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    const alertContainer = document.getElementById('alertContainer');

    // Reset kontainer alert
    alertContainer.innerHTML = '';

    // Validasi input kosong
    if (!newPassword || !confirmPassword) {
        alertContainer.innerHTML = `
            <div class="alert alert-danger" role="alert">
            Yahh, data masih ada yang kosong nih!
            </div>`;
        return;
    }

    // Validasi panjang password
    if (newPassword.length < 8) {
        alertContainer.innerHTML = `
            <div class="alert alert-danger" role="alert">
            Password minimal 8 karakter yaa!
            </div>`;
        return;
    }

    // Validasi kesesuaian password
    if (newPassword !== confirmPassword) {
        alertContainer.innerHTML = `
            <div class="alert alert-danger" role="alert">
            Yahh, konfirmasi password tidak cocok. Ulangi lagi yaa!
            </div>`;
        return;
    }

    // Jika validasi berhasil
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Yeay, password kamu berhasil diubah!",
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        alertContainer.innerHTML = `
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>Password kamu sudah berubah</div>
            </div>`;

        // Kirim form setelah validasi sukses
        document.getElementById('formUbahPassword').submit();
    });
});
</script>



</body>

</html>