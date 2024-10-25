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
