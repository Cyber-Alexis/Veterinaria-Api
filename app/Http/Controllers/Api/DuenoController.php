<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dueno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DuenoController extends Controller
{
    public function index()
    {
        $duenos = Dueno::with('animales')->get();
        return response()->json($duenos, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $dueno = Dueno::create($request->all());
        return response()->json($dueno, 201);
    }

    public function show(string $id)
    {
        $dueno = Dueno::with('animales')->find($id);

        if (!$dueno) {
            return response()->json(['error' => 'Dueño no encontrado'], 404);
        }

        return response()->json($dueno, 200);
    }

    public function update(Request $request, string $id)
    {
        $dueno = Dueno::find($id);

        if (!$dueno) {
            return response()->json(['error' => 'Dueño no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $dueno->update($request->all());
        return response()->json($dueno, 200);
    }

    public function destroy(string $id)
    {
        $dueno = Dueno::find($id);

        if (!$dueno) {
            return response()->json(['error' => 'Dueño no encontrado'], 404);
        }

        $dueno->delete();
        return response()->json(['mensaje' => 'Eliminado correctamente'], 200);
    }
}