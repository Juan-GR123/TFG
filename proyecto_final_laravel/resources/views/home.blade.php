{{-- Blade Template --}}

@extends('layouts.app')  <!-- Aquí haces referencia a tu layout principal de Laravel -->

@section('content')
        @if (session('info'))
            <div class="info">
                <strong class="verde"> {{ session('info') }}</strong>
            </div>
        @endif

          
    <h1 class="text-3xl font-bold mb-4 rainbow-text animate-rainbow"> ¡Bienvenido a Roll&Play!</h1>
    <h2 class="flex justify-center text-xl mb-2 text-black hover:text-black dark:text-gray-400 "> Estás en la pagina de aterrizaje</h2>
    <p class="flex justify-center text-black dark:text-gray-400 ">En donde podrás alquilar todas las peliculas que puedas desear al momento</p>
    
    <div id="react-tabs2">

    </div>

    

@endsection
            
</body>
            
</html>