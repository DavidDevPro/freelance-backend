<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formula;

class FormulaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/formulas",
     *     summary="Lister toutes les formules avec leurs éléments associés",
     *     operationId="getFormulas",
     *     tags={"Formulas"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des formules",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Formula")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $formulas = Formula::with(['defaultElements', 'customOptions'])->get();

        $demoPackages = $formulas->map(function ($formula) {
            return $this->formatFormula($formula);
        });

        return response()->json($demoPackages);
    }

    /**
     * @OA\Post(
     *     path="/api/formulas",
     *     summary="Créer une nouvelle formule",
     *     operationId="createFormula",
     *     tags={"Formulas"},
     *     @OA\RequestBody(
     *         description="Données de la formule à créer",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Formule créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateFormulaData($request);

        $formula = Formula::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Formula created successfully',
            'data' => $formula
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/formulas/{id}",
     *     summary="Afficher les détails d'une formule spécifique",
     *     operationId="getFormulaById",
     *     tags={"Formulas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la formule à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de la formule",
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formule non trouvée"
     *     )
     * )
     */
    public function show($id)
    {
        $formula = Formula::with(['defaultElements', 'customOptions'])->findOrFail($id);

        $formattedFormula = $this->formatFormula($formula);

        return response()->json($formattedFormula);
    }

    /**
     * @OA\Put(
     *     path="/api/formulas/{id}",
     *     summary="Mettre à jour une formule existante",
     *     operationId="updateFormula",
     *     tags={"Formulas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la formule à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données de la formule à mettre à jour",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formule mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formule non trouvée"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $formula = Formula::findOrFail($id);

        $validatedData = $this->validateFormulaData($request, $formula);

        $formula->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Formula updated successfully',
            'data' => $formula
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/formulas/{id}",
     *     summary="Supprimer une formule existante",
     *     operationId="deleteFormula",
     *     tags={"Formulas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la formule à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formule supprimée avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Formula deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Formule non trouvée"
     *     )
     * )
     */
    public function destroy($id)
    {
        $formula = Formula::findOrFail($id);
        $formula->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Formula deleted successfully'
        ]);
    }

    /**
     * Valider les données de la formule
     *
     * @param Request $request
     * @param Formula|null $formula
     * @return array
     */
    protected function validateFormulaData(Request $request, Formula $formula = null)
    {
        $uniqueNameRule = 'unique:formulas,name';

        if ($formula) {
            $uniqueNameRule .= ',' . $formula->id;
        }

        return $request->validate([
            'name' => 'required|string|max:255|' . $uniqueNameRule,
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'popular' => 'boolean',
            'active' => 'boolean',
            // Ajoutez des règles de validation pour les éléments par défaut et les options si nécessaire
        ]);
    }

    /**
     * Formater une formule avec ses éléments associés
     *
     * @param Formula $formula
     * @return array
     */
    protected function formatFormula(Formula $formula)
    {
        $groupedFeatures = $formula->defaultElements->groupBy('name')->map(function ($items, $name) {
            $descriptions = $items->pluck('description')->filter()->implode(', ');
            return $name . ($descriptions ? ' : ' . $descriptions : '');
        });

        return [
            'id' => 'package_' . $formula->id,
            'name' => $formula->name,
            'description' => $formula->description,
            'features' => $groupedFeatures->values()->toArray(),
            'options' => $formula->customOptions->map(function ($option) {
                return [
                    'name' => $option->name,
                    'description' => $option->description,
                ];
            })->toArray(),
            'isMostPopular' => $formula->popular,
        ];
    }
}
