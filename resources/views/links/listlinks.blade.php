<!DOCTYPE html>
<html lang="es">
<head>
    @include('common.header')
    @include('common.routes')
</head>
<body>
   
   @include('common.botones')
    <div class="container my-5">
        <!-- Lista de lins -->
        <div class="mb-2"> 
        <a href="{{ route('links.new')}}" class="btn btn-success">Nuevo Link</a>
        </div>
        <div class="card shadow-lg">
            <div class="card-body">
                <h2 class="card-title h5">Links creados</h2>
                @if (empty($paginator))
                    <p class="text-muted">No hay links.</p>
                @else
                    <ul class="list-group">
                        @foreach ($paginator as $item)
                            <li class="list-group-item d-flex align-items-center">
                                <div>
                                    <span>{{$item['nombre']}}</span>
                                </div>
                                <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 align-items-center">
                                       <a target="_BLANK" target="_BLANK" href="{{$item['enlace']}}" class="btn btn-primary btn-sm">Visitar</a>
                                       <a href="{{ route('links.delete',['id' => $item['id']])}}" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este enlace?')">Eliminar</a>
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
