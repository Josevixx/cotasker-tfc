@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Calendario de Tareas</h1>
    <div id='calendar' class="bg-white p-4 rounded shadow"></div>
</div>
<script>
    /*
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: [
                @foreach ($tasks as $index => $task)
                    {
                        title: '{{ $task->title }} ({{ ucfirst(str_replace("_", " ", $task->status)) }})',
                        start: '{{ $task->due_date }}',
                        color: '{{ 
                            [
                                "pending" => "#facc15",
                                "in_progress" => "#3b82f6",
                                "review" => "#a855f7",
                                "paused" => "#9ca3af",
                                "completed" => "#22c55e",
                                "canceled" => "#ef4444",
                            ][$task->status] ?? "#d1d5db"
                        }}'
                    }@if (!$loop->last), @endif
                @endforeach
            ]
        });

        calendar.render();

        */

</script>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>


@endsection