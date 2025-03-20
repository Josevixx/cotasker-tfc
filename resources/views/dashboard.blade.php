<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoTasker - Home Usuario</title>
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <nav class="navbar shadow bg-[#003772] sticky top-0 z-50">
        <div class="container mx-auto flex items-center justify-between p-4 text-white">
            <a class="text-xl font-bold hover:text-gray-300" href="#">CoTasker</a>
            <div class="hidden md:flex space-x-4">
                <a class="hover:text-gray-300" href="#">Inicio</a>
                <a class="hover:text-gray-300" href="#">Mis Equipos</a>
            </div>
            <div class="hidden md:flex space-x-4">
                <a class="flex items-center hover:text-gray-300" href="{{ route('profile.edit') }}">
                    <span class="mr-2">&#128100;</span> Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="hover:text-gray-300" type="submit">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <header class="bg-white text-center py-10 shadow-md">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold">Bienvenido a CoTasker</h1>
            <p class="text-gray-600 mt-2">Organiza tus equipos de trabajo y gestiona tus tareas de manera eficiente.</p>
            <div class="mt-4">
                <button onclick="document.getElementById('createTeamModal').style.display='block'"
                    class="btn-primary px-4 py-2 rounded">
                    Crear un Equipo
                </button>
            </div>
        </div>
    </header>


    <section class="container mx-auto my-10 mb-20 content">
        <h2 class="text-2xl font-bold mb-4">Tus Equipos</h2>
        @if ($teams->isNotEmpty())
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($teams as $team)
                    <div class="card bg-white p-6 shadow-md rounded">
                        <h5 class="text-lg font-bold">{{ $team->name }}</h5>
                        <p class="text-gray-600">{{ $team->description }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No tienes equipos creados aún.</p>
        @endif

    </section>



    <!-- MODAL PARA CREAR EQUIPO -->
    <div id="createTeamModal" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50"
        style="display:none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-semibold mb-4">Crear Nuevo Equipo</h2>

            <form action="{{ route('teams.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Nombre del equipo</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Descripción (opcional)</label>
                    <textarea name="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('createTeamModal').style.display='none'"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 CoTasker. Todos los derechos reservados.</p>
        <ul class="flex justify-center space-x-4 mt-2">
            <li><a href="#" class="hover:underline">Términos y Condiciones</a></li>
            <li><a href="#" class="hover:underline">Política de Privacidad</a></li>
            <li><a href="#" class="hover:underline">Contacto</a></li>
        </ul>
    </footer>

    <script>
        // Cerrar modal si clic en el fondo
        window.onclick = function (event) {
            if (event.target == document.getElementById('createTeamModal')) {
                document.getElementById('createTeamModal').style.display = "none";
            }
        }
    </script>
</body>

</html>