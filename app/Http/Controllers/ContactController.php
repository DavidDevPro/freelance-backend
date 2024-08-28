<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailService;
use App\Helpers\EmailHelper;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @OA\Post(
     *     path="/api/contact",
     *     summary="Envoyer un message de contact",
     *     operationId="sendContactEmail",
     *     tags={"Contact"},
     *     @OA\RequestBody(
     *         description="Données nécessaires pour envoyer un message de contact",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"namewebsite", "firstName", "lastName", "email", "phone", "subject", "message", "consent"},
     *             @OA\Property(property="namewebsite", type="string", example="MonSite"),
     *             @OA\Property(property="firstName", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="DOE"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="subject", type="string", example="Demande d'information"),
     *             @OA\Property(property="message", type="string", example="Je souhaite avoir plus d'informations..."),
     *             @OA\Property(property="consent", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Email envoyé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email envoyé avec succès!")
     *         )
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
    public function sendEmail(Request $request)
    {
        // Valider les données reçues
        $validatedData = $this->validateContactData($request);

        DB::beginTransaction();

        try {
            // S'assurer que la première lettre de firstName est en majuscule
            $validatedData['firstName'] = ucfirst(strtolower($validatedData['firstName']));

            // Mettre tout le lastName en majuscule
            $validatedData['lastName'] = strtoupper($validatedData['lastName']);

            // Envoyer les emails de confirmation et de notification
            $this->sendEmails($validatedData);

            DB::commit();

            return response()->json(['message' => 'Email envoyé avec succès!'], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Annuler la transaction en cas d'erreur
            return response()->json(['error' => 'Erreur serveur', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Envoyer les emails de confirmation et de notification
     */
    protected function sendEmails(array $validatedData)
    {
        // Envoyer l'email de confirmation au client
        EmailHelper::sendEmail($this->mailService, 'contact_confirmation', $validatedData);

        // Envoyer l'email de notification à l'administrateur
        EmailHelper::sendEmail($this->mailService, 'contact_notification', $validatedData);
    }

    /**
     * Valider les données de la requête pour l'envoi d'un email de contact
     *
     * @param Request $request
     * @return array
     */
    protected function validateContactData(Request $request)
    {
        return $request->validate([
            'namewebsite' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'subject' => 'required|string|min:2',
            'message' => 'required|string|min:10',
            'consent' => 'required|boolean',
        ]);
    }
}
