<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoTasker - Home Usuario</title>
    @vite(['resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <nav class="navbar bg-[#003772] sticky top-0 mx-0 shadow-md">
        <div class="container mx-auto flex items-center justify-between p-4 text-white">
            <!-- Logo -->
            <a class="text-xl font-bold" href="#">CoTasker</a>

            <!-- Menú principal -->
            <div class="hidden md:flex space-x-6">
                <a class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                    href="#">Inicio</a>
                <a class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                    href="#">Mis Equipos</a>
            </div>

            <!-- Menú usuario -->
            <div class="hidden md:flex space-x-6">
                <a class="relative flex items-center group" href="{{ route('profile.edit') }}">
                    <span class="mr-2">&#128100;</span>
                    <span
                        class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 group-hover:after:scale-x-100 after:transition-transform after:duration-300">Perfil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="relative after:block after:h-[3px] after:w-full after:bg-white after:scale-x-0 hover:after:scale-x-100 after:transition-transform after:duration-300"
                        type="submit">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <br>

    <header class="bg-white py-10 shadow-md rounded-3xl mx-20">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Sección de bienvenida -->
            <div class="flex-1 text-center">
                <h1 class="text-3xl font-bold">Bienvenido a CoTasker</h1>
                <p class="text-gray-600 mt-2">Organiza tus equipos de trabajo y gestiona tus tareas de manera eficiente.
                </p>
                <div class="mt-4">
                    <button onclick="document.getElementById('createTeamModal').style.display='block'"
                        class="btn-primary px-4 py-2 rounded">
                        Crear un Equipo
                    </button>
                </div>
            </div>

            <!-- Formulario para unirse a un equipo alineado a la derecha, más pequeño -->
            <div class="w-1/4 bg-white p-6 ml-6 ring-4 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Unirse a un Equipo</h2>
                <form action="{{ route('teams.join') }}" method="POST">
                    @csrf
                    <input type="text" placeholder="Código de equipo" name="join_code" required
                        class="w-full px-4 py-2 border rounded-lg mt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-700 transition duration-300">
                        Unirse
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Cajas de los equipos -->
    <section class="container mx-auto my-10 mb-20 content">
        <h2 class="text-2xl font-bold mb-4">Tus Equipos</h2>
        @if ($teams->isNotEmpty())
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($teams as $team)
                    <div class="card p-5 bg-white shadow-md rounded-lg flex justify-between items-center">
                        <div>
                            <a href="{{ route('teams.show', $team->id) }}"
                                class="text-xl font-bold text-blue-600 hover:underline">
                                {{ $team->name }}
                            </a>
                            <p class="text-gray-600">{{ $team->description }}</p>
                        </div>
                        <div class="flex items-center space-x-2 bg-gray-100 px-3 py-1 rounded-full">
                            <span class="text-lg font-semibold text-gray-700">{{ $team->users->count() }}</span>
                            <span class="text-xl">👥</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No tienes equipos creados aún.</p>
        @endif


    </section>



    <!-- Modal para crear equipo -->
    <div id="createTeamModal" class="fixed inset-0 justify-items-center z-50 bg-gray-900 bg-opacity-50"
        style="display:none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-20 mt-[140px]">
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

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 CoTasker. Todos los derechos reservados.</p>
        <ul class="flex justify-center space-x-4 mt-2">
            <li><a href="#" class="hover:underline">Términos y Condiciones</a></li>
            <li><a href="#" class="hover:underline">Política de Privacidad</a></li>
            <li><a href="#" class="hover:underline">Contacto</a></li>
        </ul>
    </footer>

    <script>
        //Cerrar modal si se hace clic fuera
        window.onclick = function (event) {
            if (event.target == document.getElementById('createTeamModal')) {
                document.getElementById('createTeamModal').style.display = "none";
            }
        }
    </script>
</body>

</html>