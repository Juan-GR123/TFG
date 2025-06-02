@extends('layouts.app')

@section('content')

@if (session('info'))
    <div class="info">
        <strong class="verde"> {{ session('info') }}</strong>
    </div>
@endif


<h1 class="text-2xl font-bold mb-4 text-black dark:text-white">Bienvenidos a Roll&Play</h1>

{{-- <div class="productos"> --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    @foreach ($productos as $producto)
        <div class="producto">
            <div class="imagen">
                <a href="{{ route('producto.ver', ['id' => $producto->id]) }}">
                    @if ($producto->imagen)
                        <img src="{{ asset('storage/uploads/' . $producto->imagen) }}" class="w-100" alt="">
                    @else
                        <img src="{{ asset('storage/uploads/RollAndPlay_Logo200px.png') }}" width="200px" alt="">
                    @endif
                    <h2 class=" text-black hover:text-indigo-400 dark:text-white dark:hover:text-indigo-400">{{ $producto->nombre }}</h2>
                </a>
            </div>
            

            @php
            $pedido = \App\Models\Pedido::where('usuario_id', auth()->id())
                ->whereHas('productos', fn($q) => $q->where('productos.id', $producto->id))
                ->where('estado', 'pagado')
                ->latest('fecha')
                ->first();
            @endphp 
            {{-- Comprueba que peliculas todavia esta alquiladas o no --}}


            @if ($pedido && $pedido->tieneAcceso())
                {{-- Mostrar botón "Ver película" si ya la tiene --}}
                <a href="{{ route('producto.pelicula', ['id' => $producto->id]) }}" class="button">
                    <span class="label">🎬 Ver película</span>
                    <span class="gradient-container">
                        <span class="gradient"></span>
                    </span>
                </a>
            @else
                {{-- Mostrar botón de alquiler si no la tiene --}}
                <a href="{{ route('carrito.add', ['id' => $producto->id]) }}" class="button">
                    <span class="label">+ Alquilar</span>
                    <span class="gradient-container">
                        <span class="gradient"></span>
                    </span>
                </a>
            @endif
        </div>
    @endforeach
</div>
{{-- </div> --}}

@endsection
