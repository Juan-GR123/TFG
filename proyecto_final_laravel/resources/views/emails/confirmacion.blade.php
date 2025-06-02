<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmación de Registro</title>
</head>
<body>
    <div id="email">
        <h1>¡Hola {{ $usuario->nombre }}!</h1>
        <p>Gracias por registrarte en Roll&Play, la web para visualizar las mejores peliculas</p>
    
        <p>Por favor confirma tu email haciendo click aqui:</p>
        <p>
            <a href="{{ $urlConfirmacion }}" class="mt-3" style="padding:10px 20px; background-color:blue; color:white; text-decoration:none;">
                Confirmar Email
            </a>
        </p>
    </div>
</body>
</html>


