<?php

use App\Http\Controllers\CivilityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FormulaController;
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
