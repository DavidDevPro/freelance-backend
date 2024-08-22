<?php

namespace App\Http\Controllers;

use App\Models\Civility;
use Illuminate\Http\Request;

class CivilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer toutes les civilités
        return response()->json(Civility::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider et créer une nouvelle civilité
        $validatedData = $request->validate([
            'shortLabel' => 'required|string|max:255|unique:civility',
            'longLabel' => 'required|string|max:255|unique:civility',
        ]);

        $civility = Civility::create($validatedData);

        return response()->json($civility, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer une seule civilité par ID
        $civility = Civility::find($id);

        if (!$civility) {
            return response()->json(['error' => 'Civility not found'], 404);
        }

        return response()->json($civility, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Valider et mettre à jour une civilité existante
        $civility = Civility::find($id);

        if (!$civility) {
            return response()->json(['error' => 'Civility not found'], 404);
        }

        $validatedData = $request->validate([
            'shortLabel' => 'sometimes|required|string|max:255|unique:civility,shortLabel,' . $id . ',idCivility',
            'longLabel' => 'sometimes|required|string|max:255|unique:civility,longLabel,' . $id . ',idCivility',
        ]);

        $civility->update($validatedData);

        return response()->json($civility, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Supprimer une civilité par ID
        $civility = Civility::find($id);

        if (!$civility) {
            return response()->json(['error' => 'Civility not found'], 404);
        }

        $civility->delete();

        return response()->json(null, 204);
    }
}
