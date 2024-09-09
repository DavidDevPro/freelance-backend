<?php

namespace App\Http\Controllers;

use App\Models\Civility;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\UniqueIdentifierService;

class CustomerController extends Controller
{
    protected $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="Lister tous les clients",
     *     operationId="getCustomers",
     *     tags={"Customers"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des clients",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Customer")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $customers = Customer::with('user', 'status', 'createdBy', 'updatedBy', 'civility')->get();
        return response()->json($customers);
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Afficher les détails d'un client",
     *     operationId="getCustomerById",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du client",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        $customer = Customer::with('user', 'status', 'createdBy', 'updatedBy', 'civility')->findOrFail($id);
        return response()->json($customer);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Créer un nouveau client",
     *     operationId="createCustomer",
     *     tags={"Customers"},
     *     @OA\RequestBody(
     *         description="Données du client à créer",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
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
        $validatedData = $this->validateCustomerData($request);

        DB::beginTransaction();

        try {
            $customer = $this->findOrCreateCustomer($validatedData, $request);
            DB::commit();

            return response()->json($customer, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de la création du client : ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Mettre à jour un client existant",
     *     operationId="updateCustomer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données du client à mettre à jour",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $previousStatus = $customer->status_id;

        $validatedData = $this->validateCustomerData($request, $customer->id);

        DB::beginTransaction();

        try {
            $customer->update($validatedData);
            $this->checkAndSendWelcomeEmail($customer, $previousStatus, $validatedData['status_id']);
            DB::commit();

            return response()->json($customer);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de la mise à jour du client : ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Supprimer un client",
     *     operationId="deleteCustomer",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Client supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            DB::commit();

            return response(null, 204);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erreur lors de la suppression du client : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Valider les données de la requête pour la création ou la mise à jour d'un client
     */
    protected function validateCustomerData(Request $request, $customerId = null)
    {
        $uniqueEmailRule = 'unique:customers,email' . ($customerId ? ',' . $customerId : '');

        return $request->validate([
            'civility_id' => 'nullable|integer|exists:civilities,id',
            'company_name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|' . $uniqueEmailRule,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'status_id' => 'required|integer|exists:statuses,id',
            'created_by' => 'required|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
    }

    /**
     * Trouver ou créer un client et son utilisateur associé
     */
    protected function findOrCreateCustomer(array $validatedData, Request $request)
    {
        // Vérifier si le client existe déjà
        $customer = Customer::where('email', $validatedData['email'])->first();

        if (!$customer) {
            // Générer la référence client unique
            $validatedData['customer_number'] = UniqueIdentifierService::generateCustomerNumber();

            // Générer l'identifiant utilisateur unique
            $firstName = strtolower($validatedData['first_name']);
            $lastName = strtolower($validatedData['last_name']);
            $identifier = UniqueIdentifierService::generateIdentifier($firstName, $lastName);

            // Créer l'utilisateur
            $user = User::create([
                'identifiant' => $identifier,
                'password' => Hash::make($firstName), // Utiliser le prénom comme mot de passe par défaut
                'email' => $validatedData['email'],
                'user_permission_id' => 2, // Rôle utilisateur standard
            ]);

            // Ajouter l'ID de l'utilisateur à la fiche client
            $validatedData['user_id'] = $user->id;

            // Créer le client
            $customer = Customer::create($validatedData);
        }

        return $customer;
    }

    /**
     * Vérifier si le statut du client est passé de prospect à client et envoyer un email de bienvenue
     */
    protected function checkAndSendWelcomeEmail(Customer $customer, $previousStatus, $newStatusId)
    {
        // Récupérez dynamiquement l'ID du statut "Client"
        $clientStatusId = Status::where('label_status', 'Client')
            ->where('entity_type', 'customer')
            ->value('id');

        if (!$clientStatusId) {
            throw new \Exception('Client status not found');
        }

        // Vérifiez si le statut est passé de prospect à client
        if ($previousStatus !== $newStatusId && $newStatusId == $clientStatusId) {
            $user = User::find($customer->user_id);
            if ($user) {
                $this->userController->sendClientWelcomeEmail($user->email, $user->identifiant, $customer->first_name, $customer->last_name);
            }
        }
    }

/**
     * Créer ou mettre à jour un client
     *
     * @param array $validatedData
     * @param \App\Models\User $user
     * @return \App\Models\Customer
     */
    public function createOrUpdateCustomer(array $validatedData, $user)
    {
        DB::beginTransaction();

        try {
            // Récupérer ou créer la civilité
            $civility = $this->getOrCreateCivility($validatedData['civility']);

            // Récupérer le statut "Prospect"
            $status = $this->getProspectStatus();

            // Mettre la ville et le pays en majuscule
            if (isset($validatedData['city'])) {
                $validatedData['city'] = strtoupper($validatedData['city']);
            }
            if (isset($validatedData['country'])) {
                $validatedData['country'] = strtoupper($validatedData['country']);
            }

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
                    'last_name' => strtoupper($validatedData['lastName']),
                    'first_name' => ucfirst(strtolower($validatedData['firstName'])),
                    'phone' => $validatedData['phone'],
                    'email' => $validatedData['email'],
                    'address' => $validatedData['address'],
                    'postal_code' => $validatedData['postalCode'],
                    'city' => $validatedData['city'],
                    'country' => $validatedData['country'] ?? null,
                    'status_id' => $status->id,
                    'user_id' => $user->id,
                    'created_by' => $user->id,
                ]
            );

            DB::commit();

            return $customer;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Erreur lors de la création ou mise à jour du client : ' . $e->getMessage());
        }
    }

    /**
     * Récupérer ou créer une civilité
     *
     * @param string|null $civilityLabel
     * @return \App\Models\Civility|null
     */
    protected function getOrCreateCivility($civilityLabel)
    {
        // Vérifier si le label est fourni
        if (!$civilityLabel) {
            return null; // Aucun label fourni, donc aucune civilité à récupérer
        }
    
        // Chercher une civilité existante basée sur le longLabel fourni par le formulaire
        $civility = Civility::where('longLabel', $civilityLabel)->first();
    
        // Retourner la civilité trouvée ou null si aucune n'existe
        return $civility;
    }

    /**
     * Récupérer le statut "Prospect" pour un client
     *
     * @return \App\Models\Status
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    protected function getProspectStatus()
    {
        return Status::where('entity_type', 'customer')
                     ->where('label_status', 'Prospect')
                     ->firstOrFail();
    }
}
