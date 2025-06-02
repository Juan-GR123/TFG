@extends('layouts.app')

@section('content')

<h1 class="text-2xl sm:text-3xl font-bold mb-6 text-black dark:text-white text-center">Política de privacidad</h1>

<div class="flex justify-center px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl p-4 border rounded-lg shadow-sm bg-blue-200 dark:bg-gray-800 border-gray-700">
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            En Roll&Play, valoramos tu privacidad y nos comprometemos a proteger los datos personales que nos proporcionas al usar nuestros servicios...
        </p>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl font-bold text-black dark:text-white">1. ¿Quiénes somos?</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            Roll&Play es una plataforma de alquiler de películas en línea...
        </p>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl font-bold text-black dark:text-white">2. ¿Qué datos recopilamos?</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg mb-4">Recopilamos y tratamos los siguientes datos personales:</p>
        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            <li class="text-gray-600 dark:text-gray-400">Nombre y apellidos</li>
            <li class="text-gray-600 dark:text-gray-400">Correo electrónico</li>
            <li class="text-gray-600 dark:text-gray-400">Dirección</li>
            <li class="text-gray-600 dark:text-gray-400">Historial de alquileres y compras</li>
            <li class="text-gray-600 dark:text-gray-400">Información de pago (procesada de forma segura por terceros)</li>
            <li class="text-gray-600 dark:text-gray-400">Datos de sesión (cookies, duración de visitas, interacciones)</li>
        </ul>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl font-bold text-black dark:text-white">3. ¿Para qué usamos tus datos?</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg mb-4">Usamos tus datos para:</p>
        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            <li class="text-gray-600 dark:text-gray-400">Gestionar tu cuenta de usuario</li>
            <li class="text-gray-600 dark:text-gray-400">Procesar pedidos y alquileres (sandbox)</li>
            <li class="text-gray-600 dark:text-gray-400">Enviarte confirmaciones por correo electrónico</li>
        </ul>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl font-bold text-black dark:text-white">4. ¿Compartimos tus datos?</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            No compartimos tus datos personales con terceros.
        </p>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl font-bold text-black dark:text-white">5. ¿Cuánto tiempo conservamos tus datos?</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            Conservamos tus datos mientras seas usuario activo...
        </p>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl font-bold text-black dark:text-white">6. Tus derechos</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg mb-4">Tienes derecho a:</p>
        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            <li class="text-gray-600 dark:text-gray-400">Acceder a tus datos personales</li>
            <li class="text-gray-600 dark:text-gray-400">Rectificar o eliminar tus datos</li>
        </ul>
    </div>
</div>

@endsection
