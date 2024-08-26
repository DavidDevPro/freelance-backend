<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\Proposal;
use App\Models\Status;
use App\Models\Civility;
use App\Models\Formula;
use App\Models\FormulaCustomOption;
use App\Models\User;
use App\Services\UniqueIdentifierService;
use App\Services\MailService;
use Illuminate\Support\Facades\Hash;
use App\Models\ProposalDefaultElement;
use App\Models\ProposalCustomOption;
use App\Models\ProposalAttachment;

class ProposalRequestController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
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
            'fileName0' => 'nullable|string',
            'fileName1' => 'nullable|string',
            'fileName2' => 'nullable|string',
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

        // Trouver ou créer la civilité
        $civility = $validatedData['civility'] ? Civility::firstOrCreate(['longLabel' => $validatedData['civility']]) : null;

        // Trouver ou créer le statut
        $status = Status::where('entity_type', 'customer')
            ->where('label_status', 'Prospect')
            ->first();

        if (!$status) {
            return response()->json(['message' => 'Le statut par défaut "Prospect" est introuvable.'], 500);
        }

        // Générer l'identifiant utilisateur unique
        $firstName = strtolower($validatedData['firstName']);
        $lastName = strtolower($validatedData['lastName']);
        $identifier = UniqueIdentifierService::generateIdentifier($firstName, $lastName);

        // Créer l'utilisateur
        $user = User::create([
            'identifiant' => $identifier,
            'password' => Hash::make($firstName), // Utiliser le prénom comme mot de passe par défaut
            'email' => $validatedData['email'],
            'user_permission_id' => 2, // Rôle utilisateur standard
            'urlPictureProfil' => 'defaut.jpg', // Image de profil par défaut
            'isActive' => false, // Le compte n'est pas activé par défaut
        ]);

        // Créer ou mettre à jour le client
        $customer = Customer::updateOrCreate(
            [
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'postal_code' => $validatedData['postalCode'],
                'city' => $validatedData['city']
            ],
            [
                'civility_id' => $civility ? $civility->id : null,
                'company_name' => $validatedData['customerType'] === 'particulier' ?
                    $validatedData['firstName'] . ' ' . $validatedData['lastName'] :
                    null,
                'last_name' => $validatedData['lastName'],
                'first_name' => $validatedData['firstName'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'address' => $validatedData['address'],
                'postal_code' => $validatedData['postalCode'],
                'city' => $validatedData['city'],
                'country' => $validatedData['country'] ?? null,
                'status_id' => $status->id,
                'user_id' => $user->id, // Associer l'utilisateur au client
            ]
        );

        // Obtenir la référence client générée après la création ou la mise à jour
        $customerNumber = $customer->customer_number;

        // Créer la proposition
        $proposal = Proposal::create([
            'proposal_number' => UniqueIdentifierService::generateProposalNumber($customer->customer_number), // Générer un numéro de proposition unique
            'formula' => $validatedData['formule'],
            'supplementalInfo' => $validatedData['supplementalInfo'],
            'amount' => 0, // Mettre à jour avec le montant calculé
            'issue_date' => now(),
            'expiry_date' => now()->addDays(30), // Exemple : 30 jours après l'émission
            'customer_id' => $customer->id,
            'status_id' => Status::where('label_status', 'En Attente')->first()->id,
            'created_by' => $user->id,
        ]);

        // Créer un sous-dossier basé sur le customer_number et le proposal_number
        $directory = 'public/proposal_request/' . $customerNumber . '/' . $proposal->proposal_number;
        Storage::makeDirectory($directory);

        // Déplacer les fichiers dans le sous-dossier de la proposition avec les noms spécifiés
        $filePaths = [];
        foreach ([0, 1, 2] as $i) {
            $fileInputKey = "fileInput$i";
            $fileCommentKey = "fileComment$i";

            if (!empty($validatedData[$fileInputKey])) {
                // Utilise le nom du fichier comment fourni ou le nom de fichier par défaut
                $filename = $validatedData[$fileCommentKey] . '.' . pathinfo($validatedData[$fileInputKey], PATHINFO_EXTENSION);
                $filePath = "$directory/$filename";

                // Déplace le fichier temporaire vers le sous-dossier de la proposition avec le nom spécifié
                Storage::move("public/proposal_request/temporary/" . basename($validatedData[$fileInputKey]), $filePath);

                // Retirer 'public/' du chemin pour le stocker dans la base de données
                $storedPath = str_replace('public/', '', $filePath);

                $filePaths[$fileInputKey] = $storedPath;
            }
        }

        // Associer les éléments par défaut à la proposition
        if (!empty($validatedData['formule'])) {
            // Vous devez récupérer les éléments par défaut liés à la formule et les associer au devis ici
            $defaultElements = Formula::where('name', $validatedData['formule'])->first()->defaultElements;

            foreach ($defaultElements as $element) {
                ProposalDefaultElement::create([
                    'proposal_id' => $proposal->id,
                    'name' => $element->name,
                    'description' => $element->description,
                ]);
            }
        }

        // Associer les options sélectionnées au devis
        if (!empty($validatedData['options'])) {
            foreach ($validatedData['options'] as $optionName => $enabled) {
                if ($enabled) {
                    $option = FormulaCustomOption::where('name', $optionName)->first();
                    if ($option) {
                        $description = $option->description;

                        // Si l'option est "Ajout de pages supplémentaires", mettre à jour la description avec pageCount
                        if ($optionName === "Ajout de pages supplémentaires" && !empty($validatedData['pageCount'])) {
                            $description = $validatedData['pageCount'];
                        }

                        ProposalCustomOption::create([
                            'proposal_id' => $proposal->id,
                            'name' => $option->name,
                            'description' => $description,
                            'price' => $option->price,
                        ]);
                    }
                }
            }
        }

        // Enregistrer les pièces jointes dans la table proposal_attachments
        foreach ($filePaths as $fileKey => $filePath) {
            ProposalAttachment::create([
                'proposal_id' => $proposal->id,
                'filename' => basename($filePath),
                'path' => $filePath,
            ]);
        }

        // Envoyer l'email de confirmation au client
        $this->mailService->sendProposalConfirmationEmail(
            $validatedData['email'],
            $validatedData['civility'] . ' ' . $validatedData['firstName'] . ' ' . $validatedData['lastName'],
            $validatedData['formule']
        );

        // Envoyer l'email de notification à l'administrateur
        $this->mailService->sendProposalNotificationEmail($validatedData);

        return response()->json(['message' => 'Votre demande de devis a été soumise avec succès !', 'proposal' => $proposal], 201);
    }
}
