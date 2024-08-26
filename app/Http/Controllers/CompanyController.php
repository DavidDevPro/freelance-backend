<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    // Afficher les informations de l'entreprise
    public function index()
    {
        $company = Company::first(); // On suppose qu'il n'y a qu'une seule entrée pour l'entreprise
        return response()->json($company);
    }

    // Afficher les informations de l'entreprise par ID
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    // Créer une nouvelle entreprise
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'siret' => 'nullable|string|max:14',
            'ape_code' => 'nullable|string|max:5',
            'iban' => 'nullable|string|max:34',
            'header_text' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ]);

        $company = Company::create($validatedData);
        return response()->json($company, 201);
    }

    // Mettre à jour les informations de l'entreprise
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'company_name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'siret' => 'nullable|string|max:14',
            'ape_code' => 'nullable|string|max:5',
            'iban' => 'nullable|string|max:34',
            'header_text' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ]);

        $company = Company::findOrFail($id);
        $company->update($validatedData);
        return response()->json($company);
    }

    // Supprimer une entreprise
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(null, 204);
    }
}
