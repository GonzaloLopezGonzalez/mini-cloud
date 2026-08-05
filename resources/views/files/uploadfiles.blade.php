<!DOCTYPE html>
<html lang="es">
<head>
    @include('common.header')
    @include('common.routes')
</head>
</head>
<body>
    @include('common.botones')
    <div class="container mt-5">
        <!-- Área de drag and drop y formulario -->
        <div class="card mb-4 shadow-lg">
            <div class="card-body">
                <h2 class="card-title h5">Subir archivos</h2>
                <form id="uploadForm" method="POST" action="{{ route('files.uploadFiles') }}" enctype="multipart/form-data">
                    @csrf
                    <div id="dropZone" class="drop-zone">Arrastra archivos aquí o haz clic para seleccionar</div>
                    <input type="file" id="fileInput" name="files[]" multiple form-file style="display: none;">
                    <ul id="fileList" class="list-group mt-3"></ul>
                    <button type="submit" id="uploadButton" class="btn btn-primary mt-5" disabled>Subir Archivos</button>
                </form>
            </div>
        </div>

        <!-- Mensajes -->
        @if (session('message'))
            <div class="alert alert-{{ session('type') }}" role="alert">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{ asset('js/javascript.js') }}"></script>
</body>
</html>