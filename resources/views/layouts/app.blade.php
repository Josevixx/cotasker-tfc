<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CoTasker</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

</head>

<body class="antialiased">
    <div class="bg-gray-100 flex flex-col min-h-screen">

        <nav class="navbar bg-[#003772] sticky top-0 mx-0 shadow-md">
            <div class="container mx-auto flex items-center justify-between p-4 text-white">
                <!-- Logo -->
                <a class="text-xl font-bold" href="{{ route('dashboard')}}">CoTasker</a>

                <!-- Menú principal -->
                <div class="hidden md:flex space-x-6">
                    <a class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                        href="{{ route('dashboard')}}">Mis Equipos</a>
                    <a class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                        href="{{ route('suscription')}}">Suscripciones</a>
                </div>

                <!-- Menú usuario -->
                <div class="hidden md:flex space-x-6">
                    <a class="relative flex items-center group" href="{{ route('profile.edit') }}">
                        <span class="mr-2">&#128100;</span>
                        <span
                            class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 group-hover:after:scale-x-100 after:transition-transform after:duration-300">
                            Perfil
                        </span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                            type="submit">
                            <span>Cerrar Sesión</span>
                        </button>
                    </form>
                </div>

            </div>
        </nav>

        <main>
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif

        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2025 CoTasker. Todos los derechos reservados.</p>
            <ul class="flex justify-center space-x-4 mt-2">
                <li><a href="{{route('terms')}}" class="hover:underline">Términos y Condiciones</a></li>
                <li><a href="{{route('privacy')}}" class="hover:underline">Política de Privacidad</a></li>
                <li><a href="{{route('contact')}}" class="hover:underline">Contacto</a></li>
            </ul>
        </footer>
    </div>

</body>

</html>