<?php

namespace App\Http\Controllers;

use App\Models\Civility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CivilityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/civilities",
     *     summary="Récupérer la liste des civilités",
     *     operationId="getCivilities",
     *     tags={"Civilities"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des civilités",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Civility")
     *         )
     *     )
     * )
     */
    public function index()
    {
        // Récupérer toutes les civilités
        return response()->json(Civility::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/civilities",
     *     summary="Créer une nouvelle civilité",
     *     operationId="createCivility",
     *     tags={"Civilities"},
     *     @OA\RequestBody(
     *         description="Données nécessaires pour créer une civilité",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"shortLabel", "longLabel"},
     *             @OA\Property(property="shortLabel", type="string", example="Mr"),
     *             @OA\Property(property="longLabel", type="string", example="Monsieur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Civilité créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Civility")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Valider les données de la requête
        $validatedData = $this->validateCivilityData($request);

        // Démarrer une transaction pour garantir la cohérence des données
        DB::beginTransaction();

        try {
            // Créer une nouvelle civilité
            $civility = Civility::create($validatedData);

            DB::commit(); // Valider la transaction

            return response()->json($civility, 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            return response()->json(['error' => 'Erreur serveur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/civilities/{id}",
     *     summary="Récupérer une civilité par ID",
     *     operationId="getCivilityById",
     *     tags={"Civilities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la civilité",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de la civilité",
     *         @OA\JsonContent(ref="#/components/schemas/Civility")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Civilité non trouvée"
     *     )
     * )
     */
    public function show($id)
    {
        // Récupérer une seule civilité par ID
        $civility = Civility::find($id);

        if (!$civility) {
            return response()->json(['error' => 'Civilité non trouvée'], 404);
        }

        return response()->json($civility, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/civilities/{id}",
     *     summary="Mettre à jour une civilité",
     *     operationId="updateCivility",
     *     tags={"Civilities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la civilité à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données nécessaires pour mettre à jour une civilité",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="shortLabel", type="string", example="Mr"),
     *             @OA\Property(property="longLabel", type="string", example="Monsieur")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Civilité mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Civility")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Civilité non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Récupérer la civilité existante
        $civility = Civility::find($id);

        if (!$civility) {
            return response()->json(['error' => 'Civilité non trouvée'], 404);
        }

        // Valider les données de la requête
        $validatedData = $this->validateCivilityData($request, $id);

        DB::beginTransaction();

        try {
            // Mettre à jour la civilité
            $civility->update($validatedData);

            DB::commit();

            return response()->json($civility, 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            return response()->json(['error' => 'Erreur serveur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/civilities/{id}",
     *     summary="Supprimer une civilité",
     *     operationId="deleteCivility",
     *     tags={"Civilities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la civilité à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Civilité supprimée avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Civilité non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Récupérer la civilité par ID
        $civility = Civility::find($id);

        if (!$civility) {
            return response()->json(['error' => 'Civilité non trouvée'], 404);
        }

        DB::beginTransaction();

        try {
            // Supprimer la civilité
            $civility->delete();

            DB::commit();

            return response()->json(null, 204);

        } catch (\Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            return response()->json(['error' => 'Erreur serveur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Valider les données de la requête pour les opérations de store et update
     *
     * @param Request $request
     * @param int|null $id
     * @return array
     */
    protected function validateCivilityData(Request $request, $id = null)
    {
        return $request->validate([
            'shortLabel' => 'sometimes|required|string|max:255|unique:civilities,shortLabel,' . ($id ?? 'NULL') . ',id',
            'longLabel' => 'sometimes|required|string|max:255|unique:civilities,longLabel,' . ($id ?? 'NULL') . ',id',
        ]);
    }
}
