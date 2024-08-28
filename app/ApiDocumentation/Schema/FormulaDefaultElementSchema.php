<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FormulaDefaultElement",
 *     type="object",
 *     title="FormulaDefaultElement",
 *     description="Élément par défaut associé à une formule",
 *     required={"name"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique de l'élément par défaut"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nom de l'élément par défaut"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         description="Description de l'élément par défaut"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création de l'élément par défaut"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour de l'élément par défaut"
 *     )
 * )
 */
class FormulaDefaultElementSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
