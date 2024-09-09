<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\MailService;
use App\Helpers\EmailHelper;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProposalController;
use App\Models\Formula;
use App\Models\FormulaCustomOption;
use App\Models\ProposalAttachment;
use App\Models\ProposalCustomOption;
use App\Models\ProposalDefaultElement;

class ProposalRequestController extends Controller
{
    protected $mailService;
    protected $userController;
    protected $customerController;
    protected $proposalController;

    public function __construct(
        MailService $mailService, 
        UserController $userController, 
        CustomerController $customerController, 
        ProposalController $proposalController
    ) {
        $this->mailService = $mailService;
        $this->userController = $userController;
        $this->customerController = $customerController;
        $this->proposalController = $proposalController;
    }

    /**
     * @OA\Post(
     *     path="/api/proposal-request",
     *     summary="Soumettre une demande de devis",
     *     operationId="storeProposalRequest",
     *     tags={"Proposals-Request"},
     *     @OA\RequestBody(
     *         description="Données nécessaires pour soumettre une demande de devis",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"formule"},
     *             @OA\Property(property="formule", type="string", example="Formule A"),
     *             @OA\Property(property="options", type="array", @OA\Items(type="boolean")),
     *             @OA\Property(property="pageCount", type="integer", example=2),
     *             @OA\Property(property="supplementalInfo", type="string", example="Informations supplémentaires..."),
     *             @OA\Property(property="fileInput0", type="string", example="file0.jpg"),
     *             @OA\Property(property="fileComment0", type="string", example="Commentaire fichier 0"),
     *             @OA\Property(property="civility", type="string", example="Monsieur"),
     *             @OA\Property(property="firstName", type="string", example="John"),
     *             @OA\Property(property="lastName", type="string", example="Doe"),
     *             @OA\Property(property="address", type="string", example="123 rue de la Paix"),
     *             @OA\Property(property="postalCode", type="string", example="75000"),
     *             @OA\Property(property="city", type="string", example="Paris"),
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="customerType", type="string", example="particulier")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Demande de devis soumise avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Votre demande de devis a été soumise avec succès !"),
     *             @OA\Property(property="proposal", type="object", ref="#/components/schemas/Proposal")
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
    public function store(Request $request)
    {
        // Démarrer une transaction pour garantir que toutes les opérations sont atomiques
        DB::beginTransaction();

        try {
            // Valider les données de la requête
            $validatedData = $this->validateData($request);

            // Créer l'utilisateur
            $user = $this->userController->createUser($validatedData);

            // Créer ou mettre à jour le client
            $customer = $this->customerController->createOrUpdateCustomer($validatedData, $user);

            // Créer la proposition
            $proposal = $this->proposalController->createProposal($validatedData, $customer, $user);

            // Gérer les uploads de fichiers
            $filePaths = $this->handleFileUploads($validatedData, $customer, $proposal);

            // Associer les fichiers à la proposition
            $this->attachFilesToProposal($proposal, $filePaths);

            // Associer les éléments par défaut à la proposition
            $this->associateDefaultElements($proposal, $validatedData['formule']);

            // Associer les options personnalisées à la proposition
            $selectedOptions = $this->associateCustomOptions($proposal, $validatedData);

            // Envoyer les emails de confirmation et de notification
            $this->sendEmails($validatedData, $selectedOptions);

            // Si tout est réussi, valider la transaction
            DB::commit();

            return response()->json(['message' => 'Votre demande de devis a été soumise avec succès !', 'proposal' => $proposal], 201);

        } catch (\Exception $e) {
            // Si une erreur se produit, annuler toutes les opérations
            DB::rollBack();

            return response()->json(['message' => 'Une erreur est survenue lors de la soumission de votre demande de devis.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Valider les données de la requête
     */
    protected function validateData(Request $request)
    {
        return $request->validate([
            'formule' => 'required|string|max:255',
            'options' => 'nullable|array',
            'options.*' => ['nullable', 'in:true,false,1,0'],
            'pageCount' => 'nullable|integer|min:1|max:5',
            'supplementalInfo' => 'nullable|string',
            'fileInput0' => 'nullable|string',
            'fileInput1' => 'nullable|string',
            'fileInput2' => 'nullable|string',
            'fileComment0' => 'nullable|string',
            'fileComment1' => 'nullable|string',
            'fileComment2' => 'nullable|string',
            'civility' => 'nullable|string',
            'firstName' => 'nullable|string',
            'lastName' => 'nullable|string',
            'address' => 'nullable|string',
            'postalCode' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'customerType' => 'nullable|string',
        ]);
    }

