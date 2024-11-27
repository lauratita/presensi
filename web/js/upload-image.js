
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


