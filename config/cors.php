<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Définir les chemins pour lesquels CORS s'applique

    'allowed_methods' => ['*'], // Autoriser toutes les méthodes HTTP

    'allowed_origins' => [
        'https://portfolio.davidwebprojects.fr',
        'https://davidwebprojects.fr',
        'https://www.davidwebprojects.fr',
        'https://test.davidwebprojects.fr',
        'http://localhost:3000',



    ], // Ajouter les domaines autorisés, y compris les adresses locales

    'allowed_origins_patterns' => [], // Laisser vide si tu n'utilises pas de pattern spécifique

    'allowed_headers' => ['*'], // Autoriser tous les headers

    'exposed_headers' => [], // Définir les headers qui peuvent être exposés au client

    'max_age' => 0, // Temps en secondes que les résultats d'une requête pré-validée peuvent être mis en cache

    'supports_credentials' => true, // Si tu utilises des cookies ou des sessions, active cette option
];
