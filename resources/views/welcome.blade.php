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
    <nav class="bg-[#003772] p-4 shadow">
        <div class="container mx-auto flex items-center justify-between">
            <a class="text-white text-xl font-bold ml-4" href="#">CoTasker</a>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white mr-4 hover:text-gray-300">Ir al Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white mr-4 hover:text-gray-300">Iniciar Sesión</a>
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <header class="hero">
        <h1 class="text-3xl font-bold">Organiza tu trabajo en equipo de manera eficiente</h1>
        <p class="text-lg mt-4">Gestiona tareas, colabora con tu equipo y alcanza tus objetivos.</p>
        <a href="{{ route('register') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded text-lg mt-6 inline-block">Empieza
            Gratis</a>
    </header>

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

    <footer class="bg-[#003772] text-white text-center py-6 mt-auto">
        <p>&copy; 2025 CoTasker. Todos los derechos reservados.</p>
        <ul class="flex justify-center space-x-4 mt-2">
            <li><a href="#" class="hover:underline">Términos y Condiciones</a></li>
            <li><a href="#" class="hover:underline">Política de Privacidad</a></li>
            <li><a href="#" class="hover:underline">Contacto</a></li>
        </ul>
    </footer>
</body>

</html>