@extends('layouts.app')

@section('content')
<div class="flex justify-center flex-col">
    <h1 class="text-2xl font-bold mb-4 text-black dark:text-white">Editar Categoría</h1>

    @if ($errors->any())
        <div class="text-red-600 mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('categoria.update', $categoria->id) }}" method="POST" class="space-y-4">
        @csrf
        <div class="w-full">
            <label for="nombre" class="block font-medium text-gray-400">Nombre de la categoría:</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre) }}" class="w-full border border-gray-400 dark:border-gray-600 text-black dark:text-white bg-white dark:bg-black p-2 rounded-md mb-6 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <button type="submit" class="primary-button">Actualizar</button>
        </div>

        
    </form>
@endsection
</div>
    
