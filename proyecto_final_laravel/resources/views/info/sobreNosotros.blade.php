@extends('layouts.app')

@section('content')

<h1 class="text-2xl sm:text-3xl font-bold mb-6 text-black dark:text-white text-center">Sobre Nosotros</h1>

<div class="flex justify-center px-4 sm:px-6 lg:px-8 w-full">
    <div class="w-full max-w-4xl p-4 border rounded-lg shadow-sm sm:p-6 md:p-8 bg-blue-200 dark:bg-gray-800 border-gray-700 text-left sm:text-center">
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            En Roll&Play, amamos el cine tanto como tú. Nuestra misión es ofrecerte una experiencia de alquiler de películas rápida, sencilla y adaptada a tus gustos...
        </p>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl text-black font-bold dark:text-white">1. ¿Quiénes somos?</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            Somos un equipo de cinéfilos, desarrolladores y diseñadores con una visión común...
        </p>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl text-black font-bold dark:text-white">2. ¿Qué ofrecemos?</h2>
        <ul class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400 text-base sm:text-lg">
            <li class="text-gray-600 dark:text-gray-400">🎬 Un extenso catálogo de películas para todos los gustos</li>
            <li class="text-gray-600 dark:text-gray-400">⏳ Alquileres con tiempo limitado para que disfrutes del cine como antes</li>
            <li class="text-gray-600 dark:text-gray-400">📧 Notificaciones por email con confirmaciones y opciones para gestionar tus pedidos</li>
            <li class="text-gray-600 dark:text-gray-400">🛡️ Seguridad y privacidad en cada paso</li>
            <li class="text-gray-600 dark:text-gray-400">❤️ Un equipo que escucha tus sugerencias y mejora constantemente</li>
        </ul>

        <h2 class="mt-10 mb-4 text-xl sm:text-2xl text-black font-bold dark:text-white">3. Nuestra visión</h2>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg mb-6">
            Queremos que Roll&Play sea más que una plataforma: un espacio donde redescubrir el placer de ver películas...
        </p>

        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg mb-2">Gracias por confiar en Roll&Play.</p>
        <p class="text-gray-600 dark:text-gray-400 text-base sm:text-lg">¡Prepara las palomitas y dale al play!</p>
    </div>
</div>

@endsection
