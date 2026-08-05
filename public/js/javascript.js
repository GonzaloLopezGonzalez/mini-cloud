document.addEventListener('DOMContentLoaded', function () {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    const uploadButton = document.getElementById('uploadButton');
    const uploadForm = document.getElementById('uploadForm');

    // Habilitar el botón de subida cuando se seleccionan archivos
    fileInput.addEventListener('change', updateFileList);
    dropZone.addEventListener('click', () => fileInput.click());

    // Manejo de drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        fileInput.files = e.dataTransfer.files;
        updateFileList();
    });

    function updateFileList() {
        fileList.innerHTML = '';
        const files = fileInput.files;

        if (files.length > 0) {
            uploadButton.disabled = false;
        } else {
            uploadButton.disabled = true;
        }

        for (let file of files) {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
            fileList.appendChild(li);
        }
    }

    // Subida con AJAX
    uploadForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (fileInput.files.length === 0) {
            alert('Por favor, selecciona al menos un archivo.');
            return;
        }

        const formData = new FormData(uploadForm);

        try {
               const response = await fetch(window.Laravel.routes.uploadAjax, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Agregar el token CSRF
                }
            });

            const data = await response.json();

            alert(data.message); // Mostrar mensaje de éxito o error
            //if (data.success) {
                window.location.reload(); // Recargar la página para actualizar la lista de archivos
            //}
        } catch (error) {
            console.error('Error:', error);
            alert('Error al subir los archivos.');
        }
    });
});