@extends('layouts.app')

@section('content')

    @if (session('pedido') === 'complete')
        <h1 class="text-2xl font-bold mb-4 text-black dark:text-white">Tu pedido se ha confirmado</h1>
        <p class="text-black dark:text-white">
            Tu pedido ha sido guardado con éxito. Gracias por tu pago. El pedido será procesado y enviado.
        </p>
        <br>

        @if (isset($pedido) && isset($productos))
            <div class="flex justify-center items-center">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <h3 class="text-2xl font-semibold mt-4">Datos del pedido</h3>
                            <p class="text-lg font-bold text-white">Estado: {{ App\Helpers\Utils::estado($pedido->estado) }}
                            </p>
                            <p class="text-lg font-bold text-white">Número de pedido: {{ $pedido->id }}</p>
                            <p class="text-lg font-bold text-white">Total a pagar: {{ $pedido->coste }} $</p>
                            <p class="text-lg font-bold text-white">Tiempo de alquiler: {{ $pedido->tiempo_alquiler }} meses
                            </p>
                        </div>
                        <div class="flip-card-back">
                            <h3 class="text-2xl font-semibold">Dirección de envío</h3>
                            <p class="text-lg font-bold text-white">Provincia: {{ $pedido->provincia }}</p>
                            <p class="text-lg font-bold text-white">Localidad: {{ $pedido->localidad }}</p>
                            <p class="text-lg font-bold text-white">Dirección: {{ $pedido->direccion }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="text-lg font-medium mt-4">Productos:</h4>

            @php
                // Filtramos por si hay algún elemento que sea false o no sea instancia de Producto
                $productos_validos = collect($productos)->filter(function ($producto) {
                    return $producto && is_object($producto);
                });
            @endphp

            @if ($productos_validos->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 my-6">
                @foreach ($productos_validos as $producto)
                    <div class="border border-gray-700 p-4 rounded-lg bg-slate-400 dark:bg-[#111] shadow-md">
                        <div class="mb-4 flex justify-center">
                            @if ($producto->imagen)
                                <img src="{{ asset('storage/uploads/' . $producto->imagen) }}" width="150px"
                                    class="img_carrito" alt="">
                            @else
                                <img src="{{ asset('storage/uploads/RollAndPlay_Logo200px.png') }}" width="200px"
                                    class="img_carrito" alt="">
                            @endif
                        </div>
                        <div class="text-white space-y-2">

                            <div>
                                <span class="font-semibold">Nombre:</span><br>
                                <a href="{{ url('producto/ver', ['id' => $producto->id]) }}"
                                    class="text-blue-600 hover:text-black dark:hover:text-white dark:text-blue-400 underline block">
                                    {{ $producto->nombre }}
                                </a>
                            </div>

                            <div>
                                <span class="font-semibold">Ver Película:</span><br>
                                @if ($pedido->estado === 'pagado' && $producto->pelicula && $pedido->tieneAcceso())
                                    {{-- Mostrar botón "Ver película" si ya la tiene --}}
                                    <a href="{{ route('producto.pelicula', ['id' => $producto->id]) }}"
                                        class="inline-block mt-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        🎬 Ver película
                                    </a>
                                @else
                                    {{-- Mostrar mensaje de "No disponible" si no tiene acceso --}}
                                    <span class="text-gray-500 text-sm">No disponible</span>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <p class="text-black dark:text-white">No se encontraron productos válidos para este pedido.</p>
            @endif
        @endif
    @elseif (session('pedido') && session('pedido') !== 'complete')
        <h1 class="text-2xl font-bold text-red-600 mb-4">Tu pedido NO ha podido procesarse</h1>
        <p class="text-black dark:text-white">
            Hubo un problema al procesar tu pedido. Por favor, intenta nuevamente o contacta con el soporte.
        </p>
    @endif

@endsection
