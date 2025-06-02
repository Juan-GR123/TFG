@extends('layouts.app')

@section('content')
    @if (isset($producto))
        <h1 class=" text-2xl font-bold text-black dark:text-white">{{ $producto->nombre }}</h1>

        <div id="detalles_producto">
            <div class="imagen">
                @if ($producto->imagen)
                    <img src="{{ asset('storage/uploads/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                @else
                    <img src="{{ asset('storage/uploads/RollAndPlay_Logo200px.png') }}" width="200px"
                        alt="Imagen por defecto">
                @endif
            </div>


            <div id="detalles_producto2">


                <div class="video-container" style="margin-top: 40px">
                    {{-- Botón para ver tráiler si existe --}}
                    @if ($producto->trailer)
                        <a href="{{ route('producto.trailer', ['id' => $producto->id]) }}" class="button mb-4">
                            <span class="label">▶ Ver Tráiler</span>
                            <span class="gradient-container">
                                <span class="gradient"></span>
                            </span>
                        </a>
                    @endif

                    {{-- Verificar si el producto está alquilado y si el alquiler sigue vigente usando el método tieneAcceso --}}
                    @if (isset($alquilado) && $alquilado)
                        {{-- Buscar el pedido que contiene este producto y verificar acceso --}}
                        @php
                            $pedido = \App\Models\Pedido::where('usuario_id', auth()->id())
                                ->whereHas('productos', fn($q) => $q->where('productos.id', $producto->id))
                                ->where('estado', 'pagado')
                                ->latest('fecha')
                                ->first();
                        @endphp

                        {{-- Si el pedido existe y tiene acceso --}}
                        @if ($pedido && $pedido->tieneAcceso())
                            <a href="{{ route('producto.pelicula', ['id' => $producto->id]) }}" class="button mt-4">
                                <span class="label">🎬 Ver Película</span>
                                <span class="gradient-container">
                                    <span class="gradient"></span>
                                </span>
                            </a>
                        @endif
                    @else
                        {{-- Mostrar botón de alquiler si no está alquilado --}}
                        <a href="{{ route('carrito.add', ['id' => $producto->id]) }}" class="button mt-4">
                            <span class="label">+ Alquilar</span>
                            <span class="gradient-container">
                                <span class="gradient"></span>
                            </span>
                        </a>
                    @endif
                </div>
        
                

                <div class="mt-6 mx-20 border border-gray-700 p-4 rounded-lg bg-slate-400 dark:bg-[#111] shadow-md">
                    <h3 class="font-bold text-lg mb-2 text-black dark:text-white">Descripcion</h3>
                    <p class="whitespace-pre-wrap text-black dark:text-white">{{ $producto->descripcion }}</p>
                </div>

                @if ($producto->reparto)
                <div class="mt-6 mx-20 border border-gray-700 p-4 rounded-lg bg-slate-400 dark:bg-[#111] shadow-md">
                        <h3 class="font-bold text-lg mb-2 text-black dark:text-white">Reparto y equipo técnico</h3>
                        <p class="whitespace-pre-wrap text-black dark:text-white" style="min-height: 200px">{{ $producto->reparto }}</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <h1>El producto no existe</h1>
    @endif
@endsection
