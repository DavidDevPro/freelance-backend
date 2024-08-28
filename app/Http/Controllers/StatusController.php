<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/statuses",
     *     summary="Lister tous les statuts",
     *     operationId="getStatuses",
     *     tags={"Statuses"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des statuts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Status")
     *         )
     *     )
     * )
     */
    public function index()
    {
        // Liste tous les statuts
        $statuses = Status::all();
        return response()->json($statuses);
    }

    /**
     * @OA\Get(
     *     path="/api/statuses/{id}",
     *     summary="Afficher les détails d'un statut spécifique",
     *     operationId="getStatusById",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du statut",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statut non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        // Affiche un statut spécifique
        $status = Status::findOrFail($id);
        return response()->json($status);
    }

    /**
     * @OA\Post(
     *     path="/api/statuses",
     *     summary="Créer un nouveau statut",
     *     operationId="createStatus",
     *     tags={"Statuses"},
     *     @OA\RequestBody(
     *         description="Données du statut à créer",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Statut créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
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
        $validatedData = $this->validateStatusData($request);

        // Créer un nouveau statut
        $status = Status::create($validatedData);
        return response()->json($status, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/statuses/{id}",
     *     summary="Mettre à jour un statut existant",
     *     operationId="updateStatus",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données du statut à mettre à jour",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Statut mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statut non trouvé"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Valider les données d'entrée
        $validatedData = $this->validateStatusData($request);

        // Met à jour un statut existant
        $status = Status::findOrFail($id);
        $status->update($validatedData);
        return response()->json($status);
    }

    /**
     * @OA\Delete(
     *     path="/api/statuses/{id}",
     *     summary="Supprimer un statut",
     *     operationId="deleteStatus",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du statut à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Statut supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Statut non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Supprime un statut
        $status = Status::findOrFail($id);
        $status->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/statuses/entity/{entityType}",
     *     summary="Lister les statuts par type d'entité",
     *     operationId="getStatusesByEntityType",
     *     tags={"Statuses"},
     *     @OA\Parameter(
     *         name="entityType",
     *         in="path",
     *         required=true,
     *         description="Type d'entité pour filtrer les statuts",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des statuts pour le type d'entité spécifié",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Status")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Aucun statut trouvé pour ce type d'entité"
     *     )
     * )
     */
    public function getStatusesByEntityType($entityType)
    {
        // Récupère les statuts en fonction du type d'entité
        $statuses = Status::where('entity_type', $entityType)->get();
        return response()->json($statuses);
    }

    /**
     * Valider les données du statut
     *
     * @param Request $request
     * @return array
     */
    protected function validateStatusData(Request $request)
    {
        return $request->validate([
            'label_status' => 'required|string|max:255',
            'entity_type' => 'required|string|max:255',
        ]);
    }
}
