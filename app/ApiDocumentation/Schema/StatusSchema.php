<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Status",
 *     type="object",
 *     title="Status",
 *     description="Modèle représentant un statut dans le système",
 *     required={"label_status", "entity_type"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique du statut"
 *     ),
 *     @OA\Property(
 *         property="label_status",
 *         type="string",
 *         description="Libellé du statut"
 *     ),
 *     @OA\Property(
 *         property="entity_type",
 *         type="string",
 *         description="Type d'entité à laquelle le statut est associé (par exemple, 'customer', 'order', etc.)"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création du statut"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour du statut"
 *     )
 * )
 */

class StatusSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
