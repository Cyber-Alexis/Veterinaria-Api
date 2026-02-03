<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    public function index()
    {
        $animales = Animal::with('dueno')->get();
        return response()->json($animales, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:perro,gato,hamster,conejo',
            'peso' => 'required|numeric|min:0',
            'enfermedad' => 'required|string|max:255',
            'comentarios' => 'nullable|string',
            'dueno_id' => 'required|exists:duenos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $animal = Animal::create($request->all());
        $animal->load('dueno');
        return response()->json($animal, 201);
    }

    public function show(string $id)
    {
        $animal = Animal::with('dueno')->find($id);

        if (!$animal) {
            return response()->json(['error' => 'Animal no encontrado'], 404);
        }

        return response()->json($animal, 200);
    }

    public function update(Request $request, string $id)
    {
        $animal = Animal::find($id);

        if (!$animal) {
            return response()->json(['error' => 'Animal no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:perro,gato,hamster,conejo',
            'peso' => 'required|numeric|min:0',
            'enfermedad' => 'required|string|max:255',
            'comentarios' => 'nullable|string',
            'dueno_id' => 'required|exists:duenos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $animal->update($request->all());
        $animal->load('dueno');
        return response()->json($animal, 200);
    }

    public function destroy(string $id)
    {
        $animal = Animal::find($id);

        if (!$animal) {
            return response()->json(['error' => 'Animal no encontrado'], 404);
        }

        $animal->delete();
        return response()->json(['mensaje' => 'Eliminado correctamente'], 200);
    }
}