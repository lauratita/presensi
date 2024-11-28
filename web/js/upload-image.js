
// document.addEventListener('DOMContentLoaded', function () {
//     if (typeof showEditModal !== 'undefined' && showEditModal) {
//         $('#modalEdit').modal('show');
//     }
// }

$(document).ready(function() {
    // Kode untuk memunculkan modal
    $('.btn-edit').on('click', function() {
        
        const nik = $(this).data('nik');
        console.log(nik);
        // $.ajax({
        //     url: 'http://localhost/presensi/web/api/ortucontroler/getByNik',
        //     data: { nik: nik },
        //     dataType: 'json',
        //     success: function(data) {
        //         $('#editNik').val(data.nik_ortu);
        //         $('#editNamaOrtu').val(data.nama);
        //         $('#editJkOrtu').val(data.jenis_kelamin);
        //         $('#editEmail').val(data.email);
        //         $('#editPassword').val(data.password);
        //         $('#editNoHp').val(data.no_hp);
        //         $('#editAlamatOrtu').val(data.alamat);

        //         // Menampilkan modal
        //         $('#modalEdit').modal('show');
        //     },
        //     error: function() {
        //         alert('Gagal mengambil data.');
        //     }
        // });
    });
});

$(document).ready(function() {
    // Event listener untuk tombol Batal
    $('.btn-secondary').click(function() {
        // Mengosongkan semua input di dalam form
        $('#tab-detailPelajaran form')[0].reset();
    });
});

$(document).ready(function() {
    // Event listener untuk tombol Batal
    $('.btn-secondary').click(function() {
        // Mengosongkan semua input di dalam form
        $('#tab-tambahJPGW form')[0].reset();
    });
});

$('#modalHapusPegawai').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var nik = button.data('nik'); 

    console.log("NIK:", nik); // Periksa apakah id benar
    
    var modal = $(this);
    var hrefDelete = "?action=delete&nik=" + nik; 
    console.log("Hapus URL:", hrefDelete); // Periksa URL yang terbentuk
    
    modal.find('#btnHapusPegawai').attr('href', hrefDelete); // Set href tombol hapus
});

$('#modalHapusJPegawai').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var id = button.data('id'); 

    console.log("ID:", id); // Periksa apakah id benar
    
    var modal = $(this);
    var hrefDelete = "?action=delete&id=" + id; 
    console.log("Hapus URL:", hrefDelete); // Periksa URL yang terbentuk
    
    modal.find('#btnHapusJPegawai').attr('href', hrefDelete); // Set href tombol hapus
});

$('#modalHapusMapel').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var kode = button.data('kode'); 

    console.log("KODE:", kode); // Periksa apakah id benar
    
    var modal = $(this);
    var hrefDelete = "?action=delete&kode=" + kode; 
    console.log("Hapus URL:", hrefDelete); // Periksa URL yang terbentuk
    
    modal.find('#btnHapusMapel').attr('href', hrefDelete); // Set href tombol hapus
});

$('#modalHapusDMPL').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var id = button.data('id'); 

    console.log("ID:", id); // Periksa apakah id benar
    
    var modal = $(this);
    var hrefDelete = "?action=delete&id=" + id; 
    console.log("Hapus URL:", hrefDelete); // Periksa URL yang terbentuk
    
    modal.find('#btnHapusDMPL').attr('href', hrefDelete); // Set href tombol hapus
});

$('#modalRead').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Tombol yang memicu modal
    var modal = $(this);

    // Ambil data dari atribut tombol
    modal.find('#detailNIK').text(button.data('nik'));
    modal.find('#detailNama').text(button.data('nama'));
    modal.find('#detailAlamat').text(button.data('alamat'));
    modal.find('#detailJenisKelamin').text(button.data('jenis-kelamin'));
    modal.find('#detailPassword').text(button.data('password'));
    modal.find('#detailNoHP').text(button.data('no-hp'));
    modal.find('#detailEmail').text(button.data('email'));
    modal.find('#detailJenisPegawai').text(button.data('id-jenis'));
});

$('#modalHapusOrtu').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Tombol yang men-trigger modal
    var nik = button.data('nik'); // Ambil data NIK dari tombol

    var modal = $(this);
    var hrefDelete = "?action=delete&nik=" + nik; // Buat URL hapus
    modal.find('#btnHapusOrtu').attr('href', hrefDelete); // Set href tombol hapus
});

$('#modalHapusKelas').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var id = button.data('id'); 

    var modal = $(this);
    var hrefDelete = "?action=delete&id=" + id; 
    modal.find('#btnHapusKelas').attr('href', hrefDelete); // Set href tombol hapus
});

$('#modalHapusSiswa').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var nis = button.data('nis'); 

    var modal = $(this);
    var hrefDelete = "?action=delete&nis=" + nis; 
    modal.find('#btnHapusSiswa').attr('href', hrefDelete); // Set href tombol hapus
});


$('#formTambahOrtu').on('submit', function() {
    // Reset form after submit
    $(this).attr('action', '?action=create');
});


const selectImages = document.querySelectorAll('.select-image');
const inputFiles = document.querySelectorAll('input[type="file"]');
const imgAreas = document.querySelectorAll('.img-area');
// selectImage.addEventListener('click', function(){
//     inputFile.click();
// })

// selectImages.forEach(button, index=> {
//     button.addEventListener('click', function(){
//         const targetId = this.getAttribute('data-target');
//         const inputFile = document.querySelector(`#${targetId}`);
//         inputFile.click();
//     });
// });

selectImages.forEach((button, index) => {
    button.addEventListener('click', function(){
        inputFiles[index].click();
    })

    inputFiles[index].addEventListener('change', function(){
        const image = this.files[0];
        const reader = new FileReader();
        reader.onload = ()=> {
            const allImg = imgAreas[index].querySelectorAll('img');
            allImg.forEach(item=> item.remove());
            const imgUrl = reader.result;
            const img = document.createElement('img');
            img.src = imgUrl;
            imgAreas[index].appendChild(img);
            imgAreas[index].classList.add('active');
            imgAreas[index].dataset.img =  image.name;
        }
        reader.readAsDataURL(image);
    })
})

// inputFile.addEventListener('change', function(){
//     const image = this.files[0]
//     console.log(image);
//     const reader = new FileReader();
//     reader.onload = ()=> {
//         const allImg = imgArea.querySelectorAll('img');
//         allImg.forEach(item=> item.remove());
//         const imgUrl = reader.result;
//         const img = document.createElement('img');
//         img.src = imgUrl;
//         imgArea.appendChild(img);
//         imgArea.classList.add('active');
//         imgArea.dataset.img = image.name;
//     }
//     reader.readAsDataURL(image);
// })

// inputFiles.forEach(inputFile => {
//     inputFile.addEventListener('change', function(){
//         const image = this.files[0];
//         const reader = new FileReader();
//         const imgArea = this.nextElementSibling;

//         reader.onload = () => {
//             const allImg = imgArea.querySelectorAll('img');
//             allImg.forEach(item => item.remove());
//             const imgUrl = reader.result;
//             const img = document.createElement('img');
//             img.src = imgUrl;
//             imgArea.appendChild(img);
//             imgArea.classList.add('active');
//             imgArea.dataset.img = image.name;
//         }
//         reader.readAsDataURL(image);
//     })
// })
