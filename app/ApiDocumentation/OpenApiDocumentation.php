<?php

namespace App\ApiDocumentation;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API davidWebProject",
 *     version="1.0.0",
 *     description="Cette API est conçue pour gérer l'intégration de diverses fonctionnalités dans mon projet de freelance. Elle permet la gestion complète du backend, incluant la création, la mise à jour, la suppression et la récupération de données essentielles telles que les témoignages clients, les projets, les utilisateurs, et d'autres éléments de contenu. L'API alimente mon site web en fournissant les données nécessaires tout en facilitant la gestion administrative des opérations. Elle est sécurisée via l'authentification par jeton et est optimisée pour une utilisation par des applications web et mobiles. Idéale pour un usage interne, cette API centralise et simplifie la gestion de mon activité freelance.",
 *     @OA\Contact(
 *         email="contact@davidwebprojects.fr",
 *         name="Support",
 *         url="https://www.davidwebprojects.fr"
 *     )
 * ),
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * ),
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints for user authentication (part of Routes)"
 * ),
 * @OA\Tag(
 *     name="Users",
 *     description="Endpoints for managing users (part of Routes)"
 * )
 */
class OpenApiDocumentation
{
    // Ce fichier peut être laissé vide, il sert uniquement à inclure les annotations globales
}
