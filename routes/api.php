<?php

use App\Http\Controllers\CivilityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProposalRequestController;
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

// Routes pour le formulaire de contact
Route::post('/contact', [ContactController::class, 'sendEmail']);

// Routes pour les testimonials
Route::apiResource('testimonials', TestimonialController::class);
// Routes pour les formules
Route::apiResource('formulas', FormulaController::class);
// Routes pour les civilités
Route::apiResource('civilities', CivilityController::class);
// Routes pour gerer les documents de devis personnalisés (temporaire)
Route::post('/proposal-request/temporary-upload', [TemporaryFileController::class, 'store']);
// Routes pour les clients qui font une demande de devis
Route::post('/proposal-request', [ProposalRequestController::class, 'store']);

// Routes pour la gestion des devis par les administrateurs
Route::apiResource('proposals', ProposalController::class);
