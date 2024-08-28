<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/company",
     *     summary="Afficher les informations de l'entreprise",
     *     operationId="getCompany",
     *     tags={"Company"},
     *     @OA\Response(
     *         response=200,
     *         description="Informations de l'entreprise",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     )
     * )
     */
    public function index()
    {
        // Récupérer la première entrée de l'entreprise
        $company = Company::first();
        return response()->json($company, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/company/{id}",
     *     summary="Afficher les informations de l'entreprise par ID",
     *     operationId="getCompanyById",
     *     tags={"Company"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'entreprise",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informations de l'entreprise",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entreprise non trouvée"
     *     )
     * )
     */
    public function show($id)
    {
        // Récupérer l'entreprise par ID
        $company = Company::findOrFail($id);
        return response()->json($company, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/company/{id}",
     *     summary="Mettre à jour les informations de l'entreprise",
     *     operationId="updateCompany",
     *     tags={"Company"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'entreprise à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données nécessaires pour mettre à jour une entreprise",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="company_name", type="string", example="Ma Société"),
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="email", type="string", format="email", example="contact@masociete.com"),
     *             @OA\Property(property="address", type="string", example="123 rue de l'Entreprise"),
     *             @OA\Property(property="postal_code", type="string", example="75000"),
     *             @OA\Property(property="city", type="string", example="Paris"),
     *             @OA\Property(property="siret", type="string", example="12345678901234"),
     *             @OA\Property(property="ape_code", type="string", example="1234Z"),
     *             @OA\Property(property="iban", type="string", example="FR7630006000011234567890189"),
     *             @OA\Property(property="header_text", type="string", example="En-tête personnalisée"),
     *             @OA\Property(property="footer_text", type="string", example="Pied de page personnalisé"),
     *             @OA\Property(property="updated_by", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entreprise mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Entreprise non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Valider les données de la requête
        $validatedData = $this->validateCompanyData($request);

        DB::beginTransaction();

        try {
            // Récupérer l'entreprise existante
            $company = Company::findOrFail($id);

            // Mettre à jour les informations de l'entreprise
            $company->update($validatedData);

            DB::commit(); // Valider la transaction

            return response()->json($company, 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            return response()->json(['error' => 'Erreur serveur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Valider les données de la requête pour l'opération de mise à jour
     *
     * @param Request $request
     * @return array
     */
    protected function validateCompanyData(Request $request)
    {
        return $request->validate([
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
            'updated_by' => 'nullable|integer|exists:users,id',
        ]);
    }
}
