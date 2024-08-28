<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\MailService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Se connecter",
     *     operationId="login",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         description="Informations d'identification nécessaires pour le login",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"identifiant","password"},
     *             @OA\Property(property="identifiant", type="string", example="identifiant"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="token", type="string", example="token"),
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="identifiant", type="string", example="John Doe"),
     *             @OA\Property(property="urlPictureProfil", type="string", example="/profile_images/johndoe.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé"
     *     )
     * )
     */
    public function login(Request $request)
    {
        // Validation des données de la requête
        $validatedData = $this->validateLoginData($request);

        try {
            // Recherche de l'utilisateur par identifiant
            $user = User::where('identifiant', $validatedData['identifiant'])->first();

            // Vérification de l'utilisateur et du mot de passe
            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            // Démarrer une transaction pour garantir la cohérence des données
            DB::beginTransaction();

            // Charger explicitement la relation userPermission
            $user->load('userPermission');

            // Création d'un token d'authentification
            $plainTextToken = $user->createToken('authToken')->plainTextToken;

            // Mise à jour des champs utilisateur lors de la connexion
            $user->update([
                'email_verified_at' => now(),
                'isActive' => true,
            ]);

            DB::commit(); // Valider la transaction

            $userRole = $user->isAdmin() ? 'admin' : 'utilisateur';

            // Réponse JSON avec les informations de l'utilisateur et le token
            return response()->json([
                'success' => true,
                'id' => $user->id,
                'identifiant' => $user->identifiant,
                'token' => $plainTextToken,
                'urlPictureProfil' => $user->urlPictureProfil,
                'userRole' => $userRole,
            ]);

        } catch (\Exception $e) {
            // Si une erreur se produit, annuler toutes les opérations
            DB::rollBack();
            Log::error('Erreur lors de la connexion : ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Se déconnecter",
     *     operationId="logout",
     *     tags={"Authentification"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        // Récupère l'utilisateur authentifié
        $user = $request->user();

        if ($user) {
            // Mise à jour des champs utilisateur lors de la déconnexion
            $user->update([
                'isActive' => false,
            ]);

            // Révocation du token actuel de l'utilisateur
            $user->currentAccessToken()->delete();

            // Réponse JSON de succès
            return response()->json(['success' => true]);
        }

        // Si l'utilisateur n'est pas trouvé ou n'est pas authentifié, retournez success false sans message
        return response()->json(['success' => false], 401);
    }

    /**
     * Valider les données de la requête de connexion
     *
     * @param Request $request
     * @return array
     */
    protected function validateLoginData(Request $request)
    {
        return $request->validate([
            'identifiant' => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
