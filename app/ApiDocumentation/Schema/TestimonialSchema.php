<?php

namespace App\ApiDocumentation\Schema;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Testimonial",
 *     type="object",
 *     title="Testimonial",
 *     description="Modèle représentant un témoignage dans le système",
 *     required={"name", "role", "comment", "rating"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID unique du témoignage"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nom complet de l'auteur du témoignage"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="string",
 *         description="Rôle ou poste de l'auteur du témoignage"
 *     ),
 *     @OA\Property(
 *         property="comment",
 *         type="string",
 *         description="Commentaire ou avis laissé par l'auteur du témoignage"
 *     ),
 *     @OA\Property(
 *         property="image_url",
 *         type="string",
 *         description="URL de l'image ou de l'avatar associé au témoignage",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="float",
 *         description="Note ou évaluation donnée par l'auteur du témoignage"
 *     ),
 *     @OA\Property(
 *         property="source",
 *         type="string",
 *         description="Source d'où provient le témoignage (par exemple, 'site web', 'réseaux sociaux')",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de création du témoignage"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date et heure de la dernière mise à jour du témoignage"
 *     )
 * )
 */

class TestimonialSchema
{
    // Ce fichier est utilisé uniquement pour les annotations OpenAPI.
}
