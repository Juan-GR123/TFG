@extends('layouts.app')  <!-- Aquí haces referencia a tu layout principal de Laravel -->

@section('content')

<h1 class="text-2xl font-bold mb-6 text-black dark:text-white">Listado de Usuarios</h1>

{{-- Mensajes de éxito o error después de eliminar --}}
@if (session('delete'))
    <div class="{{ session('delete') == 'complete' ? 'success' : 'error' }}">
        <strong>
            {{ session('delete') == 'complete' ? 'Usuario eliminado correctamente.' : 'Error al eliminar usuario.' }}
        </strong>
    </div>
@endif

{{-- Mensaje de error al actualizar --}}
@if (session('error_update'))
    <div class="error_update">
        <strong class="rojo">{{ session('error_update') }}</strong>
    </div>
@endif


    {{-- Diseño responsive tipo tabla para pantallas grandes y "tarjeta" en móviles --}}
<div class="space-y-4">
    @foreach ($usuarios as $usuario)
        <div class="bg-white text-black dark:bg-black dark:text-white border border-gray-300 rounded-lg shadow-md p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="space-y-2 text-sm sm:text-base">
                <div><span class="font-semibold">ID:</span> {{ $usuario->id }}</div>
                <div><span class="font-semibold">Nombre:</span> {{ $usuario->nombre }}</div>
                <div><span class="font-semibold">Apellidos:</span> {{ $usuario->apellidos }}</div>
                <div><span class="font-semibold">Email:</span> {{ $usuario->email }}</div>
                <div><span class="font-semibold">Rol:</span> {{ $usuario->rol }}</div>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-4 flex space-x-4">
                <a href="{{ route('usuario.editar', ['id' => $usuario->id]) }}" class="text-blue-600 hover:text-black">Editar</a>
                <a href="{{ route('usuario.eliminar', ['id' => $usuario->id]) }}" class="text-red-600 hover:text-black">Eliminar</a>
            </div>
        </div>
    @endforeach
</div>



@endsection