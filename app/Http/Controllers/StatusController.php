<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    // Afficher la liste de tous les statuts
    public function index()
    {
        $statuses = Status::all();
        return response()->json($statuses);
    }

    // Afficher un statut spécifique par ID
    public function show($id)
    {
        $status = Status::findOrFail($id);
        return response()->json($status);
    }

    // Créer un nouveau statut
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label_status' => 'required|string|max:255',
            'entity_type' => 'required|string|max:255',
        ]);

        $status = Status::create($validatedData);
        return response()->json($status, 201);
    }

    // Mettre à jour un statut existant
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'label_status' => 'sometimes|required|string|max:255',
            'entity_type' => 'sometimes|required|string|max:255',
        ]);

        $status = Status::findOrFail($id);
        $status->update($validatedData);
        return response()->json($status);
    }

    // Supprimer un statut
    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();
        return response()->json(null, 204);
    }

    public function getStatussByEntityType($entityType)
    {
        $statuses = Status::where('entity_type', $entityType)->get();
        return response()->json($statuses);
    }
    
}
