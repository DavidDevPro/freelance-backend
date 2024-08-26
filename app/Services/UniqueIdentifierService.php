<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Customer;
use App\Models\User;

class UniqueIdentifierService
{
    /**
     * Générer un numéro de devis unique en utilisant le numéro de client.
     *
     * @param string $customerNumber
     * @return string
     */
    public static function generateProposalNumber($customerNumber)
    {
        $lastProposal = Proposal::orderBy('id', 'desc')->first();

        if (!$lastProposal) {
            $number = 0;
        } else {
            $number = intval(substr($lastProposal->proposal_number, 4));
        }

        return 'PROP' . str_pad($number + 1, 3, '0', STR_PAD_LEFT) . '-' . $customerNumber;
    }

    /**
     * Générer un identifiant utilisateur unique basé sur le prénom et le nom.
     *
     * @param string $firstName
     * @param string $lastName
     * @return string
     */
    public static function generateIdentifier($firstName, $lastName)
    {
        $firstName = preg_replace('/[^a-zA-Z0-9]/', '', $firstName);
        $lastName = preg_replace('/[^a-zA-Z0-9]/', '', $lastName);

        $baseIdentifier = strtolower(substr($firstName, 0, 3) . substr($lastName, 0, 3));
        $identifier = $baseIdentifier . rand(100, 999);

        while (User::where('identifiant', $identifier)->exists()) {
            $identifier = $baseIdentifier . rand(100, 999);
        }

        return $identifier;
    }

    /**
     * Générer un numéro de client unique.
     *
     * @return string
     */
    public static function generateCustomerNumber()
    {
        $lastCustomer = Customer::orderBy('id', 'desc')->first();
        if (!$lastCustomer) {
            $number = 0;
        } else {
            $number = intval(substr($lastCustomer->customer_number, 3));
        }
        return 'CLT' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }
}
