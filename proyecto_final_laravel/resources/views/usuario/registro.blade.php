@extends('layouts.app')  <!-- Aquí haces referencia a tu layout principal de Laravel -->

@section('content')


@if (session('success'))
    <div class="success" id="success">
        <strong class="verde"> {{ session('success') }}</strong>
    </div>
@endif


<div id="registro_div" class="flex justify-center items-center flex-col">

    <h1 id="reg"  class="text-2xl font-bold text-black dark:text-white">Registrarse</h1><br>

    <!-- Formulario de registro -->
     <!-- Verifica si el usuario ya está autenticado -->
     @auth
        <script>
            window.location.href = "{{ route('producto.index') }}";
        </script>
     @else
        <form class="form" action="{{route('usuario.save')}}" method="POST">
            @csrf <!-- Laravel utiliza un token único por sesión que debe enviarse con cada solicitud POST (o PUT, PATCH, DELETE).-->

            <label for="nombre" class="text-black dark:text-white" >Nombre:</label>
            <input type="text" name="nombre" placeholder="" required>
            @error('nombre')
                <small class="rojo" id="mensaje">{{ $message }}</small>
            @enderror

            <label for="apellidos" class="text-black dark:text-white">Apellidos:</label>
            <input type="text" name="apellidos" id="apellidos" placeholder="" required>
            @error('apellidos')
                <small class="rojo" id="mensaje">{{ $message }}</small>
            @enderror
 
            <label for="email" class="text-black dark:text-white">Email</label>
            <input type="email" name="email" id="email"/>
            @error('email')
                <small class="rojo" id="mensaje">{{ $message }}</small>
            @enderror
        
            
            <label for="password" class="text-black dark:text-white">Password</label>
            <input type="password" name="password" id="password"/>
            <p class="text-black dark:text-white">
                Mostrar contraseña
                <input type="checkbox" onclick="myFunction()">  
            </p>
            @error('password')
                <small class="rojo" id="mensaje">{{ $message }}</small>
            @enderror
        
            <button type="submit" class="submit">Registrarse</button>
            <span class="span">¿Ya tienes una cuenta? <a href="{{ route('usuario.sesion') }}">Iniciar sesion</a></span>
        </form>
    @endauth
</div>

<!-- JavaScript para ocultar el mensaje después de 5 segundos -->
<script>
    setTimeout(() => {
        const mensaje = document.getElementById('mensaje');
        if (mensaje) {
            mensaje.style.display = 'none';
        }
    }, 5000);

    setTimeout(() => {
        const mensaje = document.getElementById('success');
        if (mensaje) {
            mensaje.style.display = 'none';
        }
    }, 5000);


    // para que se muestre la contraseña
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

@endsection
