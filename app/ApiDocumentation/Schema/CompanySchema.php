<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Company",
 *     type="object",
 *     title="Company",
 *     description="Modèle représentant une entreprise",
 *     required={"company_name"},
 *     @OA\Property(property="id", type="integer", description="ID unique de l'entreprise"),
 *     @OA\Property(property="company_name", type="string", description="Nom de l'entreprise"),
 *     @OA\Property(property="phone", type="string", description="Numéro de téléphone de l'entreprise"),
 *     @OA\Property(property="email", type="string", format="email", description="Adresse email de l'entreprise"),
 *     @OA\Property(property="address", type="string", description="Adresse de l'entreprise"),
 *     @OA\Property(property="postal_code", type="string", description="Code postal de l'entreprise"),
 *     @OA\Property(property="city", type="string", description="Ville de l'entreprise"),
 *     @OA\Property(property="siret", type="string", description="Numéro SIRET de l'entreprise"),
 *     @OA\Property(property="ape_code", type="string", description="Code APE de l'entreprise"),
 *     @OA\Property(property="iban", type="string", description="IBAN de l'entreprise"),
 *     @OA\Property(property="header_text", type="string", description="Texte d'en-tête personnalisé"),
 *     @OA\Property(property="footer_text", type="string", description="Texte de pied de page personnalisé"),
 *     @OA\Property(property="created_by", type="integer", description="ID de l'utilisateur ayant créé l'entreprise"),
 *     @OA\Property(property="updated_by", type="integer", description="ID de l'utilisateur ayant mis à jour l'entreprise"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Date de création de l'entreprise"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Date de dernière mise à jour de l'entreprise")
 * )
 */

class CompanySchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
