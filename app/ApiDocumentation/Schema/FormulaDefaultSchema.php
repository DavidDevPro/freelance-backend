<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FormulaDefault",
 *     type="object",
 *     title="FormulaDefault",
 *     description="Association entre une formule et un élément par défaut",
 *     required={"formula_id", "default_element_id"},
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
 *         property="default_element_id",
 *         type="integer",
 *         description="ID de l'élément par défaut"
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
class FormulaDefaultSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
