@extends('layouts.app')

@section('content')
    @if (isset($editar) && $editar && isset($producto))
        <h1>Editar producto {{ $producto->nombre }}</h1>
        <form action="{{ route('producto.save', ['id' => $producto->id]) }}" method="POST" enctype="multipart/form-data">
        @else
            <h1 class="text-2xl font-bold mb-6 text-black dark:text-white">Crear nuevo producto</h1>
            <form action="{{ route('producto.save') }}" method="POST" enctype="multipart/form-data">
    @endif

    @csrf

    <div class="form-container">
        <div class="form__group field">
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}"
                class="form__field bg-white dark:bg-black text-black dark:text-white border border-gray-400 dark:border-gray-600 p-2 rounded w-full"
                placeholder="">
            <label for="nombre" class="form__label">Nombre</label>
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <label for="descripcion" class="text-gray-500 dark:text-gray-300">Descripción</label>
        <textarea name="descripcion"
            class="border w-full border-gray-400 dark:border-gray-600 text-black dark:text-white bg-white dark:bg-black p-2 rounded-md mb-6 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <label for="categoria" class="text-gray-500 dark:text-gray-300">Categoría</label>
        <select name="categoria"
            class="w-full border border-gray-400 dark:border-gray-600 text-black dark:text-white bg-white dark:bg-black p-2 rounded-md mb-6 focus:outline-none focus:ring-2 focus:ring-blue-600">
            @foreach ($categorias as $cat)
                <option value="{{ $cat->id }}"
                    {{ old('categoria', $producto->categoria_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>
        @error('categoria')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

        <div class="form__group field">
            <input type="date" name="fecha" max="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                value="{{ old('fecha', $producto->fecha ?? '') }}"
                class="form__field bg-white dark:bg-black text-black dark:text-white border border-gray-400 dark:border-gray-600 p-2 rounded w-full"
                placeholder="">
            <label for="fecha" class="form__label">Fecha de publicación</label>
            @error('fecha')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- imagen --}}
        <div class="mb-6 mt-4 p-4 border border-gray-400 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-800">
            <label for="imagen" class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Imagen</label>
            @if (isset($producto) && $producto->imagen)
                <div class="mb-2 flex justify-center">
                    <img src="{{ asset('storage/uploads/' . $producto->imagen) }}" width="150px" class="rounded shadow">
                </div>
            @endif
            <input type="file" name="imagen" accept="image/*" class="w-full text-black dark:text-white">
            <small class="text-gray-600 dark:text-gray-400 mt-2">Por favor, sube una imagen en formato .jpg, .png o .jpeg.</small>
            @error('imagen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tráiler --}}
        <div class="mb-6 p-4 border border-gray-400 dark:border-gray-600 rounded-lg bg-blue-100 dark:bg-blue-800">
            <label for="trailer" class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Tráiler</label>

            @if (isset($producto) && $producto->trailer)
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 text-center">Tráiler actual:
                    {{ $producto->trailer }}</p>
            @endif

            <label for="trailer_url" class="text-gray-500 dark:text-gray-300">Enlace al tráiler (YouTube o URL directa)</label>
            <input type="url" name="trailer_url" value="{{ old('trailer_url', $producto->trailer_url ?? '') }}"
                class="border w-full border-gray-400 dark:border-gray-600 text-black dark:text-white bg-white dark:bg-black p-2 rounded-md mb-6 focus:outline-none focus:ring-2 focus:ring-blue-600"
                placeholder="https://www.youtube.com/watch?v=...">
            @error('trailer_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="trailer" class="text-gray-500 dark:text-gray-300">Subir archivo de video (MP4)</label>
            <input type="file" name="trailer" accept="video/*" class="text-black dark:text-white w-full mb-4 p-2 border border-gray-400 dark:border-gray-600 rounded-md">
            <small class="text-gray-600 dark:text-gray-400">Por favor, sube un archivo de video en formato .mp4.</small>
            @error('trailer')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        {{-- Película --}}
        <div class="mb-6 p-4 border border-gray-400 dark:border-gray-600 rounded-lg bg-green-100 dark:bg-green-800">
            <label for="pelicula" class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Película</label>

            @if (isset($producto) && $producto->pelicula)
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 text-center">Película actual:
                    {{ $producto->pelicula }}</p>
            @endif

            <label for="pelicula_url" class="text-gray-500 dark:text-gray-300">Enlace a la película (si es un enlace)</label>
            <input type="url" name="pelicula_url" value="{{ old('pelicula_url', $producto->pelicula_url ?? '') }}"
                class="border w-full border-gray-400 dark:border-gray-600 text-black dark:text-white bg-white dark:bg-black p-2 rounded-md mb-6 focus:outline-none focus:ring-2 focus:ring-blue-600"
                placeholder="https://www.ejemplo.com/video.mp4">
            @error('pelicula_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <label for="pelicula" class="text-gray-500 dark:text-gray-300">Subir archivo de video (si es un archivo MP4)</label>
            <input type="file" name="pelicula" accept="video/*" class="text-black dark:text-white w-full mb-4 p-2 border border-gray-400 dark:border-gray-600 rounded-md">
            <small class="text-gray-600 dark:text-gray-400">Por favor, sube un archivo de película en formato .mp4.</small>
            @error('pelicula')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <label for="reparto" class="block mb-2">Reparto y equipo técnico:</label>
        <textarea name="reparto" rows="10" id="reparto"
            class="border w-full border-gray-400 dark:border-gray-600 text-black dark:text-white bg-white dark:bg-black p-2 rounded-md mb-6 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('reparto', $producto->reparto ?? '') }}</textarea>
        @error('reparto')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror




        <div class="flex justify-center mt-8">
            <button type="submit" class="primary-button">Guardar</button>
        </div>
    </div>
    </form>
@endsection
