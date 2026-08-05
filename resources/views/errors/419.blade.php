<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background-color: #f8f9fa; }
        .error-code { font-size: 72px; color: #dc3545; margin-bottom: 20px; }
        .error-message { font-size: 18px; color: #6c757d; }
        .btn-home { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="error-code">404</div>
    <h1 class="error-message">¡Ups! La página ha expirado.</h1>
    <p>Es posible que hayas escrito mal la URL o la página se haya movido.</p>
   
    {{-- Solo en desarrollo, muestra detalles del error --}}
    @if(app()->environment('local'))
        <div style="margin-top: 30px; padding: 20px; background: #fff; border: 1px solid #ddd;">
            <strong>Detalles del error:</strong><br>
            {{ $exception->getMessage() }}
        </div>
    @endif
</body>
</html>