<!DOCTYPE html>
<html lang="es">
<head>
    @include('common.header')
    @include('common.routes')
</head>
<body>
   @include('common.botones')
    <div class="container my-5">
        <!-- Lista de archivos subidos -->
        <div class="card shadow-lg">
            <div class="card-body">
                <h2 class="card-title h5">Archivos subidos</h2>
                @if (empty($paginator))
                    <p class="text-muted">No hay archivos subidos.</p>
                @else
                    <ul class="list-group">
                        @foreach ($paginator as $item)
                            <li class="list-group-item d-flex align-items-center">
                                <div><span>{{$item['name']}}</span></div>

                                <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 align-items-center">
                           <div class="align-items-end">
                                <span class="text-end badge bg-primary">{{ number_format($item['size'] / 1048576, 2) }} MB</span>
                                <span class="text-end badge bg-secondary">{{ $item['date'] }}</span>
                                        @if ($item['ext'] != 'zip')
                                            <a target="_BLANK" href="{{ route('files.show', ['filename' => urlencode($item['name'])]) }}" class="btn btn-primary btn-sm">Mostrar</a>
                                        @endif
                                        <a href="{{ route('files.download', ['download' => urlencode($item['name'])]) }}" class="btn btn-success btn-sm">Descargar</a>
                                        <a href="{{ route('files.delete', ['delete' => urlencode($item['name'])]) }}" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este archivo?')">Eliminar</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
             <div class="d-flex justify-content-center">
                {{ $paginator->links('vendor.pagination.bootstrap-5') }}
            </div>
          </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     
</body>
</html>
