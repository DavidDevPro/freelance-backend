<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FormulaCustomOption",
 *     type="object",
 *     title="FormulaCustomOption",
 *     description="Option personnalisée associée à une formule",
 *     required={"name", "price"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique de l'option personnalisée"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nom de l'option personnalisée"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         description="Description de l'option personnalisée"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="float",
 *         description="Prix de l'option personnalisée"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         description="Indique si l'option personnalisée est active"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création de l'option personnalisée"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour de l'option personnalisée"
 *     )
 * )
 */
class FormulaCustomOptionSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
