
<!DOCTYPE html>
<html lang="es">
<head>
    @include('common.header')
    @include('common.routes')
</head>
<body>
    <h1 class="mb-4 text-center"><img src="{{ asset('img/cloud.png') }}"/></h1>
   @include('common.botones')
    <div class="container my-5">
        <div class="mb-2">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Crear Link</h2>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('links.save') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="nonbre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="" required>
                            </div>
                            <div class="mb-3">
                                <label for="link" class="form-label">URL</label>
                                <input type="link" class="form-control" id="link" name="enlace" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Crear Link</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>