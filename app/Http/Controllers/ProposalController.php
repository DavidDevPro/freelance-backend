<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
  public function index()
  {
    // Liste tous les devis créés
    $proposals = Proposal::all();
    return response()->json($proposals);
  }

  public function store(Request $request)
  {
    // Créer un nouveau devis
    $proposal = Proposal::create($request->all());
    return response()->json($proposal, 201);
  }

  public function show($id)
  {
    // Affiche un devis spécifique
    $proposal = Proposal::findOrFail($id);
    return response()->json($proposal);
  }

  public function update(Request $request, $id)
  {
    // Met à jour un devis existant
    $proposal = Proposal::findOrFail($id);
    $proposal->update($request->all());
    return response()->json($proposal);
  }

  public function destroy($id)
  {
    // Supprime un devis
    $proposal = Proposal::findOrFail($id);
    $proposal->delete();
    return response()->json(null, 204);
  }
}
