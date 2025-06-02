@extends('layouts.app')

@section('content')
    <div class="flex justify-center w-full">
        <div
            class="w-full p-4 border  rounded-lg shadow-sm sm:p-6 md:p-8 bg-gray-800 border-gray-700">

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="success mb-4 text-green-700">{{ session('success') }}</div>
            @endif

            {{-- Formulario de edición --}}
            <form class="space-y-6" action="{{ route('usuario.update2') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ $usuario->id }}">

                <div>
                    <label for="imagen"
                        class="flex justify-center mb-2 text-sm font-medium text-white">Imagen de
                        perfil</label>

                    <div class="mb-4 flex justify-center">
                        <label for="imagen" class="cursor-pointer relative group">
                            <img src="{{ $usuario->imagen ? asset('storage/uploads/' . $usuario->imagen) : asset('img/default-avatar.png') }}"
                                class="rounded-full shadow-md transition duration-300 ease-in-out group-hover:opacity-80"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="Avatar">
                            <span
                                class="absolute bottom-0 left-0 right-0 text-xs text-center bg-black bg-opacity-50 text-white py-1 opacity-0 group-hover:opacity-100">
                                Cambiar foto
                            </span>
                        </label>
                    </div>

                    <input type="file" name="imagen" id="imagen" class="hidden" accept="image/*">
                </div>


                <h5 class="text-xl font-medium text-white">Editar perfil de {{ $usuario->nombre }}</h5>

                <div class="w-full">
                    <label for="nombre"
                        class="block mb-2 text-sm font-medium text-white">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                        required
                        class="border text-sm rounded-lg block w-full p-2.5 ml-4 bg-gray-600 border-gray-500 text-white" />
                    @error('nombre')
                        <small class="rojo" id="mensaje">{{ $message }}</small>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="apellidos"
                        class="block mb-2 text-sm font-medium text-white">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos"
                        value="{{ old('apellidos', $usuario->apellidos) }}" required
                        class=" border text-sm rounded-lg block w-full p-2.5 ml-4 bg-gray-600 border-gray-500 text-white" />
                    @error('apellidos')
                        <small class="rojo" id="mensaje">{{ $message }}</small>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="email" class="block mb-2 text-sm font-medium  text-white">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" required
                        class="border text-sm rounded-lg block w-full p-2.5 ml-4 bg-gray-600 border-gray-500 text-white" />
                    @error('email')
                        <small class="rojo" id="mensaje">{{ $message }}</small>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="password" class="block mb-2 text-sm font-medium text-white">Nueva
                        contraseña (opcional)</label>
                    <input type="password" name="password" id="password" placeholder="••••••••"
                        class="border text-sm rounded-lg block w-full p-2.5 ml-4 bg-gray-600 border-gray-500 text-white" />
                    @error('password')
                        <small class="rojo" id="mensaje">{{ $message }}</small>
                    @enderror
                </div>

                <div class="w-full">
                    @if (Auth::user()->rol === 'admin')
                        <label for="rol">Rol:</label>
                        <select name="rol"
                            class="border border-gray-600 text-white bg-black p-2 ml-4 rounded-md mb-10 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="user" {{ $usuario->rol === 'user' ? 'selected' : '' }}>Usuario</option>
                            <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Administrador
                            </option>
                        </select><br>
                    @endif
                </div>

                <button type="submit"
                    class="w-full text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 bg-blue-600 hover:bg-blue-700">
                    Actualizar la cuenta
                </button>
            </form>

            {{-- Botón de eliminar cuenta --}}
            <a href="{{ route('usuario.eliminar', $usuario->id) }}"
                class="block text-center mt-4 w-full text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 bg-red-500 hover:bg-red-600"
                onclick="return confirm('¿Estás seguro de que deseas eliminar esta cuenta?');">
                Eliminar Cuenta
            </a>
        </div>
    </div>

    <div
        class="w-full p-4 border  rounded-lg shadow-sm sm:p-6 md:p-8 bg-gray-800 border-gray-700 mt-6">
        <h2 class="text-xl font-bold text-white mb-4">Historial de Pedidos</h2>

        @if ($pedidos->isEmpty())
            <p class=" text-gray-300">No tienes pedidos aún.</p>
        @else
            <table class="w-full border border-gray-700 text-left text-sm">
                <thead class=" bg-gray-700 text-gray-100">
                    <tr>
                        <th class="p-2 border">Nº Pedido</th>
                        <th class="p-2 border">Coste</th>
                        <th class="p-2 border">Fecha</th>
                        <th class="p-2 border">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $ped)
                        <tr class="border-t border-gray-600">
                            <td class="p-2 border">
                                <a href="{{ route('pedido.detalle', ['id' => $ped->id]) }}"
                                    class="text-blue-600 underline">
                                    {{ $ped->id }}
                                </a>
                            </td>
                            <td class="p-2 border">{{ $ped->coste }} €</td>
                            <td class="p-2 border">{{ $ped->fecha }}</td>
                            <td class="p-2 border">{{ App\Helpers\Utils::estado($ped->estado) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
