<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

// Route pour la page d'accueil Laravel par défaut
Route::get('/', function () {
    return view('welcome');
});

// Route pour servir les images des témoignages
Route::get('storage/testimonial_images/{filename}', function ($filename) {
    $path = storage_path('app/public/testimonial_images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/profile_images/{filename}', function ($filename) {
    $path = storage_path('app/public/profile_images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});