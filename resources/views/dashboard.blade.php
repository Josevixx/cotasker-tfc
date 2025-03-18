<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoTasker - Home Usuario</title>
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <nav class="navbar shadow">
        <div class="container mx-auto flex items-center justify-between p-4">
            <a class="text-xl font-bold" href="#">CoTasker</a>
            <div class="hidden md:flex space-x-4">
                <a href="#">Inicio</a>
                <a href="#">Mis Equipos</a>
            </div>
            <div class="hidden md:flex space-x-4">
                <a class="flex items-center" href="{{route('profile.edit')}}">
                    <span class="mr-2">&#128100;</span> Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <header class="bg-white text-center py-10 shadow-md">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold">Bienvenido a CoTasker</h1>
            <p class="text-gray-600 mt-2">Organiza tus equipos de trabajo y gestiona tus tareas de manera eficiente.</p>
            <div class="mt-4">
                <a href="#" class="btn-primary px-4 py-2 rounded">Crear un Equipo</a>
                <a href="#" class="btn-outline-primary px-4 py-2 rounded ml-2">Unirse a un Equipo</a>
            </div>
        </div>
    </header>

    <section class="container mx-auto my-10 content">
        <h2 class="text-2xl font-bold mb-4">Tus Equipos</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="card bg-white p-6 shadow-md rounded">
                <h5 class="text-lg font-bold">Equipo 1</h5>
                <p class="text-gray-600">Descripción breve del equipo.</p>
                <a href="#" class="btn-outline-primary px-4 py-2 rounded mt-2 inline-block">Ver Equipo</a>
            </div>
            <div class="card bg-white p-6 shadow-md rounded">
                <h5 class="text-lg font-bold">Equipo 2</h5>
                <p class="text-gray-600">Descripción breve del equipo.</p>
                <a href="#" class="btn-outline-primary px-4 py-2 rounded mt-2 inline-block">Ver Equipo</a>
            </div>
            <div class="card bg-white p-6 shadow-md rounded">
                <h5 class="text-lg font-bold" p-4>Equipo 3</h5>
                <p class="text-gray-600">Descripción breve del equipo.</p>
                <a href="#" class="btn-outline-primary px-4 py-2 rounded mt-2 inline-block">Ver Equipo</a>
            </div>

        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 CoTasker. Todos los derechos reservados.</p>
        <ul class="flex justify-center space-x-4 mt-2">
            <li><a href="#" class="hover:underline">Términos y Condiciones</a></li>
            <li><a href="#" class="hover:underline">Política de Privacidad</a></li>
            <li><a href="#" class="hover:underline">Contacto</a></li>
        </ul>
    </footer>
</body>

</html>