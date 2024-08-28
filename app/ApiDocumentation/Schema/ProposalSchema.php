<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Proposal",
 *     type="object",
 *     title="Proposal",
 *     description="Modèle représentant un devis",
 *     required={"proposal_number", "formula", "amount", "issue_date", "expiry_date", "customer_id", "status_id", "created_by"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique du devis"
 *     ),
 *     @OA\Property(
 *         property="proposal_number",
 *         type="string",
 *         description="Numéro unique du devis"
 *     ),
 *     @OA\Property(
 *         property="formula",
 *         type="string",
 *         description="Formule associée au devis"
 *     ),
 *     @OA\Property(
 *         property="supplementalInfo",
 *         type="string",
 *         nullable=true,
 *         description="Informations supplémentaires sur le devis"
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         format="float",
 *         description="Montant du devis"
 *     ),
 *     @OA\Property(
 *         property="issue_date",
 *         type="string",
 *         format="date-time",
 *         description="Date d'émission du devis"
 *     ),
 *     @OA\Property(
 *         property="expiry_date",
 *         type="string",
 *         format="date-time",
 *         description="Date d'expiration du devis"
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="integer",
 *         description="ID du client associé au devis"
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         description="ID du statut du devis"
 *     ),
 *     @OA\Property(
 *         property="created_by",
 *         type="integer",
 *         description="ID de l'utilisateur qui a créé le devis"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création du devis"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour du devis"
 *     )
 * )
 */
class ProposalSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
