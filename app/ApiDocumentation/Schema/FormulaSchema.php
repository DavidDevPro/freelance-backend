<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Formula",
 *     type="object",
 *     title="Formula",
 *     description="Modèle représentant une formule",
 *     required={"name", "base_price"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique de la formule"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nom de la formule"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         nullable=true,
 *         description="Description de la formule"
 *     ),
 *     @OA\Property(
 *         property="base_price",
 *         type="number",
 *         format="float",
 *         description="Prix de base de la formule"
 *     ),
 *     @OA\Property(
 *         property="popular",
 *         type="boolean",
 *         description="Indique si la formule est populaire"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         description="Indique si la formule est active"
 *     ),
 *     @OA\Property(
 *         property="defaultElements",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/FormulaDefaultElement"),
 *         description="Liste des éléments par défaut associés à la formule"
 *     ),
 *     @OA\Property(
 *         property="customOptions",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/FormulaCustomOption"),
 *         description="Liste des options personnalisées associées à la formule"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création de la formule"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour de la formule"
 *     )
 * )
 */
class FormulaSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
