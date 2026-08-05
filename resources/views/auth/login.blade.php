<!DOCTYPE html>
<html lang="es">
<head>
<head>
    @include('common.header')
</head>    <!-- Bootstrap CSS -->
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                        <div class="text-center mb-4">
                            <img src="{{ asset('img/cloud.png') }}" style="width: 185px;" class="img-fluid" alt="Mi cloud" />
                        </div>
                        @if ($errors->has('email') || $errors->has('password'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('email') ?: $errors->first('password') ?: 'Usuario o contraseña incorrectos.' }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</body>
</html>