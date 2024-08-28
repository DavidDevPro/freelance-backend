<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Civility",
 *     type="object",
 *     title="Civilité",
 *     description="Modèle de civilité",
 *     required={"shortLabel", "longLabel"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique de la civilité"
 *     ),
 *     @OA\Property(
 *         property="shortLabel",
 *         type="string",
 *         description="Abréviation de la civilité"
 *     ),
 *     @OA\Property(
 *         property="longLabel",
 *         type="string",
 *         description="Nom complet de la civilité"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de création"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date de dernière mise à jour"
 *     )
 * )
 */
class CivilitySchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
