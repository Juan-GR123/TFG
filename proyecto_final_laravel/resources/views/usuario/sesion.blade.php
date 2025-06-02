@extends('layouts.app')  <!-- Hace referencia al layout principal -->


@section('content')
<section id="centrar">
    <div id="login" class="block">
        <h1 class="text-2xl font-bold text-black dark:text-white" >Entrar a la Web</h1>

        <!-- Mensaje de error si la sesión contiene el error de login -->
         <!-- Mensaje de error si la sesión contiene el error de login -->
        @if (session('success'))
            <div class="mensaje_exito">
                <strong class="verde" id="mensaje">{{ session('success') }}</strong>
            </div>
        @endif

        @if (session('error'))
            <div class="mensaje_error">
                <strong class="rojo" id="mensaje">{{ session('error') }}</strong>
            </div>
        @endif

        @if (session('error_login'))
            <div class="error_login">
                <strong class="rojo" id="mensaje">{{ session('error_login') }}</strong>
            </div>
        @endif


        <!-- Verifica si el usuario no está autenticado -->
        @auth
            <script>
                window.location.href = "{{ route('producto.index') }}";
            </script>
        @else
        <form class="form" action="{{ route('usuario.login') }}" method="POST">
            @csrf <!-- Asegúrate de tener esto -->
            
            <label for="email" class="text-black dark:text-white">Email</label>
            <input type="email" class=" bg-white dark:bg-black text-black dark:text-white border border-gray-400 dark:border-gray-600 p-2 rounded w-full" name="email" id="email"/>
        
            <label for="password" class="text-black dark:text-white">Password</label>
            <input type="password" name="password" id="password"/>
            <p class="text-black dark:text-white">
                Mostrar contraseña
                <input type="checkbox" onclick="myFunction()">  
            </p>
        
        
            <button type="submit" class="submit">Iniciar sesion</button>
            <span class="span">¿No tienes cuenta? <a href="{{ route('usuario.save') }}">Registrate</a></span>
        </form>
        
        @endauth
    </div>
</section>

<!-- JavaScript para ocultar el mensaje después de 5 segundos -->
<script>
    setTimeout(() => {
        const mensaje = document.getElementById('mensaje');
        if (mensaje) {
            mensaje.style.display = 'none';
        }
    }, 5000);

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