    /**
     * Gérer les uploads de fichiers et retourner leurs chemins
     */
    protected function handleFileUploads(array $validatedData, $customer, $proposal)
    {
        $directory = 'public/proposal_request/' . $customer->customer_number . '/' . $proposal->proposal_number;
        Storage::makeDirectory($directory);

        $filePaths = [];
        foreach ([0, 1, 2] as $i) {
            $fileInputKey = "fileInput$i";
            $fileCommentKey = "fileComment$i";

            if (!empty($validatedData[$fileInputKey])) {
                $filename = $validatedData[$fileCommentKey] . '.' . pathinfo($validatedData[$fileInputKey], PATHINFO_EXTENSION);
                $filePath = "$directory/$filename";
                Storage::move("public/proposal_request/temporary/" . basename($validatedData[$fileInputKey]), $filePath);
                $storedPath = str_replace('public/', '', $filePath);
                $filePaths[$fileInputKey] = $storedPath;
            }
        }

        return $filePaths;
    }

    /**
     * Associer les fichiers téléchargés à la proposition
     */
    protected function attachFilesToProposal($proposal, array $filePaths)
    {
        foreach ($filePaths as $filePath) {
            ProposalAttachment::create([
                'proposal_id' => $proposal->id,
                'filename' => basename($filePath),
                'path' => $filePath,
            ]);
        }
    }

    /**
     * Associer les éléments par défaut à la proposition
     */
    protected function associateDefaultElements($proposal, string $formula)
    {
        $defaultElements = Formula::where('name', $formula)->first()->defaultElements;

        foreach ($defaultElements as $element) {
            ProposalDefaultElement::create([
                'proposal_id' => $proposal->id,
                'name' => $element->name,
                'value' => $element->value,
            ]);
        }
    }

    /**
     * Associer les options personnalisées à la proposition
     */
    protected function associateCustomOptions($proposal, array $validatedData)
    {
        $selectedOptions = [];

        if (!empty($validatedData['options'])) {
            foreach ($validatedData['options'] as $optionName => $enabled) {
                if ($enabled) {
                    $option = FormulaCustomOption::where('name', $optionName)->first();
                    if ($option) {
                        // Utiliser 'value' au lieu de 'description'
                        $value = $option->value;

                        if ($optionName === "Ajout de pages supplémentaires" && !empty($validatedData['pageCount'])) {
                            $value = $validatedData['pageCount'];
                            $selectedOptions[] = $option->name . ' (+' . $validatedData['pageCount'] . ' pages)';
                        } else {
                            $selectedOptions[] = $option->name;
                        }

                        ProposalCustomOption::create([
                            'proposal_id' => $proposal->id,
                            'name' => $option->name,
                            'value' => $value, // Remplacer 'description' par 'value'
                            'price' => $option->price,
                        ]);
                    }
                }
            }
        }

        return $selectedOptions;
    }

    /**
     * Envoyer les emails de confirmation et de notification
     */
    protected function sendEmails(array $validatedData, array $selectedOptions)
    {
        EmailHelper::sendEmail($this->mailService, 'proposal_confirmation', $validatedData);
        $notificationData = array_merge($validatedData, ['options' => $selectedOptions]);
        EmailHelper::sendEmail($this->mailService, 'proposal_notification', $notificationData);
    }
}
