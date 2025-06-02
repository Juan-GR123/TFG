@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Gestión de productos</h1>

    <div class="botones-categorias">
        <a href="{{ route('producto.crear') }}" class="btn text-center bg-black text-white hover:text-white dark:bg-white dark:text-black">
            Crear Producto
        </a>
    </div>

    @if (session('producto') == 'complete')
        <strong class="verde" id="mensaje">Producto creado correctamente</strong>
    @elseif (session('producto') == 'failed')
        <strong class="rojo" id="mensaje">Producto fallido, introduce bien los datos</strong>
    @elseif (session('error_producto'))
        <strong class="rojo" id="mensaje">{{ session('error_producto') }}</strong>
    @endif

    @if (session('delete') == 'complete')
        <strong class="verde" id="mensaje">Producto se ha borrado correctamente</strong>
    @elseif (session('delete') == 'failed')
        <strong class="rojo" id="mensaje">Producto NO se ha borrado correctamente</strong>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
            @foreach ($productos as $pro)
            <div class="border border-gray-700 p-4 rounded-lg bg-slate-400 dark:bg-[#111] shadow-md">
                <div class="flex justify-center mb-3">
                    @if ($pro->imagen)
                        <img src="{{ asset('storage/uploads/' . $pro->imagen) }}" class="w-20 h-auto object-cover rounded" alt="">
                    @else
                        <img src="{{ asset('storage/uploads/RollAndPlay_Logo200px.png') }}" class="img_carrito" width="200px" alt="">
                    @endif
                </div>
                <div class="text-white space-y-2">
                    <div>
                        <span class="font-semibold text-black dark:text-white">Nombre:</span>
                        <a href="{{ route('producto.editar', $pro->id) }}" class="text-blue-600 hover:text-black dark:hover:text-white dark:text-blue-400 underline block">{{ $pro->nombre }}</a>
                    </div>
                    <div class="hidden md:block">
                        <span class="font-semibold text-black dark:text-white">Fecha de publicación:</span>
                        <p class="text-sm text-gray-800 dark:text-gray-300">{{ $pro->fecha }}</p>
                    </div>
                </div>
                <div class="mt-3 flex justify-between">
                    <a href="{{ route('producto.editar', $pro->id) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Editar
                    </a>
                    <a href="{{ route('producto.eliminar', $pro->id) }}" class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Eliminar
                    </a>
                </div>
            </div>
            @endforeach
    </div>   

    <script>
        setTimeout(() => {
            const mensaje = document.getElementById('mensaje');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        }, 5000);
    </script>
@endsection
