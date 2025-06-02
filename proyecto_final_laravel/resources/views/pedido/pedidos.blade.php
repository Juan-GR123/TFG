@extends('layouts.app')

@section('content')
    @if (session('pedido') === 'failed')
        <div class="text-red-600 mb-4" id="mensaje">
            Error al intentar borrar el pedido. Por favor, inténtalo de nuevo.
        </div>
        @php
            session()->forget('pedido');
        @endphp
    @elseif (session('pedido') === 'eliminado')
        <div class="text-green-600 mb-4" id="mensaje">
            El pedido se ha borrado con éxito.
        </div>
        @php
            session()->forget('pedido');
        @endphp
    @endif

    <h1 class="text-2xl font-bold mb-4 text-black dark:text-white">
        {{ isset($gestion) && $gestion ? 'Gestionar pedidos' : 'Mis pedidos' }}
    </h1>

    <table class="w-full border border-gray-950 text-left">
        <div class="space-y-4 flex flex-col justify-center text-center">
            @foreach ($pedidos as $ped)
                    <div class="bg-white border border-gray-950 rounded-lg shadow-md p-10 hover:bg-black hover:text-white dark:text-black dark:hover:text-white transition-colors duration-300">
                        <div class="flex flex-col justify-center sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                 <!-- Aquí va el contenido de la tarjeta, como el título -->
                                 <span class="font-semibold ">Nº Pedido:</span>
                                <a href="{{ route('pedido.detalle', ['id' => $ped->id]) }}" class="rainbow-text animate-rainbow">
                                    {{ $ped->id }}
                                 </a>
                            </div>
                            <div>
                                <span class="font-semibold">Coste:</span>
                                {{ $ped->coste }}
                            </div>
                           
                            
                            <div>
                                <span class="font-semibold">Fecha:</span>
                                {{ $ped->fecha }}
                            </div>

                            <div>
                                <span class="font-semibold">Estado: </span>
                                {{ App\Helpers\Utils::estado($ped->estado) }}
                            </div>
                                
                        </div>      
                    </div>    
            @endforeach
        </div>    
    </table>

    <script>
        setTimeout(() => {
            const mensaje = document.getElementById('mensaje');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        }, 5000);
    </script>
@endsection
