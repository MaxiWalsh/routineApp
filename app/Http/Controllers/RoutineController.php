<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RoutineController extends Controller
{
    public function index()
    {
        // Obtener todas las rutinas disponibles
        $routines = $this->getAvailableRoutines();
        
        // Obtener la rutina seleccionada (por defecto la primera)
        $selectedRoutine = request('routine', array_key_first($routines));
        
        // Cargar la rutina específica
        $routineData = $this->loadRoutine($selectedRoutine);
        
        return view('routine.index', [
            'routines' => $routines,
            'selectedRoutine' => $selectedRoutine,
            'routineData' => $routineData,
        ]);
    }

    private function getAvailableRoutines()
    {
        // Lista de rutinas disponibles
        return [
            'fuerza_1' => 'Fuerza 1',
            'fuerza_2' => 'Fuerza 2',
        ];
    }

    private function loadRoutine($routineName)
    {
        // Mapear nombres de rutina a nombres de archivo
        $fileMap = [
            'fuerza_1' => 'fuerza1.json',  // El archivo se llama fuerza1.json
            'fuerza_2' => 'fuerza2.json',  // El archivo se llama fuerza2.json
        ];
        
        $fileName = $fileMap[$routineName] ?? $routineName . '.json';
        $path = base_path($fileName);
        
        if (File::exists($path)) {
            $json = File::get($path);
            $data = json_decode($json, true);
            
            // Mapear nombres de rutina a claves del JSON
            $jsonKeyMap = [
                'fuerza_1' => 'fuerza_1',  // El JSON tiene clave "fuerza_1"
                'fuerza_2' => 'fuerza_2',  // El JSON tiene clave "fuerza_2"
            ];
            
            $jsonKey = $jsonKeyMap[$routineName] ?? $routineName;
            return $data[$jsonKey] ?? [];
        }
        
        return [];
    }
}