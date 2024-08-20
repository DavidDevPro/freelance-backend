<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formula;

class FormulaController extends Controller
{
    /**
     * Afficher une liste de toutes les formules avec leurs éléments associés.
     */
    public function index()
    {
        $formulas = Formula::with(['defaultElements', 'options'])->get();

        $demoPackages = $formulas->map(function ($formula) {
            $groupedFeatures = $formula->defaultElements->groupBy('name')->map(function ($items, $name) {
                $descriptions = $items->pluck('description')->filter()->implode(', ');
                return $name . ($descriptions ? ' : ' . $descriptions : '');
            });

            return [
                'id' => 'package_' . $formula->idFormula,
                'name' => $formula->name,
                'description' => $formula->description,
                'features' => $groupedFeatures->values()->toArray(),
                'options' => $formula->options->map(function ($option) {
                    return $option->name . ($option->description ? ' : ' . $option->description : '');
                })->toArray(),
                'isMostPopular' => $formula->popular,
            ];
        });

        return response()->json($demoPackages);
    }

    /**
     * Créer une nouvelle formule.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'basePrice' => 'required|numeric',
            'popular' => 'boolean',
            'active' => 'boolean',
            // Ajoutez des règles de validation pour les éléments par défaut et les options si nécessaire
        ]);

        $formula = Formula::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Formula created successfully',
            'data' => $formula
        ], 201);
    }

    /**
     * Afficher une formule spécifique.
     */
    public function show($id)
    {
        $formula = Formula::with(['defaultElements', 'options'])->findOrFail($id);

        $groupedFeatures = $formula->defaultElements->groupBy('name')->map(function ($items, $name) {
            $descriptions = $items->pluck('description')->filter()->implode(', ');
            return $name . ($descriptions ? ' : ' . $descriptions : '');
        });

        $formattedFormula = [
            'id' => 'package_' . $formula->idFormula,
            'name' => $formula->name,
            'description' => $formula->description,
            'features' => $groupedFeatures->values()->toArray(),
            'options' => $formula->options->map(function ($option) {
                return $option->name . ($option->description ? ' : ' . $option->description : '');
            })->toArray(),
            'isMostPopular' => $formula->popular,
        ];

        return response()->json($formattedFormula);
    }

    /**
     * Mettre à jour une formule existante.
     */
    public function update(Request $request, $id)
    {
        $formula = Formula::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'basePrice' => 'sometimes|required|numeric',
            'popular' => 'boolean',
            'active' => 'boolean',
            // Ajoutez des règles de validation pour les éléments par défaut et les options si nécessaire
        ]);

        $formula->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Formula updated successfully',
            'data' => $formula
        ]);
    }

    /**
     * Supprimer une formule existante.
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
}
