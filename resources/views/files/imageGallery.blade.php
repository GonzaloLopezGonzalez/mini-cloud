<!DOCTYPE html>
<html lang="es">
<head>
    @include('common.header')
    @include('common.routes')
</head>
<body>
   @include('common.botones')
<div class="container mt-5">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($images as $item)
              <div class="mb-5 carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="card shadow-lg">
                  <div class="card-body">
                    <img src="{{ $item['ruta'] }}" class="d-block w-100 img-fluid" alt="{{ $item['name'] }}"style="height: 600px; object-fit: cover;"  loading="lazy">
                  </div>
                </div>
              </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>