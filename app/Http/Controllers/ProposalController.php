<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Afficher une liste de tous les devis créés.
     */
    public function index()
    {
        // Liste tous les devis créés
        $proposals = Proposal::all();
        return response()->json($proposals);
    }

    /**
     * Créer un nouveau devis.
     */
    public function store(Request $request)
    {
        // Valider les données d'entrée
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'client_id' => 'required|exists:clients,id', // Exemple de relation avec un client
            // Ajoutez d'autres règles de validation en fonction de vos besoins
        ]);

        // Créer un nouveau devis
        $proposal = Proposal::create($validatedData);
        return response()->json($proposal, 201);
    }

    /**
     * Afficher un devis spécifique.
     */
    public function show($id)
    {
        // Affiche un devis spécifique
        $proposal = Proposal::findOrFail($id);
        return response()->json($proposal);
    }

    /**
     * Mettre à jour un devis existant.
     */
    public function update(Request $request, $id)
    {
        // Valider les données d'entrée
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|string|max:50',
            'client_id' => 'sometimes|required|exists:clients,id', // Exemple de relation avec un client
            // Ajoutez d'autres règles de validation en fonction de vos besoins
        ]);

        // Met à jour un devis existant
        $proposal = Proposal::findOrFail($id);
        $proposal->update($validatedData);
        return response()->json($proposal);
    }

    /**
     * Supprimer un devis.
     */
    public function destroy($id)
    {
        // Supprime un devis
        $proposal = Proposal::findOrFail($id);
        $proposal->delete();
        return response()->json(null, 204);
    }
}
