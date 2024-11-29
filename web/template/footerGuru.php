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
$('#dataTablerekap').DataTable({
            dom: 'Bfrtip', // Buttons placement
            buttons: [
                {
                    extend: 'excel', // Excel export
                    className: 'btn btn-success',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    title: 'Laporan Data'
                },
                {
                    extend: 'csv', // CSV export
                    className: 'btn btn-info',
                    text: '<i class="fa fa-file-text-o"></i> CSV',
                    title: 'Laporan Data'
                },
                {
                    extend: 'pdf', // PDF export
                    className: 'btn btn-danger',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    title: 'Laporan Data'
                },
                {
                    extend: 'print', // Print view
                    className: 'btn btn-primary',
                    text: '<i class="fa fa-print"></i> Print',
                    title: 'Laporan Data'
                }
            ],
            language: {
                // Optional: Indonesian localization
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

$("#dataTable-verified").DataTable();
$("#dataTable-unVerified").DataTable();
$("#dataTable-disable").DataTable();
</script>

<!-- SweetAlert -->
<script src="../assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

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



</body>

</html>