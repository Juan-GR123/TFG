@extends('layouts.app')

@section('content')

@if(isset($categoria))
    <h1 class="text-2xl font-bold mb-6 text-black dark:text-white">{{ $categoria->nombre }}</h1>

    @if($productos->isEmpty())
    <div class="container-cartas">
        <div class="card1"></div>
        <div class="card2"></div>
        <div class="card3 flex justify-center flex-col">
        <h2 class="text-xl font-bold mb-4 rainbow-text animate-rainbow" style="color:rgba(255, 255, 255, 0.5); text-shadow:none">Todavia no hay productos de esta categoria</h2>
        </div>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($productos as $producto)
            {{-- <div class="productos"> --}}
            
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
                    
                    @if(in_array($producto->id, $alquilados))  {{-- Verifica si el producto está en la lista de alquilados --}}
                        <a href="{{ route('producto.pelicula', ['id' => $producto->id]) }}" class="button">
                            <span class="label">Ver Película</span>
                            <span class="gradient-container">
                              <span class="gradient"></span>
                            </span>
                        </a>
                    @else
                        <a href="{{ url('carrito/add', ['id' => $producto->id]) }}" class="button">
                            <span class="label">+ Alquilar</span>
                            <span class="gradient-container">
                              <span class="gradient"></span>
                            </span>
                        </a>
                    @endif
                </div>
            {{-- </div> --}}  
        @endforeach
    </div>
    @endif
@else
    <h1>La categoría no existe</h1>
@endif

@endsection
