<h1 class="mb-4 text-center"><img src="{{ asset('img/cloud.png') }}" style="width: 185px;" class="img-fluid" alt="Mi Cloud"/></h1>
<div class="container mt-5">
    <div class="d-flex flex-column flex-md-row justify-content-md-center gap-2 align-items-center">
        <div class="dropdown-center">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Ficheros
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" class="btn btn-primary" href="{{ route('files.uploadFiles') }}">Subir Archivos</a></li>
                <li><a class="dropdown-item" class="btn btn-primary" href="{{ route('files.list') }}">Listar Archivos</a></li>
            </ul>
        </div>
        <a href="{{ route('links.list') }}" class="btn btn-primary">Links</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">
                Cerrar sesión
            </button>
        </form>
    </div>
</div> 
