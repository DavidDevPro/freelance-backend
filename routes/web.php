<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

$emailTest = 'changea.david@neuf.fr';
$nameWebSiteTest = 'davidwebprojects.fr';
$linkWebTest = 'www.davidwebprojects.fr';


// Définition des routes pour les dossiers publics
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

Route::get('/signature_images/{filename}', function ($filename) {
    $path = storage_path('app/public/signature_images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

// Modèle signature
Route::get('/signature-preview', function () {
    return view('emails.confirmation_signature');
});


// Modèle de confirmation de contact
Route::get('/contact-confirmation-preview', function () {
    $testData = [
        'from_name' => 'John DOE',
    ];
    return view('emails.contact_confirmation', $testData);
});

// Modèle de notification de contact
Route::get('/contact-notification-preview', function () {
    $testData = [
        'from_name' => 'John DOE',
        'email' => '$emailTest',
        'phone' => '0123456789',
        'subject' => 'Demande de renseignements',
        'userMessage' => "Je souhaiterais avoir plus d 'informations sur vos services.",
        'namewebsite' => 'linkWebTest'
    ];
    return view('emails.contact_notification', $testData);
});

// Modèle de confirmation de devis
Route::get('/proposal-confirmation-preview', function () {
    $testData = [
        'fullName' => 'John DOE',
        'formule' => 'Formule Premium',
    ];
    return view('emails.proposal_confirmation', $testData);
});

// Modèle de notification de devis
Route::get('/proposal-notification-preview', function () {
    $testData = [
        'firstName' => 'John',
        'lastName' => 'DOE',
        'fullName' => 'John DOE',
        'formule' => 'Formule Premium',
        'email' => '$emailTest',
        'phone' => '0123456789',
        'address' => '123 Rue',
        'postalCode' => '75001',
        'city' => 'Paris',
        'options' => ['Option 1', 'Option 2', 'Option 3'], // Si les options sont utilisées dans l'email
        'supplementalInfo' => 'Voici quelques informations supplémentaires.',
    ];
    return view('emails.proposal_notification', $testData);
});


// Modèle de Confirmation de témoignage
Route::get('/testimonial-confirmation-preview', function () {
    $testData = [
        'email' => '$emailTest',
        'firstName' => 'John',
        'lastName' => 'DOE'
    ];

    return view('emails.testimonial_confirmation', $testData);
});

// Modèle de notification de témoignage
Route::get('/testimonial_notification-preview', function () {
    $testData = [
        'email' => '$emailTest',
        'firstName' => 'John',
        'lastName' => 'DOE',
        'role' => 'Developer',
        'comment' => 'This is a test testimonial.',
        'source' => 'LinkedIn'
    ];
    return view('emails.testimonial_notification', $testData);
});

// Modèle de confirmation de Création de compte
Route::get('/account_confirmation-preview', function () {
    $testData = [
        'email' => '$emailTest',
        'fullName' => 'Monsieur John DOE',
        'username' => 'JohnDOE',
        'namewebsite' => 'nameWebSiteTest',
        'linkwebsite' => 'linkWebTest'
    ];
    return view('emails.account_confirmation', $testData);
});

// Modèle de confirmation de Mot de passe ouverture de compte
Route::get('/password_confirmation-preview', function () {
    $testData = [
        'email' => '$emailTest',
        'fullName' => 'Monsieur John DOE',
        'username' => 'JohnDOE',
        'namewebsite' => 'nameWebSiteTest',
        'linkwebsite' => 'linkWebTest',
        'password' => 'john'
    ];
    return view('emails.password_confirmation', $testData);
});

// Modèle de confirmation de Mot de passe oublié
Route::get('/password_reset_confirmation-preview', function () {
    $testData = [
        'email' => '$emailTest',
        'fullName' => 'Monsieur John DOE',
        'username' => 'JohnDOE',
        'namewebsite' => 'nameWebSiteTest',
        'resetLink' => 'linkWebTest'
    ];
    return view('emails.password_reset_confirmation', $testData);
});

// Route pour tester l'envoi d'email de confirmation de contact
Route::get('/test-contact-confirmation-email', function () {
    $testData = [
        'from_name' => 'John DOE',
        'email' => '$emailTest',
        'fullName' => 'John DOE'
    ];

    $mailService = new \App\Services\MailService();
    $mailService->sendContactConfirmationEmail($testData);

    return 'Email de confirmation : réception confirmée au client';
});

// Route pour tester l'envoi d'email de notification de demande de contact
Route::get('/test-contact-notification-email', function () {
    $testData = [
        'from_name' => 'John DOE',
        'email' => '$emailTest',
        'subject' => 'Demande de renseignements',
        'phone' => '0123456789',
        'userMessage' => "Je souhaiterais avoir plus d'informations sur vos services.",
        'namewebsite' => 'nameWebSiteTest'
    ];

    $mailService = new \App\Services\MailService();
    $mailService->sendContactNotificationEmail($testData);

    return 'Email de notification : message de contact envoyé à l\'administrateur';
});


// Route pour tester l'envoi d'email de confirmation de devis
Route::get('/test-proposal-confirmation-email', function () {
    $testData = [
        'email' => '$emailTest',
        'fullName' => 'Monsieur John DOE',
        'formule' => 'Formule Premium'
    ];

    // Appel du service pour envoyer l'email de confirmation
    $mailService = new \App\Services\MailService();
    $mailService->sendProposalConfirmationEmail($testData);

    return 'Email de confirmation : demande de devis effectuée';
});

// Route pour tester l'envoi d'email de notification de devis
Route::get('/test-proposal-notification-email', function () {
    $testData = [
        'firstName' => 'John',
        'lastName' => 'DOE',
        'fullName' => 'Monsieur John DOE',
        'formule' => 'Formule Premium',
        'options' => ['Option 1', 'Option 2', 'Option 3'],
        'email' => 'johndoe@example.com',
        'phone' => '0123456789',
        'address' => '123 Rue de la Paix',
        'postalCode' => '75001',
        'city' => 'Paris',
        'supplementalInfo' => 'Voici quelques informations supplémentaires.',
    ];

    $mailService = new \App\Services\MailService();
    $mailService->sendProposalNotificationEmail($testData);

    return 'Email de notification : demande de devis envoyée';
});

// Route pour tester l'envoi d'email de notification de témoignage
Route::get('/test-testimonial-notification-email', function () {
    $testData = [
        'firstName' => 'John',
        'lastName' => 'DOE',
        'email' => '$emailTest',
        'role' => 'Developer',
        'comment' => 'This is a test testimonial.',
        'source' => ''
    ];

    $mailService = new \App\Services\MailService();
    $mailService->sendTestimonialNotificationEmail($testData);

    return 'Email de notification : Témoignage ajouté';
});

// Route pour tester l'envoi d'email de confirmation de témoignage
Route::get('/test-testimonial-confirmation-email', function () {
    $testData = [
        'email' => '$emailTest',
        'firstName' => 'John',
        'lastName' => 'DOE'
    ];

    $mailService = new \App\Services\MailService();
    $mailService->sendTestimonialConfirmationEmail($testData);

    return 'Email de confirmation de témoignage envoyé au client';
});
