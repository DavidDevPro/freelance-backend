<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\MailService;
use App\Services\UniqueIdentifierService;
use App\Helpers\EmailHelper;

class UserController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function createUser(array $validatedData)
    {
        $firstName = strtolower($validatedData['firstName']);
        $lastName = strtolower($validatedData['lastName']);
        $identifier = UniqueIdentifierService::generateIdentifier($firstName, $lastName);

        $user = User::create([
            'identifiant' => $identifier,
            'password' => Hash::make($firstName), // Assurez-vous de changer cela en un mot de passe sécurisé en production
            'email' => $validatedData['email'],
            'user_permission_id' => 2, // Idéalement, les ID de permissions devraient être des constantes ou configurables
            'urlPictureProfil' => 'defaut.jpg',
            'isActive' => false,
        ]);

        return $user;
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

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->isActive = true;
        $user->save();

        // Récupérer le client associé à cet utilisateur
        $customer = Customer::where('user_id', $user->id)->first();
        
        if (!$customer) {
            return response()->json(['message' => 'Customer not found for this user'], 404);
        }

        // Préparer les données pour les emails
        $emailData = [
            'email' => $user->email,
            'fullName' => trim(($customer->civility ?? '') . ' ' . $customer->first_name . ' ' . $customer->last_name),
            'username' => $user->identifiant,
            'namewebsite' => config('app.name'),
            'linkwebsite' => config('app.url'),
            'password' => $customer->first_name // Ceci est pour l'email de confirmation de mot de passe
        ];

        // Envoyer les emails de confirmation
        EmailHelper::sendEmail($this->mailService, 'account_confirmation', $emailData);
        EmailHelper::sendEmail($this->mailService, 'password_confirmation', $emailData);

        return response()->json(['message' => 'User activated successfully'], 200);
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

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->isActive = false;
        $user->save();

        return response()->json(['message' => 'User deactivated successfully'], 200);
    }

    /**
     * Envoyer un e-mail de bienvenue lorsque le statut du client passe de prospect à client.
     *
     * @param  string  $email
     * @param  string  $identifier
     * @param  string  $firstName
     * @param  string  $lastName
     * @return void
     */
    public function sendClientWelcomeEmail($email, $identifier, $firstName, $lastName)
    {
        $emailData = [
            'email' => $email,
            'fullName' => trim($firstName . ' ' . $lastName),
            'username' => $identifier,
            'namewebsite' => config('app.name'),
            'linkwebsite' => config('app.url'),
            'password' => $firstName // Ceci est pour l'email de confirmation de mot de passe
        ];

        // Envoyer les emails de confirmation
        EmailHelper::sendEmail($this->mailService, 'account_confirmation', $emailData);
        EmailHelper::sendEmail($this->mailService, 'password_confirmation', $emailData);
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

        $identifier = User::generateIdentifier($validated['firstName'], $validated['lastName']);

        $user = User::create([
            'identifiant' => $identifier,
            'password' => Hash::make($validated['password']),
            'email' => $validated['email'],
            'user_permission_id' => $validated['userRights'],
        ]);

        // Gestion de l'image de profil
        if ($request->hasFile('profileImage')) {
            if ($request->file('profileImage')->isValid()) {
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
        $this->sendClientWelcomeEmail($user->email, $user->identifiant, $validated['firstName'], $validated['lastName']);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
        ]);
    }
}
