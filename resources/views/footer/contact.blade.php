@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <div class="bg-white shadow-md rounded-lg p-8">
        <h1 class="text-3xl font-bold mb-6">Contacto</h1>

        <p class="mb-4">
            Si tienes preguntas, sugerencias o necesitas ayuda, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte.
        </p>
        <h2 class="text-2xl font-semibold mt-6 mb-2">Correo electrónico</h2>
        <p class="mb-4">
            Puedes escribirnos a <a class="text-blue-600 hover:underline">soporte@cotasker.com</a>. Nuestro soporte técnico se pondrá en contacto lo antes posible.
        </p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">Redes sociales</h2>
        <p class="mb-4">
            También puedes seguirnos y contactar con nosotros a través de nuestras redes sociales:
        </p>
        <ul class="list-disc list-inside text-gray-700 mb-6">
            <li>Twitter: <a href="#" class="text-blue-600 hover:underline">@cotasker</a></li>
            <li>Facebook: <a href="#" class="text-blue-600 hover:underline">/cotasker</a></li>
            <li>Instagram: <a href="#" class="text-blue-600 hover:underline">cotasker</a></li>
        </ul>
    </div>
</div>
@endsection
