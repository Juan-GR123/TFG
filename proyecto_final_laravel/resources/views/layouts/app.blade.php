<?php
use App\Helpers\Utils;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>

<body class="flex flex-col min-h-screen bg-white dark:bg-black text-gray-800 dark:text-gray-100">
    {{-- Paso de datos globales a React --}}
    <script>
        window.appData = {
                user: @auth {
                    nombre: @json(Auth::user()->nombre), //Estas variables se pasan a json para que react las pueda leer
                    apellidos: @json(Auth::user()->apellidos),
                    rol: @json(Auth::user()->rol)
                }
            @else
                null
            @endauth ,
            categorias: @json(Utils::mostrar_categorias()),
            carrito: @json(\App\Helpers\Utils::Carrito_mostrar())
        };


        window.routes = {
            home: "{{ route('producto.index') }}",
            registro: "{{ route('usuario.registro') }}",
            sesion: "{{ route('usuario.sesion') }}",
            carrito: "{{ route('carrito.index') }}"
        };
    </script>


    <div id="contenedor" class="grid grid-rows-[auto,auto] flex-grow">
        <?php $categorias = Utils::mostrar_categorias(); ?>
        <nav class="flex flex-col sm:flex-row px-5 py-3 text-gray-700 dark:text-gray-300 border bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 overflow-x-auto"
            aria-label="Breadcrumb">
            <div class="flex justify-between items-center w-full">
                <!-- Breadcrumb de categorías -->
                <ol class="inline-flex items-center space-x-6 overflow-x-auto">
                    <li class="inline-flex items-center">
                        <a href="{{ route('producto.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white">
                            <svg class="w-3 h-3 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Inicio
                        </a>
                    </li>
                    <li>
                        @foreach ($categorias as $cat)
                    <li>
                        <a href="{{ route('categoria.ver', ['id' => $cat->id]) }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white">{{ $cat->nombre }}</a>
                    </li>
                    @endforeach

                    </li>
                </ol>
            </div>

            <!-- Enlaces de sesión y registro -->
            <ul
                class="ml-4 inline-flex flex-wrap items-center space-x-4 sm:space-x-8 justify-center lg:justify-end w-full">
                @guest
                    <li>
                        <a href="{{ route('usuario.sesion') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white">Iniciar
                            sesión</a>
                    </li>
                    <li class="registrarse_btn">
                        <a href="{{ route('usuario.registro') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-purple-300 via-indigo-400 to-cyan-200 border-0 border-transparent rounded-lg shadow-lg text-white text-lg px-0 py-0 cursor-pointer transition-all duration-300 hover:outline-none active:scale-95">
                            <span
                                class="bg-[#05062d] rounded-lg text-sm px-6 py-2 transition duration-300 hover:bg-transparent flex items-center justify-center">
                                Registrarse
                            </span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('usuario.logout') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white">Cerrar
                            sesión</a>
                    </li>
                @endguest
            </ul>

        </nav>

        <div class="w-full bg-gray-100 dark:bg-gray-900">
            <form action="{{ route('producto.buscar') }}" method="GET"
                class="p-2 search-bar max-w-md mx-auto w-full">
                <div class="flex w-full justify-center items-center">
                    <div class="relative w-full">
                        <input type="search" id="location-search" name="q"
                            class="block rounded-lg p-2.5 w-full z-20 text-sm bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-black dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Buscar producto" required />
                        <button type="submit"
                            class="absolute top-0 end-0 h-full p-2.5 text-sm font-medium text-white rounded-e-lg border border-blue-700 dark:border-red-700 focus:ring-4 focus:outline-none bg-blue-600 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 hover:bg-blue-700 focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Buscar</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <label class="switch text-sm text-black dark:text-white px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700">
        <input id="input" type="checkbox"  onclick="toggleTheme()"  />
        <div class="slider round">
            <div class="sun-moon">
                <svg id="moon-dot-1" class="moon-dot" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="moon-dot-2" class="moon-dot" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="moon-dot-3" class="moon-dot" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="light-ray-1" class="light-ray" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="light-ray-2" class="light-ray" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="light-ray-3" class="light-ray" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>

                <svg id="cloud-1" class="cloud-dark" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="cloud-2" class="cloud-dark" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="cloud-3" class="cloud-dark" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="cloud-4" class="cloud-light" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="cloud-5" class="cloud-light" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
                <svg id="cloud-6" class="cloud-light" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="50"></circle>
                </svg>
            </div>
            <div class="stars">
                <svg id="star-1" class="star" viewBox="0 0 20 20">
                    <path
                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z">
                    </path>
                </svg>
                <svg id="star-2" class="star" viewBox="0 0 20 20">
                    <path
                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z">
                    </path>
                </svg>
                <svg id="star-3" class="star" viewBox="0 0 20 20">
                    <path
                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z">
                    </path>
                </svg>
                <svg id="star-4" class="star" viewBox="0 0 20 20">
                    <path
                        d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z">
                    </path>
                </svg>
            </div>
        </div>
    </label>

 

        {{--  the @yield directive is used to display the contents of a given section. --}}
    <div id="contenido" class="flex-grow">
        <div id="react-tabs">
            <div id="blade-content">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="rounded-lg shadow-sm bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="{{ route('producto.index') }}"
                    class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('storage/uploads/RollAndPlay_Logo200px.png') }}" width="200px"
                        height="200px" />
                </a>
                <ul
                    class="flex flex-wrap items-center mb-6 text-sm font-medium sm:mb-0 text-gray-600 dark:text-gray-400">
                    <li><a href="{{route('sobreNosotros')}}"
                            class="hover:underline me-4 md:me-6 text-black hover:text-indigo-400 dark:text-white dark:hover:text-indigo-400">Sobre
                            Nosotros</a></li>
                    <li><a href="{{route('privacidad')}}"
                            class="hover:underline me-4 md:me-6 text-black hover:text-indigo-400 dark:text-white dark:hover:text-indigo-400">Política
                            de privacidad</a></li>
                </ul>
            </div>
            <hr class="my-6 sm:mx-auto border-gray-300 dark:border-gray-700 lg:my-2" />
            <span class="block text-sm sm:text-center text-gray-600 dark:text-gray-400">© 2025 <a
                    class=" hover:text-indigo-400 dark:hover:text-indigo-400">Roll&Play™</a>. All Rights
                Reserved.</span>
        </div>
    </footer>
    </div>

    <script>
                // Aplicar el tema guardado y actualizar el checkbox
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedTheme === 'dark' || (!savedTheme && prefersDark);

            if (isDark) {
                document.documentElement.classList.add('dark');
                document.getElementById('input').checked = true;
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('input').checked = false;
            }
        });

            //Revisa si el usuario ya eligió un tema (localStorage.getItem('theme')).

            // Si no, verifica si el sistema tiene preferencia por tema oscuro (prefers-color-scheme: dark).

            // Aplica el tema y actualiza el checkbox correspondiente.

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            document.getElementById('input').checked = isDark;
        }

        // Es la funcion que se le aplica al input para que cambie el tema de la pagina
   </script>

</body>

</html>
