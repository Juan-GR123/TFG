<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
</head>

<body>
    <div id="email">
        <h1>¡Gracias por tu pedido, {{ $usuario->nombre }}!</h1>

        <p>Tu pedido ha sido realizado con éxito.</p>

        <p><strong>Coste total:</strong> ${{ $coste_total }}</p>
        <p><strong>Tiempo de alquiler:</strong> {{ $tiempo }} meses</p>

        <h3>Productos del pedido:</h3>
        <ul>
            @foreach($productos as $producto)
            <li>{{ $producto->nombre }}</li>
            @endforeach
        </ul>

        <p>Si deseas cancelar el pedido, <a href="{{ route('pedido.cancelado') }}"  style="padding:10px 20px; background-color:#dc3545; color:white; text-decoration:none;">haz clic aquí</a>.</p>

    </div>
</body>

</html>