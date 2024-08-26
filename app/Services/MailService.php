<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Envoyer un email de contact.
     *
     * @param string $email L'adresse email du destinataire
     * @param string $message Le message de contact
     * @return void
     */
    public function sendContactEmail($email, $message)
    {
        $data = ['message' => $message];

        Mail::send('emails.contact', $data, function ($message) use ($email) {
            $message->to($email)
                ->subject('Contact Form Submission');
        });
    }

    /**
     * Envoyer un email de confirmation au client pour la demande de devis.
     *
     * @param string $email L'adresse email du client
     * @param string $fullName Le nom complet du client
     * @param string $formule La formule choisie par le client
     * @return void
     */
    public function sendProposalConfirmationEmail($email, $fullName, $formule)
    {
        $data = [
            'fullName' => $fullName,
            'formule' => $formule,
        ];

        Mail::send('emails.proposal_confirmation', $data, function ($message) use ($email, $fullName) {
            $message->to($email)
                ->subject('Confirmation de votre demande de devis');
        });
    }

    /**
     * Envoyer un email à l'administrateur avec les détails du devis.
     *
     * @param array $data Les données du devis soumis
     * @return void
     */
    public function sendProposalNotificationEmail(array $data)
    {
        Mail::send('emails.proposal_notification', $data, function ($message) use ($data) {
            $message->to('contact@davidwebprojects.fr')
                ->subject('Nouvelle demande de devis de ' . $data['firstName'] . ' ' . $data['lastName']);
        });
    }
}
