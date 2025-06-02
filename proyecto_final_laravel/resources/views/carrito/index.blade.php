@extends('layouts.app')

@section('content')

@if (session('error_carrito'))
    <div class="error_carrito">
        <strong class="rojo" id="mensaje">{{ session('error_carrito') }}</strong>
    </div>
@endif


   
    
    @if (!empty($carrito))
    <h1 class="text-2xl font-bold mb-4 text-black dark:text-white">Carrito de la compra</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
            @foreach ($carrito as $indice => $elemento)
                @php $producto = $elemento['producto']; @endphp
                <div class="border border-gray-700 p-4 rounded-lg bg-slate-400 dark:bg-[#111] shadow-md">
                    <div class="flex justify-center mb-3">
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/uploads/' . $producto->imagen) }}" class="w-20 h-auto object-cover rounded" alt="">
                        @else
                            <img src="{{ asset('storage/uploads/RollAndPlay_Logo200px.png') }}" class="img_carrito" width="200px" alt="">
                        @endif
                        
                    </div>
                    <div class="text-white space-y-2">
                        <div>
                            <span class="font-semibold text-black dark:text-white">Nombre:</span>
                            <a href="{{ route('producto.ver', $producto->id) }}" class="text-blue-600 hover:text-black dark:hover:text-white dark:text-blue-400 underline block">{{ $producto->nombre }}</a>
                        </div>
                    </div>
                    <div class="hidden md:block">>
                        <span class="font-semibold text-black dark:text-white">Descripción:</span>
                        <p class="text-sm text-gray-800 dark:text-gray-300">{{ $producto->descripcion}}</p>
                    </div>
                    <div class="mt-3">
                        {{-- <a href="{{ route('carrito.delete', $indice) }}" class="button button-carrito" id="quitar_producto">Quitar Producto</a> --}}
                        <a href="{{ route('carrito.delete', $indice) }}" class="inline-block px-4 py-2  bg-blue-600 dark:bg-red-600 text-white rounded hover:bg-blue-700 dark:hover:bg-red-700">
                            Quitar Producto
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex flex-col sm:flex-row md:flex-row gap-4">
            <a href="{{ route('pedido.hacer') }}" class="btn text-center bg-black text-white hover:text-white dark:bg-white dark:text-black" id="boton1">Realizar pedido</a>
            <a href="{{ route('carrito.deleteAll') }}" class="btn text-center bg-black text-white hover:text-white dark:bg-white dark:text-black" id="boton2">Vaciar carrito</a>
        </div>
    
    @else
      
        <div class="container-cartas">
            <div class="card1"></div>
            <div class="card2"></div>
            <div class="card3 flex justify-center flex-col">
            <h1 class="text-2xl md:text-3xl font-bold mb-4">Carrito de la compra</h1>
            <h2 class="text-xl md:text-2xl lg:text-lg font-bold mb-4 rainbow-text animate-rainbow" style="color:rgba(255, 255, 255, 0.5); text-shadow:none">El carrito está vacío, añade algún producto</h2>
            </div>
        </div>
    @endif


<script>
    setTimeout(() => {
        const mensaje = document.getElementById('mensaje');
        if (mensaje) {
            mensaje.style.display = 'none';
        }
    }, 5000);
</script>

@endsection