
document.addEventListener("DOMContentLoaded", () => {


    let fileInput = document.getElementById('uploadPhotos');
    const previewWrapp = document.getElementById('previewWrapp');
    const submitButton = document.getElementById('submitPhotos');
    const uploadItems = document.getElementsByClassName('upload__item');

    let images = {};
    fileInput.addEventListener('change', function (event) {
        let files = event.target.files;

        for (let i = 0; i < files.length; i++) {
            preview(files[i]);
            images[files[i].name] = files[i];
        }

    });

    submitButton.addEventListener('click', function (event) {
        event.preventDefault();

        const acceptedFiles = new FormData();

        for (let image in images) {
            acceptedFiles.append('upload[]', images[image]);
        }

        return fetch('/photos/upload/', {
            method: 'POST',
            body: acceptedFiles
        })
        .then((response) => {
          response.json()
            .then((json) => {
                const responseMessage = json[0].message;
                alert(responseMessage);
            })
        });
    })


    function preview(file) {
        const reader = new FileReader();

        reader.addEventListener('load', function (event) {

            let newImage = "<div class='upload__item'><img src='" + event.target.result + "'" + " class='upload__img'/><a data-id='" + file.name + "' class='upload__del'></a></div>";
            
            previewWrapp.insertAdjacentHTML('afterbegin', newImage);

        });
        reader.readAsDataURL(file);
    }

    previewWrapp.addEventListener('click', function (event) {
        let deleteBtn = event.target.closest('a');

        if (!deleteBtn) {
            return;
        }
        
        let deleteId = deleteBtn.dataset.id;
        let deletintEl = deleteBtn.closest('div');
        
        for (let image in images) {
          if (image === deleteId) {
              delete images[image];
          }
        }
        deletintEl.remove();
    })
    
    previewWrapp.addEventListener('click', function (event) {
        let img = event.target.closest('img');

        if (!img) {
            return;
        }
        
        const path = img.getAttribute('src');
        
        var win = window.open();
        win.document.write('<iframe src="' + path  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
        
    })

});