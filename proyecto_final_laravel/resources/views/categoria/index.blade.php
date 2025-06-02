{{-- resources/views/categorias/index.blade.php --}}

@extends('layouts.app') {{-- Opcional: si usas un layout base --}}

@section('content')
    @if (session('error_categoria'))
        <div class="error_categoria">
            <strong class="rojo">{{ session('error_categoria') }}</strong>
        </div>
    @endif

    @if (session('success'))
        <div class="text-green-600 mb-4" id="success">
        {{session('success')}}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-4 text-black dark:text-white">Gestionar Categorías</h1>

    <div class="botones-categorias">
        <a href="{{ route('categoria.crear') }}" class="btn text-center bg-black text-white hover:text-white dark:bg-white dark:text-black">
            Crear categoría
        </a>

        {{-- <a href="{{ route('categoria.eliminar') }}" class="btn">
            Borrar Categoría
        </a> --}}
    </div>
    
    <div class="space-y-4">
        @foreach ($categorias as $cat)
            <div class="bg-white dark:bg-black border border-gray-300 rounded-lg shadow-md p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="space-y-2 text-sm sm:text-base dark:text-gray-50">
                    <div><span class="font-semibold ">ID:</span> {{ $cat->id }}</div>
                    <div><span class="font-semibold">Nombre:</span> {{ $cat->nombre }}</div>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-4 flex space-x-4">
                    <a href="{{ route('categoria.editar', $cat->id) }}" class="text-blue-600 hover:text-black">Editar</a>
                    <a href="{{ route('categoria.delete', $cat->id) }}" class="text-red-600 hover:text-black">Eliminar</a>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        setTimeout(() => {
              const mensaje_suc = document.getElementById('success');
              if (mensaje_suc) {
                  mensaje_suc.style.display = 'none';
              }
          }, 5000);
  </script>

@endsection

