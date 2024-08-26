<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CivilityController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProposalRequestController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TemporaryFileController;
use App\Http\Controllers\TestimonialController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::post('/login', [AuthController::class, 'login']);
    // Routes pour le formulaire de contact
    Route::post('/contact', [ContactController::class, 'sendEmail']);

    // Route GET pour obtenir les statuts par type d'entité, accessible sans authentification
    Route::get('status/entity/{entityType}', [StatusController::class, 'getStatussByEntityType']);

    // Ajoutez cette ligne pour permettre l'accès à tous les statuts sans authentification
    Route::get('status', [StatusController::class, 'index']);

    // Routes pour les testimonials
    Route::apiResource('testimonials', TestimonialController::class);
    // Routes pour les formules
    Route::apiResource('formulas', FormulaController::class);
    // Routes pour les civilités
    Route::apiResource('civilities', CivilityController::class);
    // Routes pour les gérer les documents de devis personnalisés (temporaire)
    Route::post('/proposal-request/temporary-upload', [TemporaryFileController::class, 'store']);
    // Routes pour les clients qui font une demande de devis
    Route::post('/proposal-request', [ProposalRequestController::class, 'store']);

    // Routes pour la gestion des devis par les administrateurs
    Route::apiResource('proposals', ProposalController::class);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        // Routes pour l'entreprise
        Route::apiResource('company', CompanyController::class);
        
        // Routes pour les civilités
        Route::apiResource('civility', CivilityController::class);

        // Routes pour les clients
        Route::apiResource('customers', CustomerController::class);
    });        