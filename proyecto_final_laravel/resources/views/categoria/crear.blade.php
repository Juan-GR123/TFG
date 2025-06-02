@extends('layouts.app') {{-- Opcional: si usas un layout base --}}

@section('content')

<h1 class="text-2xl font-bold mb-4 text-black dark:text-white">Crear nueva Categoría</h1>

<!-- Muestra errores de validación -->
@if ($errors->any())
    <div class="error_categoria">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="rojo">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('categoria.save') }}" method="POST">
    @csrf
    <div class="form__group field">
        <input type="text" name="nombre" value="{{ old('nombre') }}" class="form__field text-black dark:text-white" placeholder="">
        <label for="nombre" class="form__label">Nombre</label>
    </div>

    <div class="flex justify-center mt-8">
        <button type="submit" class="primary-button">Guardar</button>
    </div>
</form>


@endsection