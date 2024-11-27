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

<!-- modal ubah password -->
<script>
// Submit password change form using AJAX
document.getElementById('btnUbahPassword').addEventListener('click', () => {
    const nikPegawai = document.getElementById('nikPegawai').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (!newPassword || !confirmPassword) {
        alert('Password baru dan konfirmasi tidak boleh kosong.');
        return;
    }

    if (newPassword !== confirmPassword) {
        alert('Konfirmasi password tidak sesuai.');
        return;
    }

    fetch('index.php?action=ubahPassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nik_pegawai: nikPegawai,
                newPassword: newPassword,
                confirmPassword: confirmPassword
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                $('#modalUbahPassword').modal('hide'); // Tutup modal
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan, silakan coba lagi.');
        });
});
</script>


</body>

</html>