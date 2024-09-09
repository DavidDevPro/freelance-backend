<?php

namespace App\Http\Controllers;

use App\Models\Formula;
use App\Models\Proposal;
use App\Models\Status;
use App\Services\UniqueIdentifierService;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/proposals",
     *     summary="Lister tous les devis créés",
     *     operationId="getProposals",
     *     tags={"Proposals"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des devis",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Proposal")
     *         )
     *     )
     * )
     */
    public function index()
    {
        // Liste tous les devis créés
        $proposals = Proposal::all();
        return response()->json($proposals);
    }

    /**
     * @OA\Post(
     *     path="/api/proposals",
     *     summary="Créer un nouveau devis",
     *     operationId="createProposal",
     *     tags={"Proposals"},
     *     @OA\RequestBody(
     *         description="Données du devis à créer",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Proposal")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Devis créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Proposal")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Valider les données d'entrée
        $validatedData = $this->validateProposalData($request);

        // Créer un nouveau devis
        $proposal = Proposal::create($validatedData);
        return response()->json($proposal, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/proposals/{id}",
     *     summary="Afficher les détails d'un devis spécifique",
     *     operationId="getProposalById",
     *     tags={"Proposals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du devis à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du devis",
     *         @OA\JsonContent(ref="#/components/schemas/Proposal")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Devis non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        // Affiche un devis spécifique
        $proposal = Proposal::findOrFail($id);
        return response()->json($proposal);
    }

    /**
     * @OA\Put(
     *     path="/api/proposals/{id}",
     *     summary="Mettre à jour un devis existant",
     *     operationId="updateProposal",
     *     tags={"Proposals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du devis à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données du devis à mettre à jour",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Proposal")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Devis mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Proposal")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Devis non trouvé"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Valider les données d'entrée
        $validatedData = $this->validateProposalData($request, $id);

        // Met à jour un devis existant
        $proposal = Proposal::findOrFail($id);
        $proposal->update($validatedData);
        return response()->json($proposal);
    }

    /**
     * @OA\Delete(
     *     path="/api/proposals/{id}",
     *     summary="Supprimer un devis",
     *     operationId="deleteProposal",
     *     tags={"Proposals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du devis à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Devis supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Devis non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Supprime un devis
        $proposal = Proposal::findOrFail($id);
        $proposal->delete();
        return response()->json(null, 204);
    }

    /**
     * Créer un devis basé sur les données validées, le client et l'utilisateur
     *
     * @param array $validatedData
     * @param \App\Models\Customer $customer
     * @param \App\Models\User $user
     * @return \App\Models\Proposal
     */
    public function createProposal(array $validatedData, $customer, $user)
    {
        // Chercher l'ID de la formule correspondante
        $formula = Formula::where('name', $validatedData['formule'])->first();
    
        // Vérifier si la formule a été trouvée
        if (!$formula) {
            throw new \Exception('La formule spécifiée est introuvable.');
        }
    
        // Créer la proposition
        return Proposal::create([
            'proposal_number' => UniqueIdentifierService::generateProposalNumber($customer->customer_number),
            'formula_id' => $formula->id, // Associer l'ID de la formule trouvée
            'supplementalInfo' => $validatedData['supplementalInfo'] ?? null,
            'amount' => 0,
            'issue_date' => now(),
            'expiry_date' => now()->addDays(30),
            'customer_id' => $customer->id,
            'status_id' => Status::where('label_status', 'En Attente')->first()->id,
            'created_by' => $user->id,
        ]);
    }

    /**
     * Valider les données du devis
     *
     * @param Request $request
     * @param int|null $id
     * @return array
     */
    protected function validateProposalData(Request $request, $id = null)
    {
        return $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|string|max:50',
            'client_id' => 'sometimes|required|exists:clients,id',
        ]);
    }
}
