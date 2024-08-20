<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'subject' => 'required|string|min:2',
            'message' => 'required|string|min:10',
            'consent' => 'required|boolean',
        ]);

        // Envoi de l'email au développeur avec les détails de la demande de contact
        Mail::send('emails.contact', [
            'from_name' => $data['firstName'] . ' ' . $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => $data['subject'],
            'userMessage' => $data['message'],
        ], function ($message) use ($data) {
            $message->to('contact@davidwebprojects.fr')
                ->subject('Formulaire de contact de : ' . $data['firstName'] . ' ' . $data['lastName'])
                ->replyTo($data['email'], $data['firstName'] . ' ' . $data['lastName']);
        });

        // Envoi d'une confirmation automatique à l'utilisateur
        Mail::send('emails.confirmation', [
            'from_name' => $data['firstName'] . ' ' . $data['lastName']
        ], function ($message) use ($data) {
            $message->to($data['email'])
                ->subject('Confirmation de votre demande de contact');
        });

        return response()->json(['message' => 'Email envoyé avec succès!'], 200);
    }
}
