@extends('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Mis Tareas</h1>

    @if($tasks->isEmpty())
        <p>No tienes tareas asignadas.</p>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-200 text-left text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-3">Título</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Fecha límite</th>
                        <th class="px-6 py-3">Lista</th>
                        <th class="px-6 py-3">Equipo</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($tasks as $task)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $task->title }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-sm font-medium {{ $statusColors[$task->status] }}">
                                    {{ $statusTexts[$task->status] ?? ucfirst($task->status) }}
                                </span>                                
                            </td>
                            <td class="px-6 py-4">{{ $task->due_date ? Carbon::parse($task->due_date)->format('d/m/Y') : 'Sin fecha' }}</td>
                            <td class="px-6 py-4">{{ $task->taskList->name ?? 'N/A' }}</td>
                            <td class="px-6">
                                {{ $task->taskList->team->name ?? 'Sin equipo' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
