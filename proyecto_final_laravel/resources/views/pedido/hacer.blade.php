@extends('layouts.app') {{-- Usa tu layout principal si lo tienes --}}

@section('content')
    @if (session('pedido') == 'complete')
        <strong class="text-green-600" id="mensaje">Pedido realizado correctamente</strong>
    @elseif (session('pedido') == 'failed')
        <strong class="text-red-600" id="mensaje">Los datos del pedido son erroneos, introduce bien los datos</strong>
    @endif

    @php
        session()->forget('pedido');
    @endphp

    @auth
        <h1 class="text-2xl font-bold mb-4 text-black dark:text-white">Hacer pedido</h1>
        <p class="mb-4">
            <a href="{{ route('carrito.index') }}" class="text-blue-500 hover:text-black underline dark:text-blue-500 dark:hover:text-white">Ver los productos y el precio del pedido</a>
        </p>

        <form action="{{ route('pedido.pagar') }}" method="POST" class="space-y-4">
            @csrf

                <div class="form__group field">
                    <input type="text" name="provincia" required class="border rounded px-2 py-1 w-full form__field text-black dark:text-white" placeholder="">
                    <label for="provincia" class="block font-semibold form__label">Provincia</label>
                </div>

                <div class="form__group field">
                    <input type="text" name="localidad" required class="border rounded px-2 py-1 w-full form__field text-black dark:text-white"  placeholder="">
                    <label for="localidad" class="block font-semibold form__label">Localidad</label>
                </div>

                <div class="form__group field">
                    <input type="text" name="direccion" required class="border rounded px-2 py-1 w-full form__field text-black dark:text-white"  placeholder="">
                    <label for="direccion" class="block font-semibold form__label">Dirección</label>
                </div>

                <div class="form__group field">
                    <input type="number" name="tiempo" required class="border rounded px-2 py-1 w-full form__field text-black dark:text-white"  placeholder="10€ por mes">
                    <label for="tiempo" class="block font-semibold form__label">Numero de meses de alquiler</label>
                </div>

                <div class="button-borders">
                    <button type="submit" class="primary-button"> Confirmar pedido
                    </button>
                  </div>
        </form>
    @else
        {{-- <h1 class="text-xl font-bold">Necesitas estar identificado</h1>
        <p class="text-gray-700">Necesitas estar logueado en la web para poder realizar tu pedido</p> --}}   
        <div class="container-cartas">
            <div class="card1"></div>
            <div class="card2"></div>
            <div class="card3">
            <h1 class="text-2xl font-bold">Lo sentimos, pero para hacer un pedido necesitas iniciar sesion</h1>
            </div>
        </div>
  
    @endauth

    <script>
        setTimeout(() => {
            const mensaje = document.getElementById('mensaje');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        }, 5000);
    </script>
@endsection
