<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Status;
use Illuminate\Support\Facades\Hash;
use App\Services\UniqueIdentifierService;

class CustomerController extends Controller
{
    protected $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function index()
    {
        $customers = Customer::with('user', 'status', 'createdBy', 'updatedBy', 'civility')->get();

        return response()->json($customers);
    }

    public function show($id)
    {
        $customer = Customer::with('user', 'status', 'createdBy', 'updatedBy', 'civility')->findOrFail($id);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'civility_id' => 'nullable|integer|exists:civilities,id',
            'company_name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'status_id' => 'required|integer|exists:statuses,id',
            'created_by' => 'required|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ]);

        // Vérifier si le client existe déjà
        $customer = Customer::where('email', $validatedData['email'])->first();

        if (!$customer) {
            // Générer la référence client unique
            $validatedData['customer_number'] = UniqueIdentifierService::generateCustomerNumber();

            // Générer l'identifiant utilisateur unique
            $firstName = strtolower($request->first_name);
            $lastName = strtolower($request->last_name);
            $identifier = UniqueIdentifierService::generateIdentifier($firstName, $lastName);

            // Créer l'utilisateur
            $user = User::create([
                'identifiant' => $identifier,
                'password' => Hash::make($firstName), // Utiliser le prénom comme mot de passe par défaut
                'email' => $request->email,
                'user_permission_id' => 2, // Rôle utilisateur standard
            ]);

            // Ajouter l'ID de l'utilisateur à la fiche client
            $validatedData['user_id'] = $user->id;

            // Créer le client
            $customer = Customer::create($validatedData);
        }

        return response()->json($customer, 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $previousStatus = $customer->status_id;

        $validatedData = $request->validate([
            'civility_id' => 'nullable|integer|exists:civilities,id',
            'company_name' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'status_id' => 'required|integer|exists:statuses,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'updated_by' => 'nullable|integer|exists:users,id',
        ]);

        // Ajouter le champ updated_by avec l'ID de l'utilisateur connecté
        $validatedData['updated_by'] = $request->user()->id;

        $customer->update($validatedData);

        // Récupérez dynamiquement l'ID du statut "Client"
        $clientStatusId = Status::where('label_status', 'Client')
            ->where('entity_type', 'customer')
            ->value('id');

        if (!$clientStatusId) {
            return response()->json(['error' => 'Client status not found'], 404);
        }

        // Vérifiez si le statut est passé de prospect à client
        if ($previousStatus !== $validatedData['status_id'] && $validatedData['status_id'] == $clientStatusId) {
            $user = User::find($customer->user_id);
            if ($user) {
                $this->userController->sendClientWelcomeEmail($user->email, $user->identifiant, $customer->first_name, $customer->last_name);
            }
        }

        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response(null, 204);
    }
}
