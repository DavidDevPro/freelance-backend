<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\MailService;

class UserController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Activer un utilisateur.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->isActive = true;
            $user->save();

            // Récupérer le client associé à cet utilisateur
            $customer = Customer::where('user_id', $user->id)->first();
            if ($customer) {
                // Envoyer un email de notification pour l'activation du compte
                $this->mailService->sendAccountCreationEmail($user->email, $user->identifiant, $customer->first_name, $customer->last_name);
                // Envoyer l'email avec le mot de passe (utilisant le prénom du client comme mot de passe par défaut)
                $this->mailService->sendPasswordEmail($user->email, $customer->first_name);

                return response()->json(['message' => 'User activated successfully'], 200);
            }

            return response()->json(['message' => 'Customer not found for this user'], 404);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Désactiver un utilisateur.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->isActive = false;
            $user->save();

            return response()->json(['message' => 'User deactivated successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Envoyer un e-mail lorsque le statut du client passe de prospect à client.
     *
     * @param  string  $email
     * @param  string  $identifier
     * @param  string  $firstName
     * @param  string  $lastName
     * @return void
     */
    public function sendClientWelcomeEmail($email, $identifier, $firstName, $lastName)
    {
        $this->mailService->sendAccountCreationEmail($email, $identifier, $firstName, $lastName);
        $this->mailService->sendPasswordEmail($email, $firstName);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="S'inscrire",
     *     operationId="register",
     *     tags={"Utilisateur"},
     *     @OA\RequestBody(
     *         description="Informations nécessaires pour l'inscription",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"firstName", "lastName", "password", "email", "userRights"},
     *             @OA\Property(property="firstName", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="email@email.fr"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *             @OA\Property(property="userRights", type="string", example="admin")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inscription réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="token", type="string", example="token"),
     *             @OA\Property(property="idUser", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'password' => 'required|string|min:4',
            'email' => 'required|string|email|max:255',
            'userRights' => 'required|integer|exists:user_permissions,id',
            'profileImage' => 'nullable|image|max:10240|mimes:jpg,jpeg,png'
        ]);

        $identifier = User::generateIdentifier($request->firstName, $request->lastName);

        $user = User::create([
            'identifiant' => $identifier,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'user_permission_id' => $request->userRights,
        ]);

        // Gestion de l'image de profil
        if ($request->hasFile('profileImage')) {
            if ($request->file('profileImage')->isValid()) {
                $originalFilename = $request->file('profileImage')->getClientOriginalName();
                $extension = $request->file('profileImage')->getClientOriginalExtension();
                $fileNameToStore = 'profil_' . $user->id . '.' . $extension;
                $path = $request->file('profileImage')->storeAs('public/profile_images', $fileNameToStore);
                $user->urlPictureProfil = $fileNameToStore;
            } else {
                return response()->json(['message' => 'Invalid file upload'], 422);
            }
        } else {
            $user->urlPictureProfil = 'defaut.jpg';
        }

        $user->save();

        // Envoyer un email de bienvenue
        $this->sendClientWelcomeEmail($user->email, $user->identifiant, $request->firstName, $request->lastName);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
        ]);
    }
}
