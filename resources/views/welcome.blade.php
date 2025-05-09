<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoTasker</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/css/welcome.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Nav -->
    <nav class="bg-[#003772] p-4 shadow">
        <div class="container mx-auto flex items-center justify-between">
            <a class="text-white text-xl font-bold ml-4" href="#">CoTasker</a>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Header -->
    <header class="hero">
        <h1 class="text-3xl text-gray-800 font-bold">Organiza tu trabajo en equipo de manera eficiente</h1>
        <p class="text-lg text-gray-800 mt-4">Gestiona tareas, colabora con tu equipo y alcanza tus objetivos.</p>
        <a href="{{ route('register') }}"
            class="bg-green-600 hover:bg-green-700 transtion duration-300 text-white px-6 py-3 rounded text-lg mt-6 inline-block">Empieza
            Gratis</a>
    </header>

    <!-- Seccion de Información -->
    <section class="container mx-auto my-16 text-center">
        <h2 class="text-3xl font-bold mb-6">¿Cómo funciona?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <i class="ph ph-users text-6xl text-[#003772]"></i>
                <h4 class="text-xl font-bold mt-4">Crea un equipo</h4>
                <p class="text-gray-600">Registra tu equipo y añade miembros fácilmente.</p>
            </div>
            <div>
                <i class="ph ph-list-checks text-6xl text-[#003772]"></i>
                <h4 class="text-xl font-bold mt-4">Organiza tareas</h4>
                <p class="text-gray-600">Asigna tareas y mantén un control eficiente del trabajo.</p>
            </div>
            <div>
                <i class="ph ph-chart-line text-6xl text-[#003772]"></i>
                <h4 class="text-xl font-bold mt-4">Optimiza tu productividad</h4>
                <p class="text-gray-600">Visualiza el progreso y mejora la colaboración.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 CoTasker. Todos los derechos reservados.</p>
        <ul class="flex justify-center space-x-4 mt-2">
            <li><a href="{{route('terms')}}" class="hover:underline">Términos y Condiciones</a></li>
            <li><a href="{{route('privacy')}}" class="hover:underline">Política de Privacidad</a></li>
            <li><a href="{{route('contact')}}" class="hover:underline">Contacto</a></li>
        </ul>
    </footer>
</body>

</html>