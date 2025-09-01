@php
// $routines es un array con las rutinas disponibles
// $selectedRoutine es la rutina actual seleccionada
// $routineData es el contenido de la rutina seleccionada
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rutinas de Gimnasio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body>
    <main class="container">
        <section class="logo-container">
            <img src="{{ asset('images/espacio-activo.jpeg') }}" alt="Logo Espacio Activo" class="logo">
            <img src="{{ asset('images/punto-fit.jpeg') }}" alt="Logo Punto Fit" class="logo">
        </section>

        <!-- Navegación de rutinas -->
        <div class="routine-navigation">
            @foreach($routines as $routineKey => $routineName)
                <button class="routine-button {{ $routineKey === $selectedRoutine ? 'active' : '' }}" 
                        data-routine="{{ $routineKey }}">
                    {{ $routineName }}
                </button>
            @endforeach
        </div>

        <!-- Navegación de días (solo si hay rutina seleccionada) -->
        @if(!empty($routineData))
        <div class="day-navigation">
            @foreach($routineData as $dayKey => $day)
                <button class="day-button" data-day="{{ $dayKey }}">
                    {{ ucfirst(str_replace('_', ' ', $dayKey)) }}
                    @if(!empty($day['nombre']))
                        : {{ $day['nombre'] }}
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Contenido de los días -->
        @forelse($routineData as $dayKey => $day)
        <section class="day-content" id="day-{{ $dayKey }}" style="display: {{ $loop->first ? 'block' : 'none' }}">
            <h2 class="day-header">
                {{ ucfirst(str_replace('_', ' ', $dayKey)) }}
                @if(!empty($day['nombre']))
                : {{ $day['nombre'] }}
                @endif
            </h2>

            <div class="day-blocks">
                @if(!empty($day['bloques']))
                @foreach($day['bloques'] as $block)
                <div class="block">
                    <h3 class="muted">{{ $block['nombre'] ?? 'Bloque' }}</h3>
                    <ul class="exercises">
                        @foreach(($block['ejercicios'] ?? []) as $exercise)
                        <li>
                            <strong>{{ $exercise['nombre'] ?? '' }}</strong>
                            @if(!empty($exercise['repeticiones']))
                            — <span class="muted">{{ $exercise['repeticiones'] }}</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
                @endif
            </div>
        </section>
        @empty
        <p>No se encontró contenido en esta rutina.</p>
        @endforelse
        @else
        <p>Selecciona una rutina para comenzar.</p>
        @endif
    </main>

    <!-- Cargar JavaScript -->
    <script src="{{ asset('js/routine.js') }}"></script>
</body>

</html> 