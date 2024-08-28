<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FormulaOption",
 *     type="object",
 *     title="FormulaOption",
 *     description="Association entre une formule et une option personnalisée",
 *     required={"formula_id", "option_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique de l'association"
 *     ),
 *     @OA\Property(
 *         property="formula_id",
 *         type="integer",
 *         description="ID de la formule"
 *     ),
 *     @OA\Property(
 *         property="option_id",
 *         type="integer",
 *         description="ID de l'option personnalisée"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création de l'association"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour de l'association"
 *     )
 * )
 */
class FormulaOptionSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
