$('#editModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Tombol yang memicu modal
    var nik = button.data('nik'); // Ambil NIK dari tombol
    var name = button.data('name'); // Ambil data lain jika ada

    // Isi data ke dalam form modal
    var modal = $(this);
    modal.find('.modal-body #nik').val(nik);
    modal.find('.modal-body #name').val(name);
});


$('#modalHapus').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Tombol yang men-trigger modal
    var nik = button.data('nik'); // Ambil data NIK dari tombol

    var modal = $(this);
    var hrefDelete = "?action=delete&nik=" + nik; // Buat URL hapus
    modal.find('#btnHapus').attr('href', hrefDelete); // Set href tombol hapus
});

$(document).on('click', '.edit-btn', function(e) {
    e.preventDefault();
    var nik = $(this).data('nik');

    // Ajax request to get the data
    $.ajax({
        url: 'ortuapi.php?action=getByNik&nik=' + nik,
        type: 'GET',
        success: function(response) {
            var data = JSON.parse(response);

            // Isi form dengan data yang diambil
            $('#namaOrtu').val(data.nama);
            $('#jkOrtu').val(data.jenis_kelamin);
            $('#email').val(data.email);
            $('#password').val(data.password);
            $('#nik').val(data.nik);
            $('#nohp').val(data.no_hp);
            $('#alamatOrtu').val(data.alamat);

            // Ubah action form menjadi update
            $('#formTambahOrtu').attr('action', '?action=update&nik=' + nik);
        }
    });

    // Pindah ke tab edit data
    $('#nav-tambahOrtu-tab').trigger('click');
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
