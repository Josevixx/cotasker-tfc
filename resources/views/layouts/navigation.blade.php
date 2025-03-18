<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div>
            <div class="hidden md:flex space-x-4">
                <a class="flex items-center" href="{{route('profile.edit')}}">
                    <span class="mr-2">&#128100;</span> Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar Sesión</button>
                </form>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>          
            </div>
        </div>
    </div>
</nav>