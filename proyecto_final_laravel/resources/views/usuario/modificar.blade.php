@extends('layouts.app')  <!-- Aquí haces referencia a tu layout principal de Laravel -->

@section('content')

<h1>Modificar Usuario</h1>

<form action="{{ route('usuario.update') }}" method="POST" class="modificar-usuario">
    @csrf
    <input type="hidden" name="id" value="{{ $usuarioDatos->id }}"> 

    <div class="form__group field">
        <input type="text" name="nombre" value="{{ old('nombre', $usuarioDatos->nombre) }}" class="form__field text-black dark:text-white" placeholder="" required><br>
        <label for="nombre" class="form__label">Nombre:</label>
        @error('nombre')
        <small class="rojo" id="mensaje">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="form__group field">
        <input type="text" name="apellidos" value="{{ old('apellidos', $usuarioDatos->apellidos) }}" class="form__field text-black dark:text-white" placeholder="" required><br>
        <label for="apellidos" class="form__label">Apellidos:</label>
        @error('apellidos')
        <small class="rojo" id="mensaje">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="form__group field">
        <input type="email" name="email" value="{{ old('email', $usuarioDatos->email) }}"  class="form__field text-black dark:text-white" placeholder="" required><br>
        <label for="email" class="form__label">Email:</label>
        @error('email')
        <small class="rojo" id="mensaje">{{ $message }}</small>
        @enderror
    </div>

    <div class="form__group field">
        <input type="password" name="password" id="password" class="form__field text-black dark:text-white" placeholder="••••••••"br>
        <label for="password" class="form__label">Contraseña:</label>
        @error('password')
        <small class="rojo" id="mensaje">{{ $message }}</small>
        @enderror
    </div>

    @if (Auth::user()->rol === 'admin')
        <label for="rol">Rol:</label>
        <select name="rol" class="border border-gray-600 text-white bg-black p-2 rounded-md mb-10 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <option value="user" {{ $usuarioDatos->rol === 'user' ? 'selected' : '' }}>Usuario</option>
            <option value="admin" {{ $usuarioDatos->rol === 'admin' ? 'selected' : '' }}>Administrador</option>
        </select><br>
    @endif

    <div class="button-borders">
        <button type="submit" class="primary-button">Guardar cambios</button>
      </div>
</form>

@endsection
