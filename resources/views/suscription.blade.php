@extends('layouts.app')

@section('content')
<br>
    <!-- Header -->
    <div class="bg-white py-10 shadow-md rounded-3xl mx-80">
        <div class="container mx-auto text-center">
            <h1 class="text-3xl font-bold">Mejora tu Plan</h1>
            <p class="text-gray-600 mt-2">Accede a funciones premium y mejora tu productividad.</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Plan Gratuito -->
        <div class="border rounded-xl p-6 bg-white shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Plan Básico</h2>
                <p class="text-gray-600 mb-4">Ideal para usuarios individuales que quieran empezar.</p>

                <ul class="space-y-2 text-sm text-gray-700">
                    <li>✅ 1 equipo creado</li>
                    <li>✅ Unirse hasta 3 equipos</li>
                    <li>✅ Crear y gestionar tareas</li>
                    <li>❌ Acceso a calendario</li>
                    <li>❌ Equipos ilimitados</li>
                </ul>
            </div>
            <div class="mt-6">
                <p class="text-xl font-semibold text-gray-800">Gratis</p>
            </div>
        </div>

        <!-- Plan Premium -->
        <div class="border-2 border-blue-500 rounded-xl p-6 bg-blue-50 shadow-md flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold text-blue-700 mb-2">Plan Premium ⭐</h2>
                <p class="text-blue-600 mb-4">Para usuarios que buscan funcionalidad completa y sin límites.</p>

                <ul class="space-y-2 text-sm text-blue-800">
                    <li>✅ Equipos ilimitados</li>
                    <li>✅ Unirse a equipos sin límite</li>
                    <li>✅ Vista de calendario</li>
                    <li>✅ Soporte prioritario</li>
                </ul>
            </div>
            <div class="mt-6">
                <p class="text-xl font-semibold text-blue-700">3,99€ / mes</p>
                <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Mejorar Plan
                </button>
            </div>
        </div>
    </div>

@endsection