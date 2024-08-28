<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     title="Customer",
 *     description="Modèle représentant un client",
 *     required={"customer_number", "status_id", "created_by"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique du client"
 *     ),
 *     @OA\Property(
 *         property="customer_number",
 *         type="string",
 *         description="Numéro de référence unique du client"
 *     ),
 *     @OA\Property(
 *         property="civility_id",
 *         type="integer",
 *         nullable=true,
 *         description="ID de la civilité associée au client"
 *     ),
 *     @OA\Property(
 *         property="company_name",
 *         type="string",
 *         nullable=true,
 *         description="Nom de la société du client"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="Nom de famille du client"
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="Prénom du client"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Numéro de téléphone du client"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Adresse email du client"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Adresse du client"
 *     ),
 *     @OA\Property(
 *         property="postal_code",
 *         type="string",
 *         description="Code postal du client"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="Ville du client"
 *     ),
 *     @OA\Property(
 *         property="country",
 *         type="string",
 *         nullable=true,
 *         description="Pays du client"
 *     ),
 *     @OA\Property(
 *         property="additional_info",
 *         type="string",
 *         nullable=true,
 *         description="Informations supplémentaires concernant le client"
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         description="ID du statut associé au client"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         nullable=true,
 *         description="ID de l'utilisateur associé au client"
 *     ),
 *     @OA\Property(
 *         property="created_by",
 *         type="integer",
 *         description="ID de l'utilisateur qui a créé le client"
 *     ),
 *     @OA\Property(
 *         property="updated_by",
 *         type="integer",
 *         nullable=true,
 *         description="ID de l'utilisateur qui a mis à jour le client"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création du client"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour du client"
 *     )
 * )
 */
class CustomerSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
