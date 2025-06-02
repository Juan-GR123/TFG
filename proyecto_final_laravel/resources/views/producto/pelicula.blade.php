@extends('layouts.app')

@section('content')
    <h2  class="text-xl font-bold mb-4 text-black hover:text-black dark:text-white">{{ $producto->nombre }} - Película</h2>

    <div class="container-pelicula" style="padding: 20px;">
        @if (filter_var($producto->pelicula, FILTER_VALIDATE_URL))
            <!-- Si es una URL, intentamos mostrarlo con un iframe (ideal para YouTube u otros servicios de video) -->
            @if (strpos($producto->pelicula, 'youtube.com') !== false || strpos($producto->pelicula, 'youtu.be') !== false)
                <!-- Convertir el enlace de YouTube a formato embed -->
                @php
                    $videoId = null;
                    if (strpos($producto->pelicula, 'youtube.com') !== false) { //esti busca el id de la url para ponerlo en embedUrl y que se pueda ver
                        preg_match('/v=([a-zA-Z0-9_-]+)/', $producto->pelicula, $matches);
                        $videoId = $matches[1] ?? null;
                    } elseif (strpos($producto->pelicula, 'youtu.be') !== false) {
                        $videoId = basename($producto->pelicula);
                    }
  
                    $embedUrl = $videoId ? 'https://www.youtube.com/embed/' . $videoId : null;
                @endphp

                @if ($embedUrl)
                    <iframe width="100%" height="500" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                    <a href="{{ $producto->pelicula }}" target="_blank">Ver película en otro sitio</a>
                @endif
            @else
                <!-- Si no es YouTube, mostramos el enlace para redirigir a la URL -->
                <a href="{{ $producto->pelicula }}" class="bg-black text-white" target="_blank">Ver película en otro sitio</a>
            @endif
        @else
            <video width="100%" height="50%" controls class="rounded-md shadow-md bg-black">
                <source src="{{ route('producto.streaming', $producto->id) }}" type="video/mp4">
                Tu navegador no soporta la etiqueta de video.
            </video>
        @endif
    </div>
@endsection
